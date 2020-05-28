<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recette", inversedBy="pictures")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $recette;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="pictures")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="pictures")
     * @JoinColumn(onDelete="CASCADE")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="pictures",cascade={"persist"})
     * @JoinColumn(onDelete="CASCADE")
     */
    private $hotel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbrViews;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getRecette(): ?Recette
    {
        return $this->recette;
    }

    public function setRecette(?Recette $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNbrViews(): ?int
    {
        return $this->nbrViews;
    }

    public function setNbrViews(?int $nbrViews): self
    {
        $this->nbrViews = $nbrViews;

        return $this;
    }

}
