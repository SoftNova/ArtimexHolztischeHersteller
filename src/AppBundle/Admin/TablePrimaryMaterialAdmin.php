<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 3:27 PM
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class TablePrimaryMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('pricePerSquareMeter', MoneyType::class, array('label'=>'Price per square meter'))
            ->add('primaryMaterial', 'sonata_type_model');
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('primaryMaterial.adminName.name', 'sonata_type_model', array('label'=>'admin.primary.material',
                'sortable'=>true,
                'sort_field_mapping'=>array('fieldName'=>'id'),
                'sort_parent_association_mappings'=>array(array('fieldName'=>'primaryMaterial'))))
            ->add('pricePerSquareMeter', 'currency', array(
                    'label'=>'admin.price.per.square.meter',
                    'editable'=>true,
                    'row_align'=>'left',
                    'currency'=>'€'
                )
            )
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
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


    protected function configureRoutes(RouteCollection $collection)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em=$this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
        $hasPrimary=(count($em->findAll())==0) ? false : true;
        if ($hasPrimary==true) {
            if ($container->get('request')->get('_route') == 'sonata_admin_dashboard') {
                $collection->remove('create');
            }
        }
    }
}