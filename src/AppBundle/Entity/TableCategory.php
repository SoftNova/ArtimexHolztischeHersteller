<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/3/2016
 * Time: 1:27 PM
 */

namespace AppBundle\Entity;
use A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableCategory
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TableCategoryDAO")
 * @ORM\Table(name="table_category")
 */
class TableCategory
{
    use Translatable;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Table", mappedBy="categories", cascade={"persist"})
     */
    protected $tables;

    /**
     * @var
     * @ORM\Column(type="boolean", name="visibility", nullable=true)
     */
    protected $visibility;
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->tables = new ArrayCollection();
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

    /**
     * @return mixed
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param mixed $tables
     */
    public function setTables($tables)
    {
        $this->tables = $tables;
    }
    public function __toString()
    {
        if($name = $this->getName()){
            return $name;
        }
        return '';
    }

    /**
     * @return mixed
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param mixed $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }


}