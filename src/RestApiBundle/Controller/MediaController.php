<?php

namespace RestApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Get;

class MediaController extends FOSRestController
{
    /**
     * GET Route annotation.
     * @Get("/albums/{album}/page/{page}")
     */
    public function getMediasAction($album, $page) {
        return $this->createResponse(
            $this->get('rest_api.media_manager')->getMedias()
        );
    }

    private function createResponse($data = null) {
        return $this->handleView(
            $this->view($data, 200)
        );
    }
}