<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 11:20 PM
 */

namespace AppBundle\Admin;


use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add("name")
            ->add("cost");
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add("name")
        ->add("cost");
    }


}