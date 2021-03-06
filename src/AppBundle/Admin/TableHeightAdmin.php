<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 10:48 AM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class TableHeightAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('height_lower_bound', IntegerType::class, array('label' => 'admin.min.height'))
            ->add('height_upper_bound', IntegerType::class, array('label' => 'admin.max.height'))
            ->add('step', IntegerType::class, array('label' => 'admin.step'))
            ->add('costPerStep', PercentType::class, array('label' => 'admin.cost.per.step', 'type' => 'integer', 'scale' => 2));
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('height_lower_bound', IntegerType::class, array(
                'label' => 'admin.min.height',
            )
        )
            ->add('height_upper_bound', IntegerType::class, array(
                    'label' => 'admin.max.height',
                )
            )
            ->add('step', 'number', array(
                    'label' => 'admin.step',
                    'editable' => true
                )
            )
            ->add('costPerStep', 'text', array(
                'label' => 'admin.cost.per.step',
                'editable' => true,
                'row_align' => 'left'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
    }
}