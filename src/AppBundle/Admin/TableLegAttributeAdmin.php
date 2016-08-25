<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 2:54 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class TableLegAttributeAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('basePrice', MoneyType::class, array('label' => 'admin.base.price'));
    }
}