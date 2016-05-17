<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 5/16/2016
 * Time: 1:37 PM
 */

namespace AppBundle\Entity;

use AppBundle\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductImage
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="product_image")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductImage extends AbstractImage
{
    const UPLOAD_PATH = Utils::PRODUCT_IMAGE_PATH;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    protected $id;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product", inversedBy="images")
     */
    protected $productItem;
    

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
     * @return Product
     */
    public function getProductItem()
    {
        return $this->productItem;
    }

    /**
     * @param Product $productItem
     */
    public function setProductItem($productItem)
    {
        $this->productItem = $productItem;
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
        $oldFile = $this->path(). $this->tempFilename;
        $currentFile = $this->path() . $this->filename;
        if (file_exists($oldFile)){
            if ($oldFile!==$currentFile)
                unlink($oldFile);
        }
        if (count($this->getProductItem()->getImages())===0){
            $dir = self::UPLOAD_PATH . $this->getProductItem()->getCode();
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
        if (is_null($this->tempFilename)){
            return true;
        }
        $oldFile = $this->path() . $this->tempFilename;
        if (file_exists($oldFile)){
            unlink($oldFile);
        }
        if (count($this->getProductItem()->getImages())===0){
            $dir = self::UPLOAD_PATH . $this->getProductItem()->getCode();
            $this->deleteDirectory($dir);
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
        if (!is_null($this->getProductItem())){
            return self::UPLOAD_PATH . $this->getProductItem()->getCode() . '/';
        }
        return null;
    }

}