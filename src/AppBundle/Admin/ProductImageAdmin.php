<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 1:37 PM
 */

namespace AppBundle\Admin;


use AppBundle\Utils\ImgConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();
        $fileFieldOptions = array('required' => false);
        if (!is_bool($image)) {
            if (!is_null($image->getFilename())) {
                if ($webPath = $image->getWebPath()) {
                    $container = $this->getConfigurationPool()->getContainer();
                    $fullPath = $container->get('request')->getBasePath() . '/' . $webPath;
                    $fileFieldOptions['help'] = '<img src="' . $fullPath . '" class="admin-preview" />';
                }
            }
        }
        $formMapper
            ->add('file', FileType::class, $fileFieldOptions)
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())
            ->end();
    }


}