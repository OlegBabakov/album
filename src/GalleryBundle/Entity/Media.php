<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Media file which should grouped by Album entity
 */
class Media
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $fileInfo;

    /**
     * @var \GalleryBundle\Entity\Album
     */
    private $album;

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
     * Set url
     *
     * @param string $url
     * @return Media
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     * @Groups({"api","common"})
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns url of cached thumb image
     * @return string|null
     * @Groups({"api","common"})
     */
    public function getThumb() {
        return isset($this->fileInfo['thumbUrl']) ? $this->fileInfo['thumbUrl'] : null;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Media
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
     * Set description
     *
     * @param string $description
     * @return Media
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
     * @Groups({"api","common"})
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set fileInfo
     *
     * @param array $fileInfo
     * @return Media
     */
    public function setFileInfo($fileInfo)
    {
        $this->fileInfo = $fileInfo;

        return $this;
    }

    /**
     * Get fileInfo
     *
     * @return array
     */
    public function getFileInfo()
    {
        return $this->fileInfo;
    }

    /**
     * Set album
     *
     * @param \GalleryBundle\Entity\Album $album
     * @return Media
     */
    public function setAlbum(\GalleryBundle\Entity\Album $album = null)
    {
        $this->album = $album;

        return $this;
    }

    /**
     * Get album
     *
     * @return \GalleryBundle\Entity\Album 
     */
    public function getAlbum()
    {
        return $this->album;
    }
}
