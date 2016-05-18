<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 2:54 PM
 */

namespace AppBundle\Admin;

use AppBundle\Utils\ProfileConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TableLegAttributeAdmin extends  Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('basePrice', MoneyType::class, array('label' => 'admin.base.price'))
            ->add ('variance', PercentType::class, array('label' => 'admin.variance.percentage', 'type'=>'integer', 'scale'=>2))
            ->add ('profiles', TextType::class, array('label' => 'admin.leg.profiles.create','required'=>false));
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('profiles')
            ->addConstraint(new ProfileConstraint())
            ->end();
    }
}