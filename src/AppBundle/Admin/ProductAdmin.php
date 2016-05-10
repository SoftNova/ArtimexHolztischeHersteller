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
use Sonata\AdminBundle\Show\ShowMapper;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
                ->add('translations','a2lix_translations',
                    array(
                        'label'=>false,
                        'fields' => array(
                            'name' => array('field_type'=>'text'),
                            'description' => array('field_type'=>'text',
                                'locale_options'=>array(
                                    'admin'=>array(
                                        'attr'=>array('readonly' =>true,
                                            'disabled'=>true)
                                    )
                                )),
                            'byStateVariance' => array(
                            'field_type'=>PercentType::class, 'type'=>'integer', 'scale'=>2,
                                'locale_options'=>array(
                                    'admin'=>array(
                                        'attr'=>array('readonly' =>true,
                                            'disabled'=>true)
                                    )
                                  )
                            )
                        )
                    )
                )
            ->end()
            ->with('General')
                ->add('price', MoneyType::class, array('label' => 'Table base price'))
            ->end();

    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('translations',null, array(
                'label'=>'Name [En, Fr, De, Ro]',
                'sortable'=>true
                )
            )
            ->add('price',null,array(
                'label'=>'Price (€)'
            ))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            )
        ;
    }

}