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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
class TableHeightAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('height_lower_bound', IntegerType::class, array('label'=>'Minimum leg height'))
            ->add('height_upper_bound', IntegerType::class, array('label'=>'Maximum leg height'))
            ->add('step',IntegerType::class, array('label'=>'Interval range'))
            ->add('costPerStep', MoneyType::class, array('label'=>'Cost increase with interval'));
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
        $listMapper->add('height_lower_bound', IntegerType::class, array(
                    'label'=>'Minimum leg height',
                    'sortable'=>true
                )
             )
            ->add('height_upper_bound', IntegerType::class, array(
                    'label'=>'Maximum leg height',
                    'sortable'=>true
                )
            )
            ->add('step',IntegerType::class, array(
                    'label'=>'Interval range',
                    'sortable'=>true
                )
            )
            ->add('costPerStep', MoneyType::class, array('label'=>'Cost increase with interval (€)'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
    }
}