<?php

namespace Tarazz\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{

    /**
     * @var integer
     */
    private $brandId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Tarazz\BrandBundle\Entity\Brand
     */
    private $brand;


    /**
     * Set brandId
     *
     * @param integer $brandId
     * @return Product
     */
    public function setBrandId($brandId)
    {
        $this->brandId = $brandId;
    
        return $this;
    }

    /**
     * Get brandId
     *
     * @return integer 
     */
    public function getBrandId()
    {
        return $this->brandId;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set brand
     *
     * @param \Tarazz\BrandBundle\Entity\Brand $brand
     * @return Product
     */
    public function setBrand(\Tarazz\BrandBundle\Entity\Brand $brand = null)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return \Tarazz\BrandBundle\Entity\Brand 
     */
    public function getBrand()
    {
        return $this->brand;
    }
}