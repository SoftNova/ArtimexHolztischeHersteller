<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 10:41 AM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableWidth
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableWidthDAO")
 * @ORM\Table(name="table_width")
 */
class TableWidth
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;


    /**
     * @var
     * @ORM\Column(type="integer", name="width_lower_bound", nullable=false)
     */
    protected $widthLowerBound;

    /**
     * @var
     * @ORM\Column(type="integer", name="width_upper_bound", nullable=false)
     */
    protected $widthUpperBound;

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
    public function getWidthLowerBound()
    {
        return $this->widthLowerBound;
    }

    /**
     * @param mixed $widthLowerBound
     */
    public function setWidthLowerBound($widthLowerBound)
    {
        $this->widthLowerBound = $widthLowerBound;
    }

    /**
     * @return mixed
     */
    public function getWidthUpperBound()
    {
        return $this->widthUpperBound;
    }

    /**
     * @param mixed $widthUpperBound
     */
    public function setWidthUpperBound($widthUpperBound)
    {
        $this->widthUpperBound = $widthUpperBound;
    }

}