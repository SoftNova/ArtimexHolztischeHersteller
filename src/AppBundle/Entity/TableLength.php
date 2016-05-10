<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 10:40 AM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableLength
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableLengthDAO")
 * @ORM\Table(name="table_length")
 */
class TableLength
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="integer", name="length_lower_bound", nullable=false)
     */
    protected $lengthLowerBound;


    /**
     * @var
     * @ORM\Column(type="integer", name="length_upper_bound", nullable=false)
     */
    protected $lengthUpperBound;

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
    public function getLengthLowerBound()
    {
        return $this->lengthLowerBound;
    }

    /**
     * @param mixed $lengthLowerBound
     */
    public function setLengthLowerBound($lengthLowerBound)
    {
        $this->lengthLowerBound = $lengthLowerBound;
    }

    /**
     * @return mixed
     */
    public function getLengthUpperBound()
    {
        return $this->lengthUpperBound;
    }

    /**
     * @param mixed $lengthUpperBound
     */
    public function setLengthUpperBound($lengthUpperBound)
    {
        $this->lengthUpperBound = $lengthUpperBound;
    }

}