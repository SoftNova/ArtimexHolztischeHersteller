<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 10:48 AM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;


class TableWidthAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('width_lower_bound', IntegerType::class, array('label'=>'admin.min.width'))
            ->add('width_upper_bound', IntegerType::class, array('label'=>'admin.max.width'));
    }

    
    protected function configureRoutes(RouteCollection $collection)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $em=$this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
        $hasPrimary=(count($em->findAll())==0) ? false : true;
        if ($hasPrimary) {
            if ($container->get('request')->get('_route') == 'sonata_admin_dashboard') {
                $collection->remove('create');
            }
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('width_lower_bound', IntegerType::class, array(
                    'label'=>'admin.min.width',
                )
            )
            ->add('width_upper_bound', IntegerType::class, array(
                    'label'=>'admin.max.width',
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