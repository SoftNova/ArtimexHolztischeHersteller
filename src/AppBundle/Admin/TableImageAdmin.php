<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/14/2016
 * Time: 12:50 AM
 */

namespace AppBundle\Admin;


use AppBundle\Validator\ImgConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class TableImageAdmin extends Admin
{
    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())
            ->end();
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $options = array('required' => false,
            'image_path' => 'webPath',
            'label' => false);
        $formMapper
            ->add('file', FileType::class, $options)
            ->add('materialItem', 'sonata_type_model', array('btn_add' => false))
            ->add('role', CheckboxType::class, array('label' => "admin.image.primary", 'required' => false));
    }


}