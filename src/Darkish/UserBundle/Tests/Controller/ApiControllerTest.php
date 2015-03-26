<?php

namespace Darkish\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testTest()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'api/test');
    }

}
