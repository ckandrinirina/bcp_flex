<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etablissement
 *
 * @ORM\Table(name="etablissement")
 * @ORM\Entity(repositoryClass="App\Repository\EtablissementRepository")
 */
class Etablissement
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
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="fixe", type="string", length=255, nullable=true)
     */
    private $fixe;

    /**
     * @var string
     *
     * @ORM\Column(name="autre", type="string", length=255, nullable=true)
     */
    private $autre;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255, nullable=true)
     */
    private $specialite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", nullable=true)
     */
    private $prix;
    
    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;
    
    /**
     * @ORM\OneToMany(targetEntity="Offre", mappedBy="etablissement", cascade={"remove"}, orphanRemoval=true)
     */
    private $offres;
    
    /**
     * @ORM\OneToMany(targetEntity="Photo", mappedBy="etablissement", cascade={"all"}, orphanRemoval=true)
     */
    private $photos;
    
    /**
     * @var string
     *
     * @ORM\Column(name="etablissement_type", type="string", length=255, nullable=true)
     */
    private $type;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description  = '';
    
    /**
     * @var int
     *
     * @ORM\Column(name="viewers", type="integer", nullable=true)
     */
    private $viewers = 0;
    
    public function __construct() {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection;
        $this->offres = new \Doctrine\Common\Collections\ArrayCollection;
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
     * Add offre
     *
     * @param Offre $offre
     *
     * @return Etablissement
     */
    public function addOffre(Offre $offre) {
        $this->offres[] = $offre;

        return $this;
    }

    /**
     * Remove offre
     *
     * @param Offre $offre
     */
    public function removeOffre(Offre $offre) {
        $this->offres->removeElement($offre);
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
     * @return Etablissement
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Etablissement
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set fixe
     *
     * @param string $fixe
     *
     * @return Etablissement
     */
    public function setFixe($fixe)
    {
        $this->fixe = $fixe;

        return $this;
    }

    /**
     * Get fixe
     *
     * @return string
     */
    public function getFixe()
    {
        return $this->fixe;
    }

    /**
     * Set autre
     *
     * @param string $autre
     *
     * @return Etablissement
     */
    public function setAutre($autre)
    {
        $this->autre = $autre;

        return $this;
    }

    /**
     * Get autre
     *
     * @return string
     */
    public function getAutre()
    {
        return $this->autre;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Etablissement
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Etablissement
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     *
     * @return Etablissement
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Etablissement
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }
    
    public function getNote() {
        return $this->note;
    }

    public function setNote($note) {
        $this->note = $note;
    }

    public function getOffres() {
        return $this->offres;
    }

    public function getPhotos() {
        return $this->photos;
    }

    public function setOffres($offres) {
        $this->offres = $offres;
    }

    public function setPhotos($photos) {
        $this->photos = $photos;
    }
    
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getViewers() {
        return $this->viewers;
    }

    public function setViewers($viewers) {
        $this->viewers = $viewers;
    }

}

