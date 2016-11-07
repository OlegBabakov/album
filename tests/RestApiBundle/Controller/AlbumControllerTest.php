<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 06.11.16
 * Time: 23:02
 */

namespace RestApiBundle\Controller;


use RestApiBundle\Service\AlbumManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AlbumControllerTest extends WebTestCase
{
    private $albumManagerMock = null;

    /**
     * Overriding album manager service by mock object
     */
    protected function registerManagerMockAsService() {
        $container = self::$kernel->getContainer();
        if (!$container) $this->markTestSkipped('Kernel in not loaded to mock service');
        $container->set(
            'rest_api.album_manager',
            $this->albumManagerMock
        );
    }

    /**
     * Test asserts that rest AlbumController returns serialized album data after new album add
     */
    public function testGetAlbumAction() {

        $this->albumManagerMock = $this
            ->getMockBuilder(AlbumManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $addAlbumResult = [
            'id' => '1',
            'title' => 'MockSample',
            'mediasCount' => 5
        ];

        $this->albumManagerMock
            ->expects($this->any())
            ->method("addAlbum")
            ->will($this->returnValue($addAlbumResult));

        $client = static::createClient();
        $this->registerManagerMockAsService();

        $client->request('POST', '/api/v1/albums', [
            'title' => 'TestAlbum'
        ]);
        $response = $client->getResponse()->getContent();

        $this->assertContains(json_encode($addAlbumResult), $response);
    }

}