<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/12/2016
 * Time: 12:27 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductTableLegType
 * @package AppBundle\Entity
 * 
 * @ORM\Entity 
 * @ORM\Table (name="TABLE_LEG_TYPES")
 */
class ProductTableLegType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="ID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="LEG_TYPES")
     */
    private $legTypesByDimention;

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
    public function getLegTypesByDimention()
    {
        return $this->legTypesByDimention;
    }

    /**
     * @param mixed $legTypesByDimention
     */
    public function setLegTypesByDimention($legTypesByDimention)
    {
        $this->legTypesByDimention = $legTypesByDimention;
    }


}