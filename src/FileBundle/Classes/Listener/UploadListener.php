<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 11.10.16
 * Time: 12:46
 */

namespace FileBundle\Classes\Listener;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UploadListener
{
    /**@var ContainerInterface $container */
    private $container;

    /**
     * UploadListener constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * OneUp Uploader handler
     * @param PostPersistEvent $event
     */
    public function onUpload(PostPersistEvent $event)
    {
        //Album image upload mapping
        if ($event->getType() === 'gallery') {
            $this->container->get('file.media_upload_manager')->upload($event);
        }
        //You can add handlers for another file mapping types
    }
}