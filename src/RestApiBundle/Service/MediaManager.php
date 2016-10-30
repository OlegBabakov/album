<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 29.10.16
 * Time: 19:35
 */

namespace RestApiBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;

class MediaManager
{
    const REQUEST_DATA_FORMAT = 'json';
    const IMAGES_LIMIT_PER_PAGE = 10;

    /**@var Registry */
    private $doctrine;
    /**@var Request */
    private $request;
    /**@var SerializerService */
    private $serializer;
    /**@var Paginator*/
    private $paginator;

    /**
     * MediaManager constructor.
     * @param Registry $doctrine
     * @param Request $request
     * @param SerializerService $serializer
     * @param \Knp\Component\Pager\Paginator $paginator
     */
    public function __construct($doctrine, $request, $serializer, $paginator)
    {
        $this->doctrine = $doctrine;
        $this->request = $request;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
    }

    /**
     * Return media collection by selected album and page
     * @return array
     */
    public function getMedias() {
        $album =$this->request->get('album');
        if (!$album) return null;

        $dql   = "SELECT m FROM GalleryBundle:Media m WHERE m.album = :album";
        $query = $this->doctrine->getManager()->createQuery($dql);
        $query->setParameter('album', $album);

        $page = $this->request->get('page') ? : 1;
        $pagination = $this->paginator->paginate(
            $query,
            $page,
            $this::IMAGES_LIMIT_PER_PAGE
        );

        $collection = $pagination->getItems();
        if ($collection) {
            $collection = $this
                ->serializer
                ->getSerializer()
                ->normalize(
                    $collection,
                    $this::REQUEST_DATA_FORMAT,
                    ['groups' => ['api']]
                );
            return $collection;
        }
        return [];
    }

}