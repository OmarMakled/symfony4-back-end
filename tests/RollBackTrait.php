<?php

namespace App\Tests;


trait RollBackTrait
{
    protected $client;

    protected $em;

    public function setUp()
    {
        $this->client = $this->createClient(['environment' => 'test']);
        $this->client->disableReboot();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();
    }

    public function tearDown()
    {
        $this->em->rollback();
    }
}
