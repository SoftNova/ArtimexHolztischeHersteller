<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 6/7/2016
 * Time: 3:08 PM
 */

namespace AppBundle\Service;


use AppBundle\Repository\TableCategoryDAO;
use Doctrine\Common\Collections\ArrayCollection;

class CategoryService
{
    private $categoryDAO;

    public function __construct(TableCategoryDAO $cDAO)
    {
        $this->categoryDAO=$cDAO;
    }

    public function findAllByLang($lang){
        $aCategories = new ArrayCollection($this->categoryDAO->findAllByLang($lang));
        foreach ($aCategories as $cat){
            if (is_null($cat->getName())){
                $aCategories->removeElement($cat);
            }
            if (count($cat->getTables())<=0){
                $aCategories->removeElement($cat);
            }
        }
        if (!is_null($aCategories) || count($aCategories) > 0){
            return $aCategories;
        }
        return null;
    }
}