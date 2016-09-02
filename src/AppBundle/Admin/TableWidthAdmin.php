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


class TableWidthAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('width_lower_bound', IntegerType::class, array('label' => 'admin.min.width'))
            ->add('width_upper_bound', IntegerType::class, array('label' => 'admin.max.width'));
    }


    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('width_lower_bound', IntegerType::class, array(
                'label' => 'admin.min.width',
            )
        )
            ->add('width_upper_bound', IntegerType::class, array(
                    'label' => 'admin.max.width',
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

}