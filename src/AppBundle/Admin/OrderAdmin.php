<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 6:29 PM
 */

namespace AppBundle\Admin;


use AppBundle\Entity\Order;
use AppBundle\Utils\Utils;
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class OrderAdmin extends Admin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'show'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', 'number', array('label'=>'ID'))
            ->add('clientFirstName', null, array(
                'label' => 'app.input.first.name',
            ))
            ->add('clientLastName', 'text', array('label'=>'app.input.last.name'))
            ->add('clientPhone', PhoneNumberType::class, array('label'=>'app.input.phone'))
            ->add('processedStatus', 'boolean', array(
                'label' => 'admin.processed.status',
                'editable'=>true,
            ))
            ->add('registeredDate', 'date', array('label'=>'admin.registered.date'))
            ->add('clientCountry', 'text',['label'=>'admin.country'])
            ->add('clientStateOrProvidence', 'text', ['label'=>'app.input.state'])
            ->add('clientCity', 'text', ['label'=>'app.input.city'])
            ->add('clientAddress1', 'text', ['label'=>'app.input.address.one'])
            ->add('processedDate', 'date', array('label'=>'admin.processed.date'))
            ->add('_action', 'actions', array(
                    'actions' => array(
                        'delete' => array(),
                        'show'=>array()
                    )
                )
            );
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $countries = $this->getConfigurationPool()->getContainer()->getParameter('countries');
        $filter->add('id')
            ->add('processedStatus',null, ['label'=>'admin.processed.status'])
            ->add('clientCountry', 'doctrine_orm_choice', [
                'label' => 'admin.country',
                'field_options' => [
                    'required' => false,
                    'choices' => Utils::getDeliveryCountries($countries),
                    'multiple'=>true,
                    'expanded'=>false
                ],
                'field_type' => 'choice'
            ]);
    }

    protected function configureShowFields(ShowMapper $show)
    {
        $show
            ->tab('admin.general') // the tab call is optional
            ->with('admin.order.request', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-success',
            ))
            ->add('id', 'number', array('label'=>'ID'))
            ->add('clientFirstName', null, array(
                'label' => 'app.input.first.name',
            ))
            ->add('clientLastName', 'text', array('label'=>'app.input.last.name'))
            ->add('clientPhone', 'text', array('label'=>'app.input.phone'))
            ->add('registeredDate', 'date', array('label'=>'admin.registered.date'))
            ->add('processedStatus', 'boolean', array(
                'label' => 'admin.processed.status',
                'editable'=>true,
            ))
            ->add('processedDate', 'date', array('label'=>'admin.processed.date'))
            ->add('clientAddress1', 'text', ['label'=>'app.input.address.one'])
            ->add('clientAddress2', 'text', ['label'=>'app.input.address.two'])
            ->add('clientCountry', 'text',['label'=>'admin.country'])
            ->add('clientStateOrProvidence', 'text', ['label'=>'app.input.state'])
            ->add('clientCity', 'text', ['label'=>'app.input.city'])
            ->add('clientPostalCode', 'text', ['label'=>'app.input.postal.code'])
            ->add('clientEmail', 'text', ['label'=>'app.input.email'])
            ->add('clientCompany', 'text', ['label'=>'app.input.company'])
            ->add('clientCompanyRegCode', 'text', ['label'=>'app.input.company.reg.code'])
            ->add('clientComment', 'text', ['label'=>'app.input.comments'])
            ->end()

            ->with('admin.order.cart.details', array(
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-primary',
            ))

            ->add('cart.decimalTotalPrice', 'text', array('label'=>'admin.total.price'))
            ->add('cart.cartCurrency', 'text', array('label'=>'admin.currency'))
            ->add('cart.totalQuantity', 'text', array('label'=>'admin.total.quantity'))
            ->add('cart.cartItems', null, array('label'=>'admin.item.configs',
                                                    'safe'=>false))
            ->add('clientPaymentMethod','text',array('label'=>'app.paymentinfo'))
            ->end()
        ;
    }

    public function preUpdate($object)
    {
       $this->confirmOrder($object);
    }

    private function confirmOrder(Order $object)
    {
        //ToDo find recepient country and send message accordingly to said country
        //ToDo transform country to iso2 and use translating template acordingly
        //ToDo order->setPaymentMethodName(getpaymentmethodnameforlocale)
        $object->setProcessedDate(new \DateTime());
        if ($object->getProcessedStatus()) {
            $clientLang = Utils::getIso2ByCountry($object->getClientCountry());
            $object->getClientPaymentMethod()->setNonPersistPaymentMethodName($object->getClientPaymentMethod()->getTranslatedName($clientLang));
            $appMailerUser =
                $this->getConfigurationPool()->getContainer()->getParameter('mailer_user');
            $supplierMail =
                $this->getConfigurationPool()->getContainer()->getParameter('supplier_mail_de');

            $mailer = $this->getConfigurationPool()->getContainer()->get('mailer');
            $twig = $this->getConfigurationPool()->getContainer()->get('twig');

            $translator = $this->getConfigurationPool()->getContainer()->get('translator');
            $translator->setLocale($clientLang);
            $subject = $translator->trans('app.confirmed.order.request');

            $autoReply = \Swift_Message::newInstance()
                //ToDo translation below doesn't work yet
                ->setSubject(htmlspecialchars($subject))
                ->setFrom($appMailerUser)
                ->setTo($object->getClientEmail())
                ->setBody(
                    $twig->render(
                        'emails/order_processed_autoreply.html.twig',
                        array('order' => $object,
                            'locale'=>$clientLang,
                            'supplier_mail'=>$supplierMail)
                    ),
                    'text/html'
                );
            $mailer->send($autoReply);
        }
    }



}