<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/16/2016
 * Time: 9:57 AM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Order;
use AppBundle\Entity\Sample;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Utils\Utils;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class SampleMaterialController extends Controller
{

    /**
     * @Route("/{_locale}/samples", name="_sample_materials")
     */
    public function indexAction(Request $request)
    {
        $sample = new Sample();
        $countries = $this->container->getParameter('countries');
        $lang=$request->getLocale();
        $aMaterials = $this->get('surface_service')->getMaterialsForLang($lang);
        $form = $this->createFormBuilder($sample)
            ->add('clientFirstName', TextType::class,
                array(
                    'label' => 'app.input.first.name',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.first.name')

                ))
            ->add('clientLastName', TextType::class,
                array(
                    'label' => 'app.input.last.name',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.last.name')
                ))
            ->add('clientPhone', PhoneNumberType::class,
                array(
                    'format' => PhoneNumberFormat::INTERNATIONAL,
                    'label' => 'app.input.phone',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.phone')
                )
            )
            ->add('clientAddress1', TextType::class,
                array(
                    'label' => 'app.input.address.one',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.address.one')


                ))
            ->add('clientAddress2', TextType::class,
                array(
                    'label' => 'app.input.address.two',
                    'required' => false,
                    'attr' => array('placeholder' => 'app.input.address.two')

                ))
            ->add('clientCountry', ChoiceType::class,
                array(
                    'label' => 'app.input.country',
                    'required' => true,
                    'choices' => Utils::getDeliveryCountries($countries)
                ))
            ->add('clientStateOrProvidence', TextType::class,
                array(
                    'label' => 'app.input.state',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.state')
                ))
            ->add('clientCity', TextType::class,
                array(
                    'label' => 'app.input.city',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.city')

                ))
            ->add('clientCompany', TextType::class,
                array(
                    'label' => 'app.input.company',
                    'required' => false,
                    'attr' => array('placeholder' => 'app.input.company')

                ))
            ->add('clientCompanyRegCode', TextType::class,
                array(
                    'label' => 'app.input.company.reg.code',
                    'required' => false,
                    'attr' => array('placeholder' => 'app.input.company.reg.code')

                ))
            ->add('clientPostalCode', TextType::class,
                array(
                    'label' => 'app.input.postal.code',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.postal.code')

                ))
            ->add('clientEmail', EmailType::class,
                array(
                    'label' => 'app.input.email',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.email')
                ))
            ->add('clientComment', TextareaType::class,
                array(
                    'label' => 'app.input.comments',
                    'required' => false,
                ))
            ->add('materialSamples', EntityType::class,
                array(
                    'class' => 'AppBundle\Entity\TableMaterial',
                    'multiple' => true,
                    'expanded' => true,
                    'required' => true
                ))
            ->add('submit', SubmitType::class, array('label' => 'app.send.free.samples'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump('die');
            die;
        }


        // replace this example code with whatever you need
        return $this->render('client/sample_materials.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'form' => $form->createView()
        ]);
    }

//    public function freeCheckout(Request $request){
//$lang = $this->get('request')->getLocale();
//return $this->render('client/sample_materials.html.twig', [
//    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
//    'aMaterials'=>$this->get('surface_service')->getMaterialsForLang($lang)
//]);
}