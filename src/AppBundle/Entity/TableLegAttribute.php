<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/26/2016
 * Time: 3:35 PM
 */

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableLegAttribute
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="table_leg_attribute")
 */
class TableLegAttribute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(name="base_price", type="decimal", nullable=false)
     */
    private $basePrice;

    /**
     * @var
     * @ORM\Column(type="decimal", name="variance", nullable=false)
     */
    private $variance=1;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TableLegProfiles")
     * @ORM\JoinTable(name="leg_profiles",
     *     joinColumns={@ORM\JoinColumn(name="leg_attribute_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="profile_id", referencedColumnName="id", unique=true)}
     *
     */
    private $profiles;

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }

}