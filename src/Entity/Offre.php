<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="App\Repository\OffreRepository")
 */
class Offre
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptions", type="string", length=255, nullable=true)
     */
    private $descriptions;
    
    /**
     * @var int
     *
     * @ORM\Column(name="etablissement_id", type="integer", nullable=true)
     */
    private $idEtablissement;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Etablissement",cascade={"persist"}, inversedBy="offres")
     * @ORM\JoinColumn(name="etablissement_id", referencedColumnName="id")
     */
    private $etablissement;
    
    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="offre", cascade={"all"}, orphanRemoval=true)
     */
    private $photos;
    
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection;
    }
    
    /**
     * Add photo
     *
     * @param Offre $photo
     *
     * @return Etablissement
     */
    public function addPhoto(Photo $photo) {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove Photo
     *
     * @param Photo $photo
     */
    public function removePhoto(Photo $photo) {
        $this->offres->removeElement($photo);
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Offre
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Offre
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set descriptions
     *
     * @param string $descriptions
     *
     * @return Offre
     */
    public function setDescriptions($descriptions)
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    /**
     * Get descriptions
     *
     * @return string
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }
    
    public function getIdEtablissement() {
        return $this->idEtablissement;
    }

    public function getEtablissement() {
        return $this->etablissement;
    }

    public function setIdEtablissement($idEtablissement) {
        $this->idEtablissement = $idEtablissement;
    }

    public function setEtablissement(Etablissement $etablissement) {
        $this->etablissement = $etablissement;
    }

    public function getPhotos() {
        return $this->photos;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }

}

