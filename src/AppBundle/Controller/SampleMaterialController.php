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
use AppBundle\Validator\MinMaxChoices;
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
        $cart = $this->get('cart_service')->getCart();
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
                    'choices'=>$aMaterials,
                    'constraints' => array(new MinMaxChoices()),
                    'multiple' => true,
                    'expanded' => true,
                    'required' => true
                ))
            ->add('submit', SubmitType::class, array('label' => 'app.send.free.samples'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Sample $sample */
            $sample = $form->getData();

            $message = \Swift_Message::newInstance()
                ->setSubject('Sample Request - From '. $sample->getClientFirstName() . ' ' . $sample->getClientLastName())
                ->setFrom($sample->getClientEmail())
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(
                        'emails/sample_material.html.twig',
                        array('sample' => $sample)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);


            $autoReply = \Swift_Message::newInstance()
                ->setSubject('Sample Request')
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($sample->getClientEmail())
                ->setBody(
                    $this->renderView(
                        'emails/sample_material_autoreply.html.twig',
                        array('sample' => $sample)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($autoReply);
            
            $this->get('sample_service')->save($sample);
            return $this->render(':client:success.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
                'oCart' => $cart,
            ]);
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