<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 11:20 PM
 */

namespace AppBundle\Admin;


use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use AppBundle\Entity\Product;
use AppBundle\Entity\ProductImage;
use AppBundle\Utils\Utils;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductAdmin extends Admin
{
    protected $formOptions = array(
        'cascade_validation' => true
    );

    protected function configureFormFields(FormMapper $form)
    {

        $subject = $this->getSubject();
        $form->with('admin.translations')
            ->add('translations', TranslationsType::class,
                array(
                    'label' => false,
                    'fields' => array(
                        'name' => array('field_type' => TextType::class,
                            'label'=>'admin.normal.name',
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('required' => true)
                                )
                            )
                        ),
                        'description' => array('field_type' => TextType::class,
                            'label'=>'admin.description',
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('readonly' => true,
                                        'disabled' => true)
                                )
                            )
                        , 'required' => false),
                        'byStateVariance' => array(
                            'label'=>'admin.by.state.variance',
                            'field_type' => PercentType::class, 'type' => 'integer', 'scale' => 2,
                            'locale_options' => array(
                                'admin' => array(
                                    'attr' => array('readonly' => true,
                                        'disabled' => true)
                                )
                            )
                        , 'required' => false
                        ),
                        'visibility'=> array(
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
            ->add('price', MoneyType::class, array('label' => 'admin.base.price'))
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
                    'sort_field_mapping'=>array('fieldName'=>'locale'),
                    'sort_parent_association_mappings'=>array(array('fieldName'=>'translations'))
                )
            )
            ->add('price', 'currency', array(
                'label'=>'admin.base.price',
                'currency'=>'€',
                'editable'=>true,
                'row_align'=>'left',
            ))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'edit' => array(),
                        'delete' => array()
                    )
                )
            );
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
        ])
        ->add('code');
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


    private function bindImages(Product $object)
    {
        /** @var ProductImage $image */
        foreach ($object->getImages() as $image)
        {
            $image->setProductItem($object);
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

    private function isCreate(Product $subject){
        if (is_null($subject->getCode())){
            return  array('label'=>'admin.code',
                'read_only'=>true,
                'data'=>Utils::generateItemCodeString(10, Product::class));
        }
        return array('label'=>'admin.code',
            'read_only'=>true
        );
    }

}