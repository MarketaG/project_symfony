<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=512)
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity="Tapa", mappedBy="category")
     */
    private $tapas;

    public function _construct()
    {
        $this->tapas = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Category
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tapas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tapa
     *
     * @param \AppBundle\Entity\Tapa $tapa
     *
     * @return Category
     */
    public function addTapa(\AppBundle\Entity\Tapa $tapa)
    {
        $this->tapas[] = $tapa;

        return $this;
    }

    /**
     * Remove tapa
     *
     * @param \AppBundle\Entity\Tapa $tapa
     */
    public function removeTapa(\AppBundle\Entity\Tapa $tapa)
    {
        $this->tapas->removeElement($tapa);
    }

    /**
     * Get tapas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTapas()
    {
        return $this->tapas;
    }

    //
    public function __toString()
    {
        return $this->name;

    }
}
