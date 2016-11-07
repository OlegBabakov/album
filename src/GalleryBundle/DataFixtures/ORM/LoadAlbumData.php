<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 02.11.16
 * Time: 14:30
 */

namespace GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GalleryBundle\Entity\Media;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GalleryBundle\Entity\Album;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadAlbumData implements FixtureInterface, ContainerAwareInterface
{
    const MEDIA_LIIP_THUMB_FILTER_NAME = 'album_thumb';

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load fixture files in gallery albums
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cacheManager = $this->container->get('liip_imagine.cache.manager');
        $webPath      = $this->container->getParameter('gallery_fixtures_web_path');
        $absolutePath = $this->container->getParameter('kernel.root_dir'). '/../web'. $webPath;

        $albumFinder = new Finder();
        $albumFinder = $albumFinder->directories()->sortByName()->in($absolutePath);
        foreach ($albumFinder as $albumDir) {
            /**@var SplFileInfo $albumDir*/
            $album = new Album();
            $album->setTitle(ucfirst($albumDir->getRelativePathname()));

            $mediaFinder  = new Finder();
            $mediaFinder = $mediaFinder
                ->files()
                ->sortByName()
                ->in($albumDir->getPathname());
            foreach ($mediaFinder as $mediaFile) {
                /**@var SplFileInfo $mediaFile*/
                $media = new Media();

                $media->setTitle($this->mediaTitleProvider($mediaFile));
                $media->setUrl("{$webPath}/{$albumDir->getRelativePathname()}/{$mediaFile->getRelativePathname()}");

                $fileInfo = [];
                $fileInfo['url']          = $media->getUrl();
                $fileInfo['thumbUrl']     = str_replace('http://localhost', '',
                    $cacheManager->getBrowserPath(
                        $fileInfo['url'],
                        $this::MEDIA_LIIP_THUMB_FILTER_NAME
                    )
                );
                $fileInfo['absolutePath'] = $mediaFile->getPathname(); #because fixtures load from CLI and SF doesn't know real URL from request
                $fileInfo['originalName'] = $mediaFile->getRelativePathname();
                $fileInfo['size']         = $mediaFile->getSize();
                $media->setFileInfo($fileInfo);

                $media->setAlbum($album);
                $manager->persist($media);
            }
            unset($mediaFinder);
            $manager->persist($album);
        }
        $manager->flush();
    }

    /**
     * Makes good look media title from file name
     * @param SplFileInfo $mediaFile
     * @return mixed|string
     */
    private function mediaTitleProvider(SplFileInfo $mediaFile) {
        $filename = $mediaFile->getBasename('.'.$mediaFile->getExtension());
        $filename = preg_replace('/[._-]/u', ' ', $filename);
        return ucfirst($filename);
    }

    /**
     * Load fixture order
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}