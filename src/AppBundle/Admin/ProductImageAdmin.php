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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $options = array('required'=>false,
                        'image_path'=>'webPath');
        $formMapper
            ->add('file', FileType::class, $options)
            ->add('role', CheckboxType::class, array('label'=>"admin.image.primary", 'required'=>false))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())
            ->end();
    }


}