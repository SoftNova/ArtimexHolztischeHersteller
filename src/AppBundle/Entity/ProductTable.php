<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 4/4/2016
 * Time: 1:47 PM
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ProductTable
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductTableDAO")
 * @ORM\Table()
 */
class ProductTable
{
    private $id;

    private $isVisible;
    private $fromDate;
    private $toDate;
    private $stockCost;

    //promotions
    //stuff for multilang


}