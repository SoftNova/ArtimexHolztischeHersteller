<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 2:20 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableExtensionRule
 * @package AppBundle\Entity
 * 
 * @ORM\Entity()
 * @ORM\Table(name="table_extension_rule")
 */
class TableExtensionAttribute
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

       /**
     * @var
     * @ORM\Column(type="integer",nullable=true,name="max_number_of_extensions")
     */
    private $maxNumberOfExtensions;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMaxNumberOfExtensions()
    {
        return $this->maxNumberOfExtensions;
    }

    /**
     * @param mixed $maxNumberOfExtensions
     */
    public function setMaxNumberOfExtensions($maxNumberOfExtensions)
    {
        $this->maxNumberOfExtensions = $maxNumberOfExtensions;
    }
}