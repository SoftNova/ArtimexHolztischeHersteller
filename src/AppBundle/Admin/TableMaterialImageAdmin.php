<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/17/2016
 * Time: 2:37 PM
 */

namespace AppBundle\Admin;


use AppBundle\Utils\ImgConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TableMaterialImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->add('file', FileType::class, array('required'=>false, 'image_path'=>'webPath', 'label'=>false));
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())
            ->end();
    }

}