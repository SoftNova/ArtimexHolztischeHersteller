<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 1:37 PM
 */

namespace AppBundle\Admin;


use AppBundle\Utils\ImgConstraint;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        if($this->hasParentFieldDescription()) { // this Admin is embedded
            // $getter will be something like 'getlogoImage'
            $getter = 'get' . $this->getParentFieldDescription()->getFieldName();

            // get hold of the parent object
            $parent = $this->getParentFieldDescription()->getAdmin()->getSubject();
            if ($parent) {
                $images = $parent->$getter();
            } else {
                $images = null;
            }
        } else {
            $images = $this->getSubject();
        }

        // use $fileFieldOptions so we can add other options to the field
        $fileFieldOptions = array('required' => false);


        if (count($images) > 0) {
            foreach ($images as $image) {
                if (!is_null($image->getId())){
                    $webPath = $image->getWebPath();
                    $container = $this->getConfigurationPool()->getContainer();
                    $fullPath = $container->get('request')->getBasePath().'/'.$webPath;// add a 'help' option containing the preview's img ta
                    $fileFieldOptions['help'] = '<img src="' . $fullPath . '" class="admin-preview" />';
                }
            }
        }
        $formMapper
            ->add('file', FileType::class, $fileFieldOptions)
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $errorElement->with('file')
            ->addConstraint(new ImgConstraint())
            ->end();
    }


}