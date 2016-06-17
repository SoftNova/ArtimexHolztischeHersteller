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
use AppBundle\ValueObject\OrderVO;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
                ))
            ->add('clientPaymentMethod', ChoiceType::class,
                array(
                    'choices'=>Utils::getPaymentMethodChoices()
                ,
                    'multiple'=>false,
                    'expanded'=>true,
                    'required'=>true,
                    
                ))
            ->add('submit', SubmitType::class, array('label' => 'app.checkout'))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

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
            $finalPrice = json_decode($this->get('configured_table_service')->calculatePrice()->getContent(), true)['success'];
            $cart = $this->get('cart_service')->addItemToCartAjax($finalPrice);
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