<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 3:43 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;

class TableMaterialTemperingAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
            ->add('translations',TranslationsType::class, array('label'=>false))
            ->end()
            ->with('General')
            ->add('costIncrease', PercentType::class, array('label' => 'Cost variance', 'type'=>IntegerType::class, 'scale'=>2))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $locales=$this->getConfigurationPool()->getContainer()->getParameter('locales');
        $listMapper
            ->addIdentifier('toAdmin', null, array(
                'label' => 'Admin Name',
                'sortable' =>true
            ))
            ->add('getLocales',null, array(
                    'label'=>'Available in',
                    'sortable'=>true,
                    'parameters'=>array($locales)
                )
            )
            ->add('costIncrease', PercentType::class, array('label' => 'Cost variance (%)', 'type'=>'integer', 'scale'=>2))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            )
        ;
    }
}