<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/14/2016
 * Time: 12:36 AM
 */

namespace AppBundle\Entity;
use AppBundle\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class TableImage
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="TableImageRepository", )
 * @ORM\Table(name="table_image")
 * @ORM\HasLifecycleCallbacks()
 */
class TableImage extends AbstractImage
{

    const UPLOAD_PATH = Utils::TABLE_IMAGE_PATH;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Table", inversedBy="images")
     */
    protected $tableItem;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TableMaterial")
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id")
     */
    protected $materialItem;

    /**
     * @var
     * @ORM\Column(type="boolean", name="role", nullable=false)
     */
    protected $role;

  


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
     * @return Table
     */
    public function getTableItem()
    {
        return $this->tableItem;
    }

    /**
     * @param mixed $table_item
     */
    public function setTableItem($table_item)
    {
        $this->tableItem = $table_item;
    }

    /**
     * @return mixed
     */
    public function getMaterialItem()
    {
        return $this->materialItem;
    }

    /**
     * @param mixed $material_item
     */
    public function setMaterialItem($material_item)
    {
        $this->materialItem = $material_item;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    public function path()
    {
        return self::UPLOAD_PATH . $this->getTableItem()->getCode() . '/';
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

        $oldFile = $this->path() . $this->tempFilename;
        $currentFile = $this->path() . $this->filename;
        if (file_exists($oldFile)){
            if ($oldFile!==$currentFile)
            unlink($oldFile);
        }
        if (count($this->getTableItem()->getImages())===0){
            $dir = $this->path();
            if (is_dir($dir)){
                rmdir($dir);
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemove(){
        $this->setTempFilename();
    }

    /**
     * 
     * @ORM\PostRemove()
     */
    public function postRemove(){
        $oldFile = $this->path(). $this->tempFilename;
        if (file_exists($oldFile)){
            unlink($oldFile);
        }
        if (count($this->getTableItem()->getImages())===0){
            $dir = $this->path();
            if (is_dir($dir)){
                rmdir($dir);
            }
        }
    }

    public function getWebPath()
    {
        return $this->path() . $this->filename;
    }
}