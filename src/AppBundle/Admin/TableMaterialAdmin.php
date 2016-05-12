<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 2:10 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Datagrid\ListMapper;
class TableMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {

        $form->with('')
                ->add('translations','a2lix_translations', array('label'=>false))
            ->end()
            ->with('General')
                ->add('percentage', PercentType::class, array('label'=>'Cost modifier based on primary material', 'type'=>'integer', 'scale'=>2))
                ->add('scalingPoint', 'number', array('label'=>'Value (in square meters) after which price scaling applies', 'required' => false))
                ->add('scalingPercentage', PercentType::class, array('label'=>'Value of scaling', 'type'=>'integer', 'scale'=>2, 'required' => false))
                ->add('isTempered', CheckboxType::class, array('label' => 'Is this material already improved?', 'required' => false))
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
            ->add('percentage', PercentType::class, array(
                    'label'=>'Cost variance (%)',
                    'type'=>'integer',
                    'scale'=>2
                 )
            )
            ->add('getStringIsTempered', 'string', array(
                    'label' => 'Material improved',
                    'sortable'=>true
                )
            )
            ->add('scalingPoint', 'string', array(
                    'label' => 'Scaling point (Square meters)',
                    'sortable'=>true
                )
            )
            ->add('scalingPercentage', 'string', array(
                    'label' => 'Scaling variance (%)',
                    'sortable'=>true
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
}