<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 2:41 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;


class TableDrawerAttributeAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('basePrice', MoneyType::class, array('label' => 'admin.base.price', 'required' => false))
            ->add('maxNumberOfDrawers', IntegerType::class, array('label' => 'admin.max.drawers', 'required' => false));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('maxNumberOfDrawers')
            ->add('basePrice', 'currency', array(
                'currency' => '€',
                'editable' => true,
                'row_align' => 'left',
            ))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
    }


}