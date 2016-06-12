<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/12/2016
 * Time: 6:19 PM
 */

namespace AppBundle\ValueObject;


use Symfony\Component\HttpFoundation\Request;

class CartVO
{
    protected $dimensionsString;
    protected $profileString;
    protected $drawersString;
    protected $extString;
    protected $materialString;
    protected $qualityString;
    protected $temperingString;

    public function __construct(
        $dimensionsString,
        $profileString,
        $drawersString,
        $extString,
        $materialString,
        $qualityString,
        $temperingString
    )
    {
        $this->dimensionsString = $dimensionsString;
        $this->profileString = $profileString;
        $this->drawersString = $drawersString;
        $this->extString = $extString;
        $this->materialString = $materialString;
        $this->qualityString = $qualityString;
        $this->temperingString = $temperingString;
    }

    public static function createFromRequest(Request $request)
    {
        return new self(
            $request->get('dimensionsString'),
            $request->get('profileString'),
            $request->get('drawersString'),
            $request->get('extString'),
            $request->get('materialString'),
            $request->get('qualityString'),
            $request->get('temperingString')
        );
    }

    /**
     * @return mixed
     */
    public function getDimensionsString()
    {
        return $this->dimensionsString;
    }

    /**
     * @return mixed
     */
    public function getProfileString()
    {
        return $this->profileString;
    }

    /**
     * @return mixed
     */
    public function getDrawersString()
    {
        return $this->drawersString;
    }

    /**
     * @return mixed
     */
    public function getExtString()
    {
        return $this->extString;
    }

    /**
     * @return mixed
     */
    public function getMaterialString()
    {
        return $this->materialString;
    }

    /**
     * @return mixed
     */
    public function getQualityString()
    {
        return $this->qualityString;
    }

    /**
     * @return mixed
     */
    public function getTemperingString()
    {
        return $this->temperingString;
    }

    



}