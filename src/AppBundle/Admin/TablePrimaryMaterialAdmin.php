<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 3:27 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class TablePrimaryMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('pricePerSquareMeter', MoneyType::class, array('label' => 'admin.price.per.square.meter'))
            ->add('primaryMaterial', 'sonata_type_model', array('label' => 'admin.primary.material'));
    }


    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('primaryMaterial.adminName.name', 'sonata_type_model', array('label' => 'admin.primary.material',
                'sortable' => true,
                'sort_field_mapping' => array('fieldName' => 'id'),
                'sort_parent_association_mappings' => array(array('fieldName' => 'primaryMaterial'))))
            ->add('pricePerSquareMeter', 'currency', array(
                    'label' => 'admin.price.per.square.meter',
                    'editable' => true,
                    'row_align' => 'left',
                    'currency' => '€'
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


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }
}