<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/20/2016
 * Time: 10:07 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Product;
use AppBundle\Repository\ProductDAO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\Translator;

class ArticleService
{

    private $productDAO;
    private $request;
    protected $translator;
    
    public function __construct(ProductDAO $repo, RequestStack $requestStack, Translator $translator)
    {
        $this->request=$requestStack->getCurrentRequest();
        $this->productDAO = $repo;
        $this->translator = $translator;
    }

    public function getAll(){
        return $this->productDAO->findAll();
    }
    
    public function getAllByLang(){
        $lang=$this->request->getLocale();
        return $this->productDAO->findAllByLang($lang);
    }
    public function findByCode($code){
        $lang=$this->request->getLocale();
        return $this->productDAO->findByCode($code, $lang);
    }

    private function computePrice(Product $articleItem)
    {

        $price = $articleItem->getPrice();
        /* final by state variance price */
        /** @noinspection PhpUndefinedMethodInspection */
        $price = round($price + ($articleItem->getByStateVariance() / 100 * $price));

        $currency = $this->translator->trans('app.currency');
        $stringPrice = $currency . strval($price) . ",00";

        return $stringPrice;
    }

    public function calculateArticlePrice(){
        $code = $this->request->get('code');
        $articleItem = $this->findByCode($code);

        $finalPrice = $this->computePrice($articleItem);
        return new JsonResponse(['success' => $finalPrice]);
    }

    public function getArticleObject()
    {
        $code = $this->request->get('code');
        $articleItem = $this->findByCode($code);
        return $articleItem;
    }
}