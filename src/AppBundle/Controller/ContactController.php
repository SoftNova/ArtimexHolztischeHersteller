<?php
/**
 * Created by PhpStorm.
 * User: Boogdan
 * Date: 23.05.2016
 * Time: 22:34
 */

namespace AppBundle\Controller;


use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/{_locale}/contact", name="_contact")
     */
    public function indexAction(Request $request)
    {
        $cart = $this->get('cart_service')->getCart();
        $form = $this->createFormBuilder()
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
            ->add('clientEmail', EmailType::class,
                array(
                    'label' => 'app.input.email',
                    'required' => true,
                    'attr' => array('placeholder' => 'app.input.email')
                ))
            ->add('clientComment', TextareaType::class,
                array(
                    'label' => 'app.input.comments',
                    'required' => true,
                    'attr' => array('rows'=>12)
                ))
            ->add('submit', SubmitType::class, array('label' => 'app.submit'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $message = \Swift_Message::newInstance()
                ->setSubject('Contact Us - From '. $data['clientFirstName'] . ' ' . $data['clientLastName'])
                ->setFrom($data['clientEmail'])
                ->setTo($this->getParameter('mailer_user'))
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'emails/contact.html.twig',
                        array('comments' => $data['clientComment'])
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);


            $autoReply = \Swift_Message::newInstance()
                ->setSubject('Inquiry')
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($data['clientEmail'])
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'emails/contact_autoreply.html.twig',
                        array('data' => $data)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($autoReply);
            return $this->render(':client:success.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
                'oCart' => $cart,
            ]);

        }


        // replace this example code with whatever you need
        return $this->render(':client:contact.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'oCart' => $cart,
            'form' => $form->createView()
        ]);
    }
}