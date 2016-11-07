<?php

namespace GalleryBundle\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Album which contains media-files mapped to Media entity
 */
class Album
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $medias;


    /**
     * Get id
     *
     * @return integer
     * @Groups({"api","common"})
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Album
     * @Groups({"api","common"})
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     * @Groups({"api","common"})
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->medias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add medias
     *
     * @param \GalleryBundle\Entity\Media $medias
     * @return Album
     */
    public function addMedia(\GalleryBundle\Entity\Media $medias)
    {
        $this->medias[] = $medias;

        return $this;
    }

    /**
     * Remove medias
     *
     * @param \GalleryBundle\Entity\Media $medias
     */
    public function removeMedia(\GalleryBundle\Entity\Media $medias)
    {
        $this->medias->removeElement($medias);
    }

    /**
     * Get medias
     * @return \Doctrine\Common\Collections\Collection
     * @Groups({"common"})
     */
    public function getMedias()
    {
        return $this->medias;
    }

    /**
     * Returns quantity of medias in album
     * @return int
     * @Groups({"api","common"})
     */
    public function getMediasCount() {
        return count($this->medias);
    }
}
