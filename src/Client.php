<?php

namespace ArnaudLier\DuolingoPHP;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

class Client
{
    protected ?string $identifier = null;
    protected ?string $password = null;
    protected ?string $jwt = null;
    protected ?\GuzzleHttp\Client $client = null;

    const USER_AGENT = 'DuolingoPHP/0.1.0 (+https://www.github.com/ArnaudLier/duolingo-php)';

    /**
     * @param string $identifier email or username
     * @param string|null $password the account's password
     * @param string|null $jwt can be provided instead of username and password
     * @throws GuzzleException
     */
    public function __construct(string $identifier, ?string $password = null, ?string $jwt = null)
    {
        $this->client = new \GuzzleHttp\Client([
            RequestOptions::TIMEOUT => 5.0,
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
            ]
        ]);

        if (! $jwt) {
            $this->identifier = $identifier;
            $this->password = $password;

            $response = $this->client->post('https://www.duolingo.com/login', [
                RequestOptions::JSON => [
                    'login' => $this->identifier,
                    'password' => $this->password,
                ]
            ]);

            $this->jwt = $response->getHeaderLine('jwt');
        } else {
            $this->jwt = $jwt;
        }
    }

    /**
     * @return Leaderboard
     * @throws GuzzleException
     */
    public function getLeaderboard(): Leaderboard
    {
        $id = $this->getUser()->id;

        $response = $this->client->get(
            "https://duolingo-leaderboards-prod.duolingo.com/leaderboards/7d9f5dd1-8423-491a-91f2-2532052038ce/users/$id?client_unlocked=true",
            [
                RequestOptions::HEADERS => [
                    'User-Agent' => self::USER_AGENT,
                    'Authorization' => "Bearer $this->jwt"
                ]
            ]);

        return new Leaderboard(json_decode($response->getBody(), true));
    }

    /**
     * @param string|null $identifier email or username
     * @return User
     * @throws GuzzleException
     */
    public function getUser(?string $identifier = null): User
    {
        if (!$identifier) {
            $identifier = $this->identifier;
        }

        $url = 'https://www.duolingo.com/2017-06-30/users?';

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $url .= "email=" . $identifier;
        } else {
            $url .= "username=" . $identifier;
        }

        $response = $this->client->get($url, [
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
                'Authorization' => "Bearer $this->jwt"
            ]
        ]);

        return new User(json_decode($response->getBody(), true)['users'][0]);
    }

    /**
     * @return Vocabulary|null null if not logged in
     * @throws GuzzleException
     */
    public function getVocabulary(): ?Vocabulary
    {
        $response = $this->client->get('https://www.duolingo.com/vocabulary/overview', [
            RequestOptions::HEADERS => [
                'User-Agent' => self::USER_AGENT,
                'Authorization' => "Bearer $this->jwt"
            ]
        ]);

        return new Vocabulary(json_decode($response->getBody(), true));
    }

    /**
     * @return string|null
     */
    public function getJwt(): ?string
    {
        return $this->jwt;
    }
}
