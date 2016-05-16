<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 5/15/2016
 * Time: 2:06 PM
 */

namespace AppBundle\Entity;
use AppBundle\Utils\Utils;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractImage
 * @package AppBundle\Entity
 *
 * @ORM\MappedSuperclass()
 */
abstract class AbstractImage
{
    /**
     * @var UploadedFile
     */
    protected $file;

    protected $tempFilename;

    /**
     * @var
     * @ORM\Column(type="string", length=100)
     */
    protected $filename;

    /**
     * @var
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }



    /**
     * @return mixed
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     * @param
     */
    public function setTempFilename()
    {
        if ($this->filename!==null){
            $this->tempFilename = $this->filename;
        }
    }

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
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     * @param $path
     */
    public function upload($path)
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        $guessType = $this->getFile()->getClientOriginalExtension();
        $hashName = Utils::generateImageString(18) . '.' . $guessType;

        $this->getFile()->move(
            $path,
            $hashName
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

    abstract protected function getWebPath();
    abstract protected function prePersist();
    abstract protected function preUpdate();
    abstract protected function preRemove();
    abstract protected function postUpdate();
    abstract protected function postRemove();

}