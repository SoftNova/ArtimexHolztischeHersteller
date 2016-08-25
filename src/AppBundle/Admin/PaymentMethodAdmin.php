<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 8/16/2016
 * Time: 8:15 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaymentMethodAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('admin.translations')
            ->add('translations', TranslationsType::class,
                array(
                    'label' => false,
                    'fields' => array(
                        'name' => array('field_type' => TextType::class,
                            'label'=>'admin.normal.name',
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('required' => true)
                                )
                            )
                        ),
                        'description' => array('field_type' => 'ckeditor',
                            'label'=>'admin.description',
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('readonly' => true,
                                        'disabled' => true)
                                )
                            )
                        , 'required' => false)
                        )
                )
            )
            ->add('modifier', PercentType::class, array('label' => 'admin.cost.variance', 'type'=>'integer', 'scale'=>2))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', 'text', array('label'=>'ID'))
            ->add('adminName.name', null, array(
                'label' => 'admin.name',
                'sortable'=>true,
                'sort_field_mapping'=>array('fieldName'=>'name'),
                'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
            ))
            ->add('modifier', 'text', array(
                'label' => 'admin.cost.variance',
                'editable'=>true
            ))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
    }

}