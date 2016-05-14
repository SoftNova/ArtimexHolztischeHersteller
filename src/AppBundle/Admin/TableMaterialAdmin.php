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
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
class TableMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {

        $form->with('')
                ->add('translations',TranslationsType::class, array('label'=>false))
            ->end()
            ->with('General')
                ->add('percentage', PercentType::class, array('label'=>'Cost modifier based on primary material', 'type'=>'integer', 'scale'=>2))
                ->add('scalingPoint', NumberType::class, array('label'=>'Value (in square meters) after which price scaling applies', 'required' => false))
                ->add('scalingPercentage', PercentType::class, array('label'=>'Value of scaling', 'type'=>'integer', 'scale'=>2, 'required' => false))
                ->add('isTempered', CheckboxType::class, array('label' => 'Is this material already improved?', 'required' => false))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('adminName.name', null, array(
                'label' => 'Admin Name',
            ))
            ->add('locales',null, array(
                    'label'=>'Available in',
                )
            )
            ->add('percentage', 'text', array(
                    'label'=>'Cost variance (%)',
                    'editable'=>true
                 )
            )

            ->add('scalingPoint', 'string', array(
                    'label' => 'Scaling point (Square meters)',
                    'editable'=>true
                )
            )
            ->add('scalingPercentage', 'string', array(
                    'label' => 'Scaling variance (%)',
                    'editable'=>true
                )
            )
            ->add('isTempered', 'boolean', array(
                    'label' => 'Material improved',
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
        ])
        ->add('isTempered');
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