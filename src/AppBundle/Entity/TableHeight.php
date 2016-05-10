<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/10/2016
 * Time: 10:44 AM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TableHeight
 * @package AppBundle\Entity\
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableHeightDAO")
 * @ORM\Table(name="table_height")
 *
 */
class TableHeight
{
    /**
     * @var
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\Column(type="integer", name="height_lower_bound", nullable=false)
     */
    protected $heightLowerBound;

    /**
     * @var
     * @ORM\Column(type="integer", name="height_upper_bound", nullable=false)
     */
    protected $heightUpperBound;

    /**
     * @var
     * @ORM\Column(type="integer", name="step", nullable=false)
     */
    protected $step;

    /**
     * @var
     * @ORM\Column(type="decimal", name="cost_per_step", precision=9, scale=2, nullable=false)
     */
    protected $costPerStep;

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
    public function getHeightLowerBound()
    {
        return $this->heightLowerBound;
    }

    /**
     * @param mixed $heightLowerBound
     */
    public function setHeightLowerBound($heightLowerBound)
    {
        $this->heightLowerBound = $heightLowerBound;
    }

    /**
     * @return mixed
     */
    public function getHeightUpperBound()
    {
        return $this->heightUpperBound;
    }

    /**
     * @param mixed $heightUpperBound
     */
    public function setHeightUpperBound($heightUpperBound)
    {
        $this->heightUpperBound = $heightUpperBound;
    }

    /**
     * @return mixed
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param mixed $step
     */
    public function setStep($step)
    {
        $this->step = $step;
    }

    /**
     * @return mixed
     */
    public function getCostPerStep()
    {
        return $this->costPerStep;
    }

    /**
     * @param mixed $costPerStep
     */
    public function setCostPerStep($costPerStep)
    {
        $this->costPerStep = $costPerStep;
    }
    
    

}