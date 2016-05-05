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

class TableMaterialAdmin extends Admin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name','text' , array('label' => 'Material name'))
            ->add('percentage', 'number', array('label'=>'Cost modifier (% of primary material)'
                                                ,'data'=>100));
    }
}