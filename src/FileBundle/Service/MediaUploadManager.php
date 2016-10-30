<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 30.10.16
 * Time: 18:22
 */

namespace FileBundle\Service;


use Doctrine\ORM\EntityManager;
use GalleryBundle\Entity\Media;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Oneup\UploaderBundle\Event\PostPersistEvent;

class MediaUploadManager
{
    const MEDIA_LIIP_THUMB_FILTER_NAME = 'album_thumb';

    protected $entityManager;
    protected $imageCacheManager;

    /**
     * MediaUploadManager constructor.
     * @param EntityManager $entityManager
     * @param CacheManager $imageCacheManager
     */
    public function __construct(EntityManager $entityManager, CacheManager $imageCacheManager)
    {
        $this->entityManager = $entityManager;
        $this->imageCacheManager = $imageCacheManager;
    }

    /**
     * Gallery media upload handler and procesing (e.g. thumb url providing)
     * @param PostPersistEvent $event
     */
    public function upload(PostPersistEvent $event) {
        /**@var \Symfony\Component\HttpFoundation\File\File $file*/
        $file = $event->getFile();
        /**@var \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile*/
        $uploadedFile = $event->getRequest()->files->get('file');
        //Choose upload behavior based on content type, mapping is set by 'oneup_uploader' in app/config.yml
        $fileMappingType = $event->getType();

        $album = $this
            ->entityManager
            ->getRepository('GalleryBundle:Album')
            ->find(
                $event->getRequest()->get('album')
            );

        if ($album) {
            $object = new Media();

            $fileInfo['url']          = "/uploads/{$fileMappingType}/{$file->getFilename()}";
            $fileInfo['thumbUrl']     = $this->imageCacheManager->getBrowserPath($fileInfo['url'], $this::MEDIA_LIIP_THUMB_FILTER_NAME);
            $fileInfo['absolutePath'] = $file->getPathname();
            $fileInfo['originalName'] = $uploadedFile->getClientOriginalName();
            $fileInfo['mimeType']     = $uploadedFile->getClientMimeType();
            $fileInfo['size']         = $uploadedFile->getClientSize();

            $object->setUrl($fileInfo['url']);
            $object->setFileInfo($fileInfo);
            $object->setAlbum($album);

            $this->entityManager->persist($object);
            $this->entityManager->flush();
        } else {
            unlink($file->getPathname());
        }
    }
}