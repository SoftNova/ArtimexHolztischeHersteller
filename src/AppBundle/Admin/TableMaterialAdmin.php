<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 2:10 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\TableMaterial;
use AppBundle\Entity\TableMaterialImage;
use AppBundle\Utils\Utils;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TableMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $subject = $this->getSubject();
        $form->with('app.material')
                ->add('translations',TranslationsType::class, array('label'=>false))
            ->end()
            ->with('admin.general')
                ->add('code',TextType::class, $this->isCreate($subject))
                ->add('percentage', PercentType::class, array('label'=>'admin.cost.of.primary', 'type'=>'integer', 'scale'=>2))
                ->add('scalingPoint', NumberType::class, array('label'=>'admin.scaling.point', 'required' => false))
                ->add('scalingPercentage', PercentType::class, array('label'=>'admin.scaling.variance', 'type'=>'integer', 'scale'=>2, 'required' => false))
                ->add('isTempered', CheckboxType::class, array('label' => 'admin.material.improved', 'required' => false))
            ->end()
            ->with ('admin.images')
                ->add('image', 'sonata_type_admin', array('label'=>false))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('code', 'text', array('label'=>'admin.code'))
            ->add('adminName.name', null, array(
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
            ->add('percentage', 'text', array(
                    'label'=>'admin.cost.variance',
                    'editable'=>true
                 )
            )

            ->add('scalingPoint', 'string', array(
                    'label' => 'admin.scaling.point',
                    'editable'=>true
                )
            )
            ->add('scalingPercentage', 'string', array(
                    'label' => 'admin.scaling.variance',
                    'editable'=>true
                )
            )
            ->add('isTempered', 'boolean', array(
                    'label' => 'admin.material.improved',
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
        ->add('isTempered')
        ->add('code');
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

    private function bindImages(TableMaterial $object)
    {
        /** @var TableMaterialImage $image */
        $object->getImage()->setMaterialItem($object);
        $object->getImage()->refreshUpdated();
    }
    public function prePersist($object)
    {
        $this->bindImages($object);
    }

    public function preUpdate($object)
    {
        $this->bindImages($object);
    }

    private function isCreate(TableMaterial $subject){
        if (is_null($subject->getCode())){
            return  array('label'=>'admin.code',
                'read_only'=>true,
                'data'=>Utils::generateItemCodeString(10, TableMaterial::class));
        }
        return array('label'=>'admin.code',
            'read_only'=>true
        );
    }

}