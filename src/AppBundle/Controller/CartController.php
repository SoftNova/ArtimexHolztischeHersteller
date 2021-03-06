<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/8/2016
 * Time: 2:05 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Order;
use AppBundle\Utils\Utils;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CartController extends Controller
{
    /** @Route("/{_locale}/cart", name="_cart") */
    public function indexAction()
    {
        $cart = $this->get('cart_service')->getCart();
        return $this->render('client/cart.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'oCart' => $cart,
        ]);
    }

    /** @Route("/{_locale}/cart/checkout", name="_cart_checkout") */
    public function cartCheckoutAction(Request $request)
    {
        $cart = $this->get('cart_service')->getCart();
        $order = new Order();
        $countries = $this->container->getParameter('countries');
        $lang=$request->getLocale();
        $aMethods = $this->get('payment_method_service')->getMethodsForLang($lang);

        $form = $this->createFormBuilder($order)
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
                    'attr' => array('rows' => 7)
                ))
            ->add('clientPaymentMethod', EntityType::class,
                array(
                    'class'=>'AppBundle\Entity\PaymentMethod',
                    'choices'=>$aMethods,
                    'multiple'=>false,
                    'expanded'=>true,
                    'required'=>true,
                    'choice_attr' => function($val, $key, $index) {
                        // adds a class like attending_yes, attending_no, etc
                        return ['class' => 'with-font',
                                'data-disc'=>$val->getModifier()];
                    }
                ))
            ->add('submit', SubmitType::class, array('label' => 'app.checkout'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $supplierMail = $this->getParameter('supplier_mail_de');
            /** @var Order $order */
            $order = $form->getData();
            $this->get('order_service')->save($order,$cart);
            $message = \Swift_Message::newInstance()
                ->setSubject('New Order  - From '. $order->getClientFirstName() . ' ' . $order->getClientLastName())
                ->setFrom($order->getClientEmail())
                ->setTo($this->getParameter('sales_mail'))
                ->setBody(
                    $this->renderView(
                        'emails/order.html.twig',
                        array('order' => $order,
                            'supplierMail'=>$supplierMail)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);

            $subject = $this->get('translator')->trans('app.register.order.request');
            $autoReply = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->getParameter('mailer_user'))
                ->setTo($order->getClientEmail())
                ->setBody(
                    $this->renderView(
                        'emails/order_autoreply.html.twig',
                        array('order' => $order,
                            'supplierMail'=>$supplierMail)
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($autoReply);
            $this->get('cart_service')->clearCart();
            return $this->render(':client:success.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
                'oCart' => $this->get('cart_service')->getCart(),
            ]);
        }


        // replace this example code with whatever you need
        return $this->render('client/checkout.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'oCart' => $cart,
            'form' => $form->createView()
        ]);
    }

    /** @Route ("/{_locale}/removeCartItemAjax", name="_remove_item_from_cart", options={"expose"=true}) */
    public function removeItemAjax()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $cart = $this->get('cart_service')->removeItemFromCartAjax();
            $this->get('session')->set('cart', $cart);
            $content = $this->forward('AppBundle:Cart:cartAjax')->getContent();
            return new JsonResponse(
                [
                    'success' => array(
                        'price' => $cart->getTotalPrice(),
                        'quantity' => $cart->getTotalQuantity(),
                        'content' => $content
                    )
                ]
            );

        }
    }

    /** @Route ("/{_locale}/modifyCartItemQuantityAjax", name="_modify_cart_item_quantity", options={"expose"=true}) */
    public function modifyQuantity()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $cart = $this->get('cart_service')->modifyCartItemQuantity();
            if ($cart === false) {
                $this->get('session')->remove('cart');
                return new JsonResponse(
                    [
                        'failure' => array()
                    ]
                );
            }
            $this->get('session')->set('cart', $cart);
            $content = $this->forward('AppBundle:Cart:cartAjax')->getContent();
            return new JsonResponse(
                [
                    'success' => array(
                        'price' => $cart->getTotalPrice(),
                        'quantity' => $cart->getTotalQuantity(),
                        'content' => $content
                    )
                ]
            );
        }
    }


    public function cartAjaxAction()
    {
        $cart = $this->get('cart_service')->getCart();
        return $this->render(':client:cartItems.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
            'oCart' => $cart
        ]);
    }

    /**
     * @Route("/{_locale}/addTableToCart/", name="_add_table_to_cart", options={"expose"=true})
     */
    public function addTableToCart()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $finalPrice = json_decode($this->get('configured_table_service')->calculateTablePrice()->getContent(), true)['success'];
            $cart = $this->get('cart_service')->addTableToCartAjax($finalPrice);
            $this->get('session')->set('cart', $cart);
            return new JsonResponse(
                [
                    'success' => array(
                        'price' => $cart->getTotalPrice(),
                        'quantity' => $cart->getTotalQuantity()
                    )
                ]
            );
        }
        return new JsonResponse('Invalid request!, 400');
    }

    /**
     * @Route("/{_locale}/addArticleToCart/", name="_add_article_to_cart", options={"expose"=true})
     */
    public function addArticleToCart()
    {
        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            $finalPrice = json_decode($this->get('article_service')->calculateArticlePrice()->getContent(), true)['success'];
            $cart = $this->get('cart_service')->addArticleToCartAjax($finalPrice);
            $this->get('session')->set('cart', $cart);
            return new JsonResponse(
                [
                    'success' => array(
                        'price' => $cart->getTotalPrice(),
                        'quantity' => $cart->getTotalQuantity()
                    )
                ]
            );
        }
        return new JsonResponse('Invalid request!, 400');
    }

}