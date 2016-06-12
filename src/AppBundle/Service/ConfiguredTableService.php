<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/10/2016
 * Time: 7:24 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Table;
use AppBundle\Entity\TableHeight;
use AppBundle\Entity\TableLegProfile;
use AppBundle\Entity\TableMaterial;
use AppBundle\Entity\TableMaterialTempering;
use AppBundle\Entity\TablePrimaryMaterial;
use AppBundle\Entity\TableTimberQuality;
use AppBundle\Entity\TableTranslation;
use AppBundle\Repository\TableDAO;
use AppBundle\Repository\TableHeightDAO;
use AppBundle\Repository\TableLegProfileDAO;
use AppBundle\Repository\TableLengthDAO;
use AppBundle\Repository\TableMaterialDAO;
use AppBundle\Repository\TablePrimaryMaterialDAO;
use AppBundle\Repository\TableTimberQualityDAO;
use AppBundle\Repository\TableWidthDAO;
use AppBundle\Repository\TimberTemperingDAO;
use AppBundle\Utils\Utils;
use AppBundle\Validator\SpecsValidator;
use AppBundle\Validator\SupportValidator;
use AppBundle\Validator\SurfaceValidator;
use AppBundle\ValueObject\ConfiguredTablePriceVO;
use AppBundle\ValueObject\WHatever;
use Doctrine\Common\Collections\ArrayCollection;
use Liip\ImagineBundle\Controller\ImagineController;
use Liip\ImagineBundle\LiipImagineBundle;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\Translator;

class ConfiguredTableService
{
    protected $surfaceService;
    protected $supportService;
    protected $timberService;
    protected $imgService;
    protected $request;
    protected $tableService;
    protected $configuredPriceHandlerFactory;
    protected $translator;

    public function __construct(SurfaceService $surfaceService, TableSupportService $supportService,
                     TimberSpecsService $timberService,
                                ImagineController $imgService,
                                RequestStack $requestStack,
                                TableService $tableService,
                                ConfiguredPriceHandlerFactory $cphFactory,
                                Translator $translator)
    {
        $this->request=$requestStack->getCurrentRequest();
        $this->surfaceService=$surfaceService;
        $this->supportService=$supportService;
        $this->timberService=$timberService;
        $this->imgService=$imgService;
        $this->tableService=$tableService;
        $this->configuredPriceHandlerFactory= $cphFactory;
        $this->translator=$translator;
    }

    public function getPrimaryMaterial()
    {
        $primaryMaterialItem = $this->surfaceService->getPrimaryMaterial();
        $primaryMaterial = !is_null($primaryMaterialItem) ? $primaryMaterialItem->getPrimaryMaterial()->getId() : null;
        return $primaryMaterial;
    }

    public function getAllTablesByLang($categoryId)
    {
        $lang = $this->request->getLocale();
        return $this->tableService->getAllByLang($lang, $categoryId);
    }


    /**
     * @param $code
     * @return Table
     */
    public function findTableByCode($code)
    {
        $lang = $this->request->getLocale();
        return $this->tableService->findByCode($code,$lang);
    }

    public function getUniqueHeight()
    {
        return $this->surfaceService->getHeight();
    }

    public function getUniqueWidth()
    {
        return $this->surfaceService->getWidth();
    }

    public function getUniqueLength()
    {
        return $this->surfaceService->getLength();
    }

    public function getAllTimberQualityByLang()
    {
        $lang = $this->request->getLocale();
        return $this->timberService->getAllTimberQualityByLang($lang);
    }

    public function getAllTimberTemperingByLang()
    {
        $lang = $this->request->getLocale();
        return $this->timberService->getAllTimberTemperingByLang($lang);
    }

