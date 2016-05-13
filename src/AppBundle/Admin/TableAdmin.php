<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 1:42 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class TableAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Table')
            ->add('translations',TranslationsType::class,
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
                        ,'message' =>array('field_type'=>'text',
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
                ->add('basePrice', MoneyType::class, array('label' => 'Table base price'))
                ->add('hasExtension', CheckboxType::class, array('label' => 'Does this table offer extensions?', 'required'=>false))
                ->add('hasDistanceToSides', CheckboxType::class, array('label' => 'Does this table have distance to sides configuration?', 'required'=>false))
            ->end()
            ->with('Drawers')
                ->add('drawerAttribute', AdminType::class, array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ->with('Leg Profiles')
                ->add('legAttribute', AdminType::class, array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ->with ('Visibility')
                ->add('showInCatalog', CheckboxType::class, array('label' => 'Should this item be visible in the catalog? (You can enable it later)', 'required'=>false))
            ->end();
        ;


    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $locales=$this->getConfigurationPool()->getContainer()->getParameter('locales');
        $listMapper
            ->addIdentifier('translate.getName', null, array(
                'label' => 'Admin Name',
                'locales'=>array('en')
            ))
            ->add('getLocales','text', array(
                    'label'=>'Available in',
                     
                    'parameters'=>array($locales)
                )
            )
            ->add('showInCatalog','boolean',array(
                 'editable' => true,
                'label'=>'Is visible in catalog'
            ))
            ->add('basePrice','currency',array(
                'currency'=>'€',
                'editable'=>true
            ))
            ->add('hasExtension','boolean',array(
                'editable'=>true,
                'label'=>'Offers extensions'
            ))
            ->addIdentifier('drawerAttribute.maxNumberOfDrawers', null,array(
                'label'=>'Offers drawers'
            ))
            ->add('hasDistanceToSides','boolean',array(
                'editable'=>true,
                'label'=>'Offers distance to sides'
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