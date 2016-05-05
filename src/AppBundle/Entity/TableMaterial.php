<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/5/2016
 * Time: 1:38 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class TableMaterial
 * @package AppBundle\Entity
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableMaterialDAO")
 * @ORM\Table(name="table_material")
 */
class TableMaterial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(type="string", name="name")
     */
    private $name;

    /**
     * @var
     * Value, either PricePerSquareMeter or percentage of primary material
     * @ORM\Column(type="decimal", name="value")
     */
    private $value;

    /**
     * @var
     * @ORM\Column(type="boolean", name="is_primary")
     */
    private $isPrimary;
}