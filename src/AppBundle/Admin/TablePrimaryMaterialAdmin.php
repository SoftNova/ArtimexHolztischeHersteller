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
class TablePrimaryMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('pricePerSquareMeter', MoneyType::class, array('label'=>'Price per square meter'))
            ->add('primaryMaterial', TypeModel::class);
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
        $listMapper
            ->add('primaryMaterial', 'sonata_type_model')
            ->add('pricePerSquareMeter', MoneyType::class, array(
                    'label'=>'Price per square meter (€)',
                    'sortable'=>true
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