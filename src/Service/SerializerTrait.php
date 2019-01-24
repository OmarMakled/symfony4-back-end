<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Service;

use JMS\Serializer\SerializerBuilder;

trait SerializerTrait
{
    /**
     * Serialize object.
     * 
     * @param mixed $result
     * 
     * @return []
     */
    public function serialize($result)
    {
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($result, 'json');

        return json_decode($jsonContent);
    }
}
