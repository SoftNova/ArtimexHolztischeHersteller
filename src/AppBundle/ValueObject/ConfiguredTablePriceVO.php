<?php
/**
 * Created by PhpStorm.
 * User: rvcat
 * Date: 6/12/2016
 * Time: 5:13 PM
 */

namespace AppBundle\ValueObject;


use Symfony\Component\HttpFoundation\Request;

class ConfiguredTablePriceVO
{
    protected $length;
    protected $width;
    protected $height;
    protected $profile;
    protected $extensions;
    protected $extLength;
    protected $drawers;
    protected $drawerLength;
    protected $material;
    protected $quality;
    protected $tempering;

    /**
     * WHatever constructor.
     * @param string $length
     * @param string $width
     * @param string $height
     * @param string $profile
     * @param string $extensions
     * @param string $extLength
     * @param string $drawers
     * @param string $drawerLength
     * @param string $material
     * @param string $quality
     * @param string $tempering
     */
    public function __construct(
        $length,
        $width,
        $height,
        $profile,
        $extensions,
        $extLength,
        $drawers,
        $drawerLength,
        $material,
        $quality,
        $tempering
    ) {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->profile = $profile;
        $this->extensions = $extensions;
        $this->extLength = $extLength;
        $this->drawers = $drawers;
        $this->drawerLength = $drawerLength;
        $this->material = $material;
        $this->quality = $quality;
        $this->tempering = $tempering;
    }


    public static function createFromRequest(Request $request)
    {
        return new self(
            $request->get('length'),
            $request->get('width'),
            $request->get('height'),
            $request->get('profile'),
            $request->get('extensions'),
            $request->get('extLength'),
            $request->get('drawers'),
            $request->get('drawerLength'),
            $request->get('material'),
            $request->get('quality'),
            $request->get('tempering')
        );
    }

    /**
     * @return string
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @return string
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @return string
     */
    public function getExtLength()
    {
        return $this->extLength;
    }

    /**
     * @return string
     */
    public function getDrawers()
    {
        return $this->drawers;
    }

    /**
     * @return string
     */
    public function getDrawerLength()
    {
        return $this->drawerLength;
    }

    /**
     * @return string
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * @return string
     */
    public function getTempering()
    {
        return $this->tempering;
    }
}