<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 12:28 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductTableDrawer
 * @package AppBundle\Entity
 * 
 * @ORM\Entity
 * @ORM\Table (name="TABLE_DRAWER_TYPES")
 */
class ProductTableDrawer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="ID")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="NUMBER_OF_DRAWERS", nullable=true)
     * The number of total available drawer categories. (2 means 0, 1 or 2)
     */
    private $nrOfDrawers;

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
    public function getNrOfDrawers()
    {
        return $this->nrOfDrawers;
    }

    /**
     * @param mixed $nrOfDrawers
     */
    public function setNrOfDrawers($nrOfDrawers)
    {
        $this->nrOfDrawers = $nrOfDrawers;
    }


}