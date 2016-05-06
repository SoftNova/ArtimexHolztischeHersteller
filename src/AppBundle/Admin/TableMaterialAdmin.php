<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 2:10 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class TableMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {

        $form->with('')
                ->add('translations','a2lix_translations')
            ->end()
            ->with('General')
                ->add('percentage', PercentType::class, array('label'=>'Cost modifier based on primary material', 'type'=>'integer'))
                ->add('isTempered', CheckboxType::class, array('label' => 'Is this material already improved?', 'required' => false))
            ->end();
    }
}