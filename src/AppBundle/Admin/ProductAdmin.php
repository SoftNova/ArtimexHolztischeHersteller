<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 11:20 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
                ->add('translations','a2lix_translations',
                    array(
                        'label'=>'',
                        'fields' => array(
                            'name' => array('field_type'=>'text'),
                            'description' => array('field_type'=>'text'),
                            'byStateVariance' => array(
                             'field_type'=>PercentType::class, 'type'=>'integer'
                            )
                        )
                    )
                )
            ->end()
            ->with('General')
                ->add('price', MoneyType::class, array('label' => 'Table base price'))
            ->end();

    }
}