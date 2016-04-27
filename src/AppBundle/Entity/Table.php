<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 12:39 PM
 */


namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableProduct
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableDAO")
 * @ORM\Table(name="Table")
 */
class Table
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="base_price", nullable=false)
     */
    private $basePrice;

    /**
     * Check whether this object has the possibility of extension.
     * Check @AppBundle\Entity\TableExtensionProperty
     * @ORM\Column(type="boolean", name="has_extension", nullable=false)
     */
    private $hasExtension;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableDrawerAttribute", fetch="EAGER")
     * @ORM\JoinColumn(name="drawer_attribute_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $drawerAttribute;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableLegAttribute", fetch="EAGER")
     * @ORM\JoinColumn(name="leg_attribute_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    private $legAttribute;
    /**
     * @var
     * @ORM\Column(type="boolean", name="has_distance_to_sides", nullable=false)
     */
    private $hasDistanceToSides;   

    // This will probably end up being translatable
    /**
     * @var
     * @ORM\Column(type="string", name="message", nullable="true")
     */
    private $message;
    /**
     * for price decimal
     * for date datetime
     */
}