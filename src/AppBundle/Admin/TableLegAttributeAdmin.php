<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 2:54 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class TableLegAttributeAdmin extends  Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('basePrice', MoneyType::class, array('label' => 'Leg base price'))
            ->add ('variance', PercentType::class, array('label' => 'Variance percentage', 'type'=>'integer', 'scale'=>2))
            ->add ('profiles', 'text', array('label' => 'Example: 9x9, 9x10, 10x10. Leave empty in case the leg is profileless'));
    }
}