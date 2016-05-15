<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/14/2016
 * Time: 12:50 AM
 */

namespace AppBundle\Admin;


use AppBundle\Utils\ImgConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\CoreBundle\Validator\ErrorElement;

class TableImageAdmin extends  Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', FileType::class, array(
                'required' => false
            ))
            ->add('materialItem', 'sonata_type_model', array('btn_add'=>false))
            ->add('role', CheckboxType::class, array('label'=>"Is this a primary image?", 'required'=>false))
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())->end();
    }

}