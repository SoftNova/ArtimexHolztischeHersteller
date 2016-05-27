<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/26/2016
 * Time: 8:50 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TableLegProfile
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableLegProfileDAO")
 * @ORM\Table(name="table_leg_profile")
 */
class TableLegProfile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="variance", nullable=false, precision=9, scale=2)
     */
    protected $variance;

    /**
     * @var
     * @ORM\Column(type="string", name="profile", nullable=false)
     *
     */
    protected $profile;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Table", inversedBy="profiles")
     */
    protected $tableItem;

    /**
     * @return Table
     */
    public function getTableItem()
    {
        return $this->tableItem;
    }

    /**
     * @param Table $tableItem
     */
    public function setTableItem($tableItem)
    {
        $this->tableItem = $tableItem;
    }

    /**
     * @return mixed
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;
    }

    /**
     * @return mixed
     */
    public function getVariance()
    {
        return $this->variance;
    }

    /**
     * @param mixed $variance
     */
    public function setVariance($variance)
    {
        $this->variance = $variance;
    }

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


}