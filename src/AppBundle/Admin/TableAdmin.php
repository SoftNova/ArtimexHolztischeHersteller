<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 1:42 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TableAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Table')
               ->add('translations','a2lix_translations', array('label'=>false))
                ->end()
            ->with('General')
                ->add('basePrice', MoneyType::class, array('label' => 'Table base price'))
                ->add('hasExtension', CheckboxType::class, array('label' => 'Does this table offer extensions?', 'required'=>false))
                ->add('hasDistanceToSides', CheckboxType::class, array('label' => 'Does this table have distance to sides configuration?', 'required'=>false))
            ->end()
            ->with('Drawers')
                ->add('drawerAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'add' => 'inline',
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ->with('Leg Profiles')
                ->add('legAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'add' => 'inline',
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ;


    }

}