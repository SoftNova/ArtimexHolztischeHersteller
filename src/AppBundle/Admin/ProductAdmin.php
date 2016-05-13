<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 11:20 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
                ->add('translations', TranslationsType::class,
                    array(
                        'label'=>false,
                        'fields' => array(
                            'name' => array('field_type'=>TextType::class),
                            'description' => array('field_type'=>TextType::class,
                                'locale_options'=>array(
                                    'admin'=>array(
                                        'attr'=>array('readonly' =>true,
                                            'disabled'=>true)
                                    )
                                )
                            ,'required'=>false),
                            'byStateVariance' => array(
                            'field_type'=>PercentType::class, 'type'=>'integer', 'scale'=>2,
                                'locale_options'=>array(
                                    'admin'=>array(
                                        'attr'=>array('readonly' =>true,
                                            'disabled'=>true)
                                    )
                                  )
                            ,'required'=>false
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
        $locales=$this->getConfigurationPool()->getContainer()->getParameter('locales');
        $listMapper
            ->addIdentifier('toAdmin', null, array(
                'label' => 'Admin Name',
                'sortable' =>true
            ))
            ->add('getLocales','text', array(
                    'label'=>'Available in',
                    
                    'parameters'=>array($locales)
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