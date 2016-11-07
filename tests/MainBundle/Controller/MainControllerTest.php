<?php

namespace GalleryBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    /**
     * Simple test to assert that mainpage loads correctly
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertContains('Gallery', $client->getResponse()->getContent());
    }
}
