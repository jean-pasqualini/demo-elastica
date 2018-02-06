<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups({"elastica"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="`name`")
     * @JMS\Groups({"elastica"})
     * @Serializer\Groups({"elastica"})
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     * @JMS\Groups({"elastica"})
     * @Serializer\Groups({"elastica"})
     */
    private $priceTtc;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPriceTtc()
    {
        return $this->priceTtc;
    }

    /**
     * @param mixed $priceTtc
     */
    public function setPriceTtc($priceTtc)
    {
        $this->priceTtc = $priceTtc;
    }
}