    /**
     * @param Table $table
     * @return TableMaterial
     */
    public function getAllTableSpecificMaterials(Table $table)
    {
        $lang = $this->request->getLocale();
        $result = $this->surfaceService->findTableSpecificMaterials($lang, $table->getId());

        $altPath = Utils::DEFAULT_IMAGE;
        foreach ($result as $material) {
            /** @var  TableMaterial $material*/
            $image = $this->imgService->filterAction(new Request(), (is_null($material->getImage()->getWebPath()) ? $altPath : $material->getImage()->getWebPath()), 'materialPopup')->getTargetUrl();
            $material->getImage()->setCachePath($image);
        }
        return $result;
    }
    
    
    public function calculatePrice(){
        $tableConfigs = $this->configuredPriceHandlerFactory->create();
        $code = $this->request->get('code');
        $tableItem = $this->findTableByCode($code);

        $errors = array();
        $errors = array_merge($errors, $this->validateSurface($tableConfigs)->toArray());
        $errors = array_merge($errors, $this->validateSupport($tableConfigs, $tableItem->getProfiles())->toArray());
        $errors = array_merge($errors, $this->validateSpecs($tableConfigs)->toArray());

        if (!empty($errors)) {
            return new JsonResponse(['error' => end($errors)]);
        }

        $finalPrice = $this->computePrice($tableConfigs, $tableItem);

        if ($finalPrice===false){
            $custom = $this->translator->trans('app.custom.order');
            return new JsonResponse(['failure' => $custom]);
        }
        return new JsonResponse(['success' => $finalPrice]);


    }

    private function computePrice(ConfiguredTablePriceVO $tableConfigs, Table $tableItem)
    {

        $supportPrice = $this->supportService->calculateSupportPrice($tableConfigs, $tableItem);
        $extensionPrice = $this->surfaceService->calculateExtensionSurface($tableConfigs);
        $drawerPrice = $this->surfaceService->calculateDrawerSurface($tableConfigs, $tableItem);

        $surfacePrice = $this->surfaceService->calculateSurface($tableConfigs);
        if ($surfacePrice == false)  return false;
        
        $tablePrice = $surfacePrice + $supportPrice + $extensionPrice + $drawerPrice;
        $tablePrice = $this->timberService->applyQualityVariance($tablePrice, $tableConfigs);
        $tablePrice = $this->timberService->applyTemperingVariance($tablePrice, $tableConfigs);

        /* final by state variance price */
        /** @noinspection PhpUndefinedMethodInspection */
        $tablePrice = round($tablePrice + ($tableItem->getByStateVariance() / 100 * $tablePrice));

        $currency = $this->translator->trans('app.currency');
        $stringPrice = $currency . strval($tablePrice) . ",00";

        return $stringPrice;
    }

    private function validateSurface(ConfiguredTablePriceVO $tableConfigs)
    {
        $errors = new ArrayCollection();
        $lengthObject = $this->surfaceService->getLength();
        $widthObject = $this->surfaceService->getWidth();
        $material = $this->surfaceService->getMaterialById($tableConfigs->getMaterial());

        $result = SurfaceValidator::validateSurface($tableConfigs, $material, $lengthObject, $widthObject);
        if (!is_null($result)) $errors->add($result);
        return $errors;
    }

    private function validateSupport(ConfiguredTablePriceVO $tableConfigs, $profileObjectsArray)
    {
        $errors = new ArrayCollection();
        $heightObject = $this->surfaceService->getHeight();
        $result = SupportValidator::validateSupport($tableConfigs, $heightObject, $profileObjectsArray);
        if (!is_null($result)) $errors->add($result);
        return $errors;

    }

    private function validateSpecs(ConfiguredTablePriceVO $tableConfigs)
    {
        $errors = new ArrayCollection();
        $quality = $this->timberService->getTimberQualityById($tableConfigs->getQuality());
        $tempering = $this->timberService->getTimberTemperingByid($tableConfigs->getTempering());
        $result = SpecsValidator::validateSpecs($quality, $tempering);
        if (!is_null($result)) $errors->add($result);
        return $errors;
    }

    public function getConfiguredTablePriceVO(){
        return $this->configuredPriceHandlerFactory->create();
    }
    
    /** @return Table */
    public function getTableObject(){
        $code = $this->request->get('code');
        $tableItem = $this->findTableByCode($code);
        return $tableItem;
    }

    public function getPrimaryImageByMaterial()
    {
        $code = $this->request->get('itemCode');
        $material = $this->request->get('material');
        $tableItem = $this->tableService->findPrimaryImageByMaterial($material, $code);
        $altPath = Utils::DEFAULT_IMAGE;
        $image = $this->imgService
            ->filterAction(new Request(), (is_null($tableItem) ? $altPath : $tableItem->getFirstImage()->getWebPath()), 'productDisplay')->getTargetUrl();
        return new JsonResponse($image);

    }
}