<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/9/2016
 * Time: 4:34 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
class TableTimberQualityAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Translations')
            ->add('translations','a2lix_translations', array('label'=>false))
            ->end()
            ->with('General')
            ->add('costIncrease', PercentType::class, array('label' => 'Cost variance', 'type'=>'integer', 'scale'=>2))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('toAdmin', null, array(
                'label' => 'Admin Name',
                'sortable' =>true
            ))
            ->add('getLocale',null, array(
                    'label'=>'Name [En, Fr, De, Ro]',
                    'sortable'=>true
                )
            )
            ->add('costIncrease', PercentType::class, array(
                    'label' => 'Cost variance (%)',
                    'type'=>'integer',
                    'scale'=>2,
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