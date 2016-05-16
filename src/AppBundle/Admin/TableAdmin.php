<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/27/2016
 * Time: 1:42 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Entity\Table;
use AppBundle\Entity\TableImage;
use AppBundle\Utils\Utils;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;


class TableAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );
    protected function configureFormFields(FormMapper $form)
    {
        $subject = $this->getSubject();
        $form->with('Table')
            ->add('translations',TranslationsType::class,
                array(
                    'label'=>false,
                    'fields' => array(
                        'name' => array('field_type'=>TextType::class),
                        'description' => array('field_type'=>TextType::class,
                            'locale_options'=>array(
                                'admin'=>array(
                                    'attr'=>array('readonly' =>true,
                                        'disabled'=>true)
                                )
                            )
                        ,'required'=>false),
                        'byStateVariance' => array(
                            'field_type'=>PercentType::class, 'type'=>'integer', 'scale'=>2,
                            'locale_options'=>array(
                                'admin'=>array(
                                    'attr'=>array('readonly' =>true,
                                        'disabled'=>true)
                                )
                            )
                        ,'required'=>false
                        )
                        ,'message' =>array('field_type'=>'text',
                            'locale_options'=>array(
                                'admin'=>array(
                                    'attr'=>array('readonly' =>true,
                                        'disabled'=>true)
                                )
                            )
                        )
                    )
                )
            )
            ->end()
            ->with('General')
                ->add('code',TextType::class, $this->isCreate($subject))
                ->add('basePrice', MoneyType::class, array('label' => 'Table base price'))
                ->add('hasExtension', CheckboxType::class, array('label' => 'Does this table offer extensions?', 'required'=>false))
                ->add('hasDistanceToSides', CheckboxType::class, array('label' => 'Does this table have distance to sides configuration?', 'required'=>false))
            ->end()
            ->with('Drawers')
                ->add('drawerAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position',
                ))
            ->end()
            ->with('Leg Profiles')
                ->add('legAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ->with ('Visibility')
                ->add('showInCatalog', CheckboxType::class, array('label' => 'Should this item be visible in the catalog? (You can enable it later)', 'required'=>false))
            ->end()
            ->with('Images')
                ->add('images', 'sonata_type_collection', [
                    'by_reference' => false
                ],
                ['edit'=>'inline',
                 'inline'=>'table',
                 'sortable'=>'position'
                 ]);
        ;


    }




    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('adminName.name', null, array(
                'label' => 'Admin Name',
            ))
            ->add('locales','text', array(
                    'label'=>'Available in',
                )
            )
            ->add('basePrice','currency',array(
                'currency'=>'€',
                'editable'=>true
            ))
            ->addIdentifier('drawerAttribute.maxNumberOfDrawers', null,array(
                'label'=>'Offers drawers'
            ))
            ->add('showInCatalog','boolean',array(
                 'editable' => true,
                'label'=>'Is visible in catalog'
            ))
            ->add('hasExtension','boolean',array(
                'editable'=>true,
                'label'=>'Offers extensions'
            ))
            ->add('hasDistanceToSides','boolean',array(
                'editable'=>true,
                'label'=>'Offers distance to sides'
            ))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            )
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('translations.locale', 'doctrine_orm_choice', [
            'label' => 'Language',
            'field_options' => [
                'required' => false,
                'choices' => $this->getLanguageChoices(),
                'multiple'=>true,
                'expanded'=>false
            ],
            'field_type' => 'choice'
        ]);
    }

    private function getLanguageChoices()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $availableLocales = $container->getParameter('locales');
        $languageChoices = [];
        foreach ($availableLocales as $locale) {
            $languageChoices[$locale] = $locale;
        }
        return $languageChoices;
    }

    private function bindImages(Table $object)
    {
        /** @var TableImage $image */
        foreach ($object->getImages() as $image)
        {
            $image->setTableItem($object);
            $image->refreshUpdated();
        }
    }
    public function prePersist($object)
    {
        $this->bindImages($object);
    }

    public function preUpdate($object)
    {
        $this->bindImages($object);
    }

    private function isCreate(Table $subject){
        if (is_null($subject->getCode())){
            return  array('label'=>'Code',
                'read_only'=>true,
                'data'=>Utils::generateItemCodeString(10, Table::class));
        }
        return array('label'=>'Code',
            'read_only'=>true
        );
    }


}