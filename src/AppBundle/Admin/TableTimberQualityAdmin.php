<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 4:34 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class TableTimberQualityAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('admin.translations')
            ->add('translations',TranslationsType::class,
                array(
                    'label'=>false,
                    'fields' => array(
                        'name' => array('field_type'=>TextType::class,
                            'label'=>'admin.normal.name')
                    )
                )
            )
            ->end()
            ->with('admin.general')
            ->add('costIncrease', PercentType::class, array('label' => 'admin.cost.variance', 'type'=>'integer', 'scale'=>2))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('adminName.name', null, array(
                'label' => 'admin.name',
                'sortable'=>true,
                'sort_field_mapping'=>array('fieldName'=>'name'),
                'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
            ))
            ->add('locales','text', array(
                    'label'=>'admin.available.in',
                    'sortable'=>true,
                    'sort_field_mapping'=>array('fieldName'=>'locale'),
                    'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
                )
            )
            ->add('costIncrease', 'text', array(
                    'label' => 'admin.cost.variance',
                    'editable'=>true
                )
            )
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('translations.locale', 'doctrine_orm_choice', [
            'label' => 'Language',
            'field_options' => [
                'required' => false,
                'choices' => $this->getLanguageChoices(),
                'multiple'=>true,
                'expanded'=>false
            ],
            'field_type' => 'choice'
        ]);
    }

    private function getLanguageChoices()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $availableLocales = $container->getParameter('locales');
        $languageChoices = [];
        foreach ($availableLocales as $locale) {
            $languageChoices[$locale] = $locale;
        }
        return $languageChoices;
    }
}