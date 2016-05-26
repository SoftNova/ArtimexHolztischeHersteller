<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/26/2016
 * Time: 9:38 PM
 */

namespace AppBundle\Admin;


use AppBundle\Utils\ProfileConstraint;
use Sonata\AdminBundle\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TableLegProfileAdmin extends Admin\Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add ('variance', MoneyType::class, array('label' => 'admin.variance.static'))
            ->add ('profile', TextType::class, array('label' => 'admin.leg.profiles.create'));
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('profile')
            ->addConstraint(new ProfileConstraint())
            ->end();
    }
}