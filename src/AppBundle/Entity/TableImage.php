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
use Gregwar\Image\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Class TableImage
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="table_image")
 * @ORM\HasLifecycleCallbacks()
 */
class TableImage
{
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
     * @var
     * @ORM\Column(type="string", length=100)
     */
    protected $filename;
    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * @var
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param mixed $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
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


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }
        $img = new Image($this->file);
        $img->save('asd.jpg','jpg',80);

        $hashName = Utils::generateImageString(18);
        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues


        // move takes the target directory and target filename as params
        $this->getFile()->move(
            Utils::TABLE_IMAGE_PATH,
            $hashName//$this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->filename = $hashName;

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new \DateTime());
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(){
        $this->upload();
    }
    /**
     *  @ORM\PreUpdate()
     */
    public function preUpdate(){
        $this->upload();
    }
}