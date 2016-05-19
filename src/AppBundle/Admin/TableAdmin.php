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
        $form->with('admin.translations')
            ->add('translations',TranslationsType::class,
                array(
                    'label'=>false,
                    'fields' => array(
                        'name' => array('field_type' => TextType::class,
                            'label'=>'admin.normal.name',
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('required' => true)
                                )
                            )
                        ),
                        'description' => array('field_type'=>TextType::class,
                            'label'=>'admin.description',
                            'locale_options'=>array(
                                'admin'=>array(
                                    'attr'=>array('readonly' =>true,
                                        'disabled'=>true)
                                )
                            )
                        ,'required'=>false),
                        'byStateVariance' => array(
                            'label'=>'admin.by.state.variance',
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
                            'label'=>'admin.message',
                            'locale_options'=>array(
                                'admin'=>array(
                                    'attr'=>array('readonly' =>true,
                                        'disabled'=>true)
                                )
                            )
                        )
                        ,'visibility'=> array(
                            'label'=>'admin.visibility',
                            'field_type' => CheckboxType::class,
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('readonly' => true,
                                        'disabled' => true)
                                )
                            )
                        , 'required' => false
                        )
                    )
                )
            )
            ->end()
            ->with('admin.general')
                ->add('code',TextType::class, $this->isCreate($subject))
                ->add('basePrice', MoneyType::class, array('label' => 'admin.base.price'))
                ->add('hasExtension', CheckboxType::class, array('label' => 'admin.has.extension', 'required'=>false))
                ->add('hasDistanceToSides', CheckboxType::class, array('label' => 'admin.has.distance.to.sides', 'required'=>false))
            ->end()
            ->with('app.drawer.attribute')
                ->add('drawerAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position',
                ))
            ->end()
            ->with('app.leg.attribute')
                ->add('legAttribute', 'sonata_type_admin', array('label'=>false), array(
                    'edit'=>'inline',
                    'inline'=>'table',
                    'sortable'=>'position'
                ))
            ->end()
            ->with ('admin.is.visible')
                ->add('showInCatalog', CheckboxType::class, array('label' => 'admin.is.visible', 'required'=>false))
            ->end()
            ->with('admin.images')
                ->add('images', 'sonata_type_collection', [
                    'by_reference' => false,
                    'label'=>false
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
            ->addIdentifier('code', 'text', array('label'=>'admin.code'))
            ->add('adminName.name', null, array(
                'label' => 'admin.name',
                'sortable'=>true,
                'sort_field_mapping'=>array('fieldName'=>'name'),
                'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
            ))
            ->add('isVisibleIn','text', array(
                    'label'=>'admin.available.in',
                    'sortable'=>true,
                    'sort_field_mapping'=>array('fieldName'=>'visibility'),
                    'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
                )
            )
            ->add('drawerAttribute.maxNumberOfDrawers', null,array(
                'label'=>'admin.nr.of.drawers',
                'row_align'=>'left'
            ))
            ->add('legAttribute.profiles', 'string', array('label'=>'admin.leg.profile'))
            ->add('basePrice','currency',array(
                'label'=>'admin.base.price',
                'currency'=>'€',
                'editable'=>true,
                'row_align'=>'left'
            ))
            ->add('showInCatalog','boolean',array(
                 'editable' => true,
                'label'=>'admin.show.in.catalog'
            ))
            ->add('hasExtension','boolean',array(
                'editable'=>true,
                'label'=>'admin.has.extension'
            ))
            ->add('hasDistanceToSides','boolean',array(
                'editable'=>true,
                'label'=>'admin.has.distance.to.sides'
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
        $filter->add('translations.visibility', 'doctrine_orm_choice', [
            'label' => 'app.language',
            'field_options' => [
                'required' => false,
                'choices' => $this->getLanguageChoices(),
                'multiple'=>true,
                'expanded'=>false
            ],
            'field_type' => 'choice'
        ])
            ->add('code')
            ->add('hasDistanceToSides')
            ->add('hasExtension')
            ->add('showInCatalog');
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
            return  array('label'=>'admin.code',
                'read_only'=>true,
                'data'=>Utils::generateItemCodeString(10, Table::class));
        }
        return array('label'=>'admin.code',
            'read_only'=>true
        );
    }



}