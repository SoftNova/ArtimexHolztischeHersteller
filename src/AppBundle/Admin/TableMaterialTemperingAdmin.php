<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 3:43 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Form\FormMapper;

class TableMaterialTemperingAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
            ->add('translations','a2lix_translations', array('label'=>false))
            ->end()
            ->with('General')
            ->add('costIncrease', PercentType::class, array('label' => 'Cost increase', 'type'=>'integer', 'scale'=>2))
            ->end();
    }
}