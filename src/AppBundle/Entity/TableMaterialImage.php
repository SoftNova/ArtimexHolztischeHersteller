<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/17/2016
 * Time: 1:48 PM
 */

namespace AppBundle\Entity;


use AppBundle\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TableMaterialImage
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="table_material_image")
 * @ORM\HasLifecycleCallbacks()
 */
class TableMaterialImage extends AbstractImage
{

    const UPLOAD_PATH = Utils::MATERIAL_IMAGE_PATH;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     * @ORM\OneToOne(targetEntity="TableMaterial", inversedBy="image")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     * 
     */
    protected $materialItem;



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
     * @return  TableMaterial
     */
    public function getMaterialItem()
    {
        return $this->materialItem;
    }

    /**
     * @param TableMaterial $material_item
     */
    public function setMaterialItem($material_item)
    {
        $this->materialItem = $material_item;
    }

    public function upload($path)
    {
        return parent::upload($path);
    }

    public function lifecycleFileUpload()
    {
        $this->upload($this->path());
    }


    /**
     * @ORM\PrePersist()
     */
    public function prePersist(){
        $this->upload($this->path());
    }
    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->setTempFilename();
        $this->upload($this->path());
    }


    /**
     * @ORM\PostUpdate()
     */
    public function postUpdate(){
        if (is_null($this->tempFilename)){
            return true;
        }
        $oldFile = $this->path() . $this->tempFilename;
        $currentFile = $this->path() . $this->filename;
        if (file_exists($oldFile)) {
            if ($oldFile !== $currentFile)
                unlink($oldFile);
        }
    }

    public function getWebPath()
    {
        if (!is_null($this->path())){
            return $this->path() . $this->filename;
        }
        return null;
    }
    public function path()
    {
        if (!is_null($this->getMaterialItem())){
            return (self::UPLOAD_PATH . $this->getMaterialItem()->getCode() . '/');
        }
        return null;
    }
    public function postRemove()
    {
        // abstract class requirement. Not needed here
    }
    public function preRemove()
    {
        // abstract class requirement. Not needed here
    }

}