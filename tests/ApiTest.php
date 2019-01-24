<?php

/*
 * This file is part of Internations Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiTest extends WebTestCase
{
    use RollBackTrait;

    public function testAttachDetachGroup()
    {
        $user = $this->addUser()['id'];
        $group = $this->addGroup()['id'];
        $client = $this->client;

        // Attach
        $client->request('POST', "/api/users/${user}/groups/${group}");
        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        // Delete Group
        $client->request('DELETE', "/api/users/${user}/groups/${group}");
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    private function addUser()
    {
        $client = $this->client;
        $client->request('POST', '/api/users', ['name' => 'Alex']);

        return json_decode($client->getResponse()->getContent(), true)['user'];
    }

    private function addGroup()
    {
        $client = $this->client;
        $client->request('POST', '/api/groups', ['name' => 'Admin']);

        return json_decode($client->getResponse()->getContent(), true)['group'];
    }
}
