<?php
namespace Creationx\CixContactperson\Domain\Model;

class Zip extends TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * ZIP
     *
     * @var string
     */
    protected $zip = '';

    /**
     * City
     *
     * @var text|string
     */
    protected $city = '';

    /**
     * Longitude
     *
     * @var double
     */
    protected $lng = '';

    /**
     * Latitude
     *
     * @var double
     */
    protected $lat = '';

    /**
     * @param string $zip
     * @param text|string $city
     * @param float|string $lng
     * @param float|string $lat
     */
    public function __construct($zip, $city, $lng, $lat)
    {
        $this->setZip($zip);
        $this->setCity($city);
        $this->setLng($lng);
        $this->setLat($lat);
    }


    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param string $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return text|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param text|string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return float
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param float $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param float $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

}

?>