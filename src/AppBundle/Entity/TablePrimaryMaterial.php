<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 3:22 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TableMaterial
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TablePrimaryMaterialDAO")
 * @ORM\Table(name="table_primary_material")
 */
class TablePrimaryMaterial
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="decimal", name="price_per_square_meter", precision=9, scale=2)
     */
    protected $pricePerSquareMeter;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TableMaterial", fetch="EAGER")
     * @ORM\JoinColumn(name="table_material_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $primaryMaterial;

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
    public function getPricePerSquareMeter()
    {
        return $this->pricePerSquareMeter;
    }

    /**
     * @param mixed $pricePerSquareMeter
     */
    public function setPricePerSquareMeter($pricePerSquareMeter)
    {
        $this->pricePerSquareMeter = $pricePerSquareMeter;
    }

    /**
     * @return mixed
     */
    public function getPrimaryMaterial()
    {
        return $this->primaryMaterial;
    }

    /**
     * @param mixed $primaryMaterial
     */
    public function setPrimaryMaterial($primaryMaterial)
    {
        $this->primaryMaterial = $primaryMaterial;
    }
    
    


}