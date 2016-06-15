<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/15/2016
 * Time: 3:57 PM
 */

namespace AppBundle\ValueObject;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class OrderVO
{
    protected $clientFirstName;
    protected $clientLastName;
    protected $clientPhone;
    protected $clientAddress1;
    protected $clientAddress2;
    protected $clientStateOrProvidence;
    protected $clientCity;
    protected $clientCompany;
    protected $clientCompanyRegCode;
    protected $clientPostalCode;
    protected $clientEmail;
    protected $clientComment;

    /**
     * OrderVO constructor.
     * @param $clientFirstName
     * @param $clientLastName
     * @param $clientPhone
     * @param $clientAddress1
     * @param $clientAddress2
     * @param $clientStateOrProvidence
     * @param $clientCity
     * @param $clientCompany
     * @param $clientCompanyRegCode
     * @param $clientPostalCode
     * @param $clientEmail
     * @param $clientComment
     */
    public function __construct($clientFirstName, $clientLastName, $clientPhone, $clientAddress1, $clientAddress2, $clientStateOrProvidence, $clientCity, $clientCompany, $clientCompanyRegCode, $clientPostalCode, $clientEmail, $clientComment)
    {
        $this->clientFirstName = $clientFirstName;
        $this->clientLastName = $clientLastName;
        $this->clientPhone = $clientPhone;
        $this->clientAddress1 = $clientAddress1;
        $this->clientAddress2 = $clientAddress2;
        $this->clientStateOrProvidence = $clientStateOrProvidence;
        $this->clientCity = $clientCity;
        $this->clientCompany = $clientCompany;
        $this->clientCompanyRegCode = $clientCompanyRegCode;
        $this->clientPostalCode = $clientPostalCode;
        $this->clientEmail = $clientEmail;
        $this->clientComment = $clientComment;
    }



}