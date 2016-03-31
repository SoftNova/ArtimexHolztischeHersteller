<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 3/31/2016
 * Time: 6:55 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Product
 * @package AppBundle\Model
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductDAO")
 * @ORM\Table()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $cost;
}