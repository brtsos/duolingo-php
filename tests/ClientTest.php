<?php

use ArnaudLier\DuolingoPHP\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testLoginWithPassword()
    {
        $duolingo = new Client($_SERVER['DUOLINGO_IDENTIFIER'], $_SERVER['DUOLINGO_PASSWORD']);

        $this->assertNotNull($duolingo->getUser());
    }
}