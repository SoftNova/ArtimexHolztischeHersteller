<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/3/2016
 * Time: 1:38 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TableCategoryAdmin extends Admin
{
    /**
     * @param FormMapper $form
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('translations', TranslationsType::class,
            array(
                'label' => false,
                'fields' => array(
                    'name' => array('field_type' => TextType::class,
                        'label' => 'admin.normal.name',
                        'locale_options' => array(
                            'admin' => array(
                                'attr' => array('required' => true)
                            )
                        )
                    ),
                )
            )
        )
            ->add('visibility', CheckboxType::class, array('required' => false));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('adminName.name', null, array(
            'label' => 'admin.name',
            'sortable' => true,
            'sort_field_mapping' => array('fieldName' => 'name'),
            'sort_parent_association_mappings' => array(array('fieldName' => 'translations'))
        ))
            ->add('visibility', 'boolean', array(
                'editable' => true,
                'label' => 'admin.show.in.catalog'
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