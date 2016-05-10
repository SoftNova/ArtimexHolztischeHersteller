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
                ->add('isTempered', CheckboxType::class, array('label' => 'Is this material already improved?', 'required' => false))
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('translations',null, array(
                'label'=>'Name [En, Fr, De, Ro]',
                'sortable'=>true
                )
            )
            ->add('percentage', PercentType::class, array(
                    'label'=>'Cost variance (%)',
                    'type'=>'integer',
                    'scale'=>2
                 )
            )
            ->add('getStringIsTempered', 'string', array(
                    'label' => 'Is this material already improved?',
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