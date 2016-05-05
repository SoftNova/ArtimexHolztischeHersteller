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

class TablePrimaryMaterialAdmin extends  Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('pricePerSquareMeter', MoneyType::class, array('label'=>'Price per square meter'))
            ->add('primaryMaterial', 'sonata_type_model');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $em=$this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository($this->getClass());
        $hasPrimary=(count($em->findAll())==0) ? false : true;
        if ($hasPrimary) {
            $collection->remove('create');
        }
    }
}