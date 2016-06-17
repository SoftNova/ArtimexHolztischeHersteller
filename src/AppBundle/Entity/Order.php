<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/15/2016
 * Time: 4:41 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Class Order
 * @package AppBundle\Entity
 * 
 * @ORM\Entity()
 * @ORM\Table(name="order_history")
 */
class Order
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_first_name")
     */
    protected $clientFirstName;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_last_name")
     */
    protected $clientLastName;

    /**
     * @var
     * @ORM\Column(type="phone_number", nullable=false, name="client_phone")
     */
    protected $clientPhone;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_address1")
     */
    protected $clientAddress1;

    /**
     * @var
     * @ORM\Column(type="string", nullable=true, name="client_address2")
     */
    protected $clientAddress2;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_country")
     */

    protected $clientCountry;
    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_state_or_providence")
     */
    protected $clientStateOrProvidence;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_city")
     */
    protected $clientCity;

    /**
     * @var
     * @ORM\Column(type="string", nullable=true, name="client_company")
     */
    protected $clientCompany;

    /**
     * @var
     * @ORM\Column(type="string", nullable=true, name="client_company_reg_code")
     */
    protected $clientCompanyRegCode;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_postal_code")
     */
    protected $clientPostalCode;

    /**
     * @var
     * @ORM\Column(type="string", nullable=false, name="client_email")
     */
    protected $clientEmail;

    /**
     * @var
     * @ORM\Column(type="string", nullable=true, name="client_comment")
     */
    protected $clientComment;

    protected $clientPaymentMethod;

    /**
     * @return mixed
     */
    public function getClientPaymentMethod()
    {
        return $this->clientPaymentMethod;
    }

    /**
     * @param mixed $clientPaymentMethod
     */
    public function setClientPaymentMethod($clientPaymentMethod)
    {
        $this->clientPaymentMethod = $clientPaymentMethod;
    }

    
    /**
     * @return mixed
     */
    public function getClientComment()
    {
        return $this->clientComment;
    }

    /**
     * @param mixed $clientComment
     */
    public function setClientComment($clientComment)
    {
        $this->clientComment = $clientComment;
    }

    /**
     * @return mixed
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param mixed $clientEmail
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
    }

    /**
     * @return mixed
     */
    public function getClientPostalCode()
    {
        return $this->clientPostalCode;
    }

    /**
     * @param mixed $clientPostalCode
     */
    public function setClientPostalCode($clientPostalCode)
    {
        $this->clientPostalCode = $clientPostalCode;
    }

    /**
     * @return mixed
     */
    public function getClientCompanyRegCode()
    {
        return $this->clientCompanyRegCode;
    }

    /**
     * @param mixed $clientCompanyRegCode
     */
    public function setClientCompanyRegCode($clientCompanyRegCode)
    {
        $this->clientCompanyRegCode = $clientCompanyRegCode;
    }

    /**
     * @return mixed
     */
    public function getClientCompany()
    {
        return $this->clientCompany;
    }

    /**
     * @param mixed $clientCompany
     */
    public function setClientCompany($clientCompany)
    {
        $this->clientCompany = $clientCompany;
    }

    /**
     * @return mixed
     */
    public function getClientCity()
    {
        return $this->clientCity;
    }

    /**
     * @param mixed $clientCity
     */
    public function setClientCity($clientCity)
    {
        $this->clientCity = $clientCity;
    }

    /**
     * @return mixed
     */
    public function getClientStateOrProvidence()
    {
        return $this->clientStateOrProvidence;
    }

    /**
     * @param mixed $clientStateOrProvidence
     */
    public function setClientStateOrProvidence($clientStateOrProvidence)
    {
        $this->clientStateOrProvidence = $clientStateOrProvidence;
    }

    /**
     * @return mixed
     */
    public function getClientAddress2()
    {
        return $this->clientAddress2;
    }

    /**
     * @param mixed $clientAddress2
     */
    public function setClientAddress2($clientAddress2)
    {
        $this->clientAddress2 = $clientAddress2;
    }

    /**
     * @return mixed
     */
    public function getClientAddress1()
    {
        return $this->clientAddress1;
    }

    /**
     * @param mixed $clientAddress1
     */
    public function setClientAddress1($clientAddress1)
    {
        $this->clientAddress1 = $clientAddress1;
    }

    /**
     * @return mixed
     */
    public function getClientPhone()
    {
        return $this->clientPhone;
    }

    /**
     * @param mixed $clientPhone
     */
    public function setClientPhone($clientPhone)
    {
        $this->clientPhone = $clientPhone;
    }

    /**
     * @return mixed
     */
    public function getClientLastName()
    {
        return $this->clientLastName;
    }

    /**
     * @param mixed $clientLastName
     */
    public function setClientLastName($clientLastName)
    {
        $this->clientLastName = $clientLastName;
    }

    /**
     * @return mixed
     */
    public function getClientFirstName()
    {
        return $this->clientFirstName;
    }

    /**
     * @param mixed $clientFirstName
     */
    public function setClientFirstName($clientFirstName)
    {
        $this->clientFirstName = $clientFirstName;
    }

    /**
     * @return mixed
     */
    public function getClientCountry()
    {
        return $this->clientCountry;
    }

    /**
     * @param mixed $clientCountry
     */
    public function setClientCountry($clientCountry)
    {
        $this->clientCountry = $clientCountry;
    }



}