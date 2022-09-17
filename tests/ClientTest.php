<?php

use ArnaudLier\DuolingoPHP\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @throws GuzzleException
     */
    public function testUserWithNoPassword(): Client
    {
        $duolingo = new Client($_SERVER['DUOLINGO_IDENTIFIER']);

        $this->assertNotNull($duolingo->getUser());

        return $duolingo;
    }

    /**
     * @throws GuzzleException
     */
    public function testUserWithPassword(): Client
    {
        $duolingo = new Client($_SERVER['DUOLINGO_IDENTIFIER'], $_SERVER['DUOLINGO_PASSWORD']);

        $this->assertNotNull($duolingo->getUser());

        return $duolingo;
    }

    /**
     * @depends testUserWithNoPassword
     *
     * @param Client $duolingo
     * @return void
     * @throws GuzzleException
     */
    public function testLeaderboard(Client $duolingo): void
    {
        $this->assertNotNull($duolingo->getLeaderboard());
    }

    /**
     * @depends testUserWithPassword
     *
     * @param Client $duolingo
     * @return void
     * @throws GuzzleException
     */
    public function testVocabulary(Client $duolingo): void
    {
        $this->assertNotNull($duolingo->getVocabulary());
    }
}
