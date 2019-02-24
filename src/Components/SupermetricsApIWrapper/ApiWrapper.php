<?php

namespace JobApplication_2019_02_24\Components\SupermetricsApIWrapper;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use JobApplication_2019_02_24\Interfaces\PostsRepository;
use JobApplication_2019_02_24\Models\Post;

class ApiWrapper implements PostsRepository
{
    const API_URL = 'https://api.supermetrics.com/assignment/';
    /** @var Client */
    private $client;
    private $slToken;
    private $clientId;
    private $email;
    private $name;

    public function __construct()
    {
        $this->client = new Client;

        $this->clientId = getenv('SPM_CLIENT_ID');
        $this->email = getenv('SPM_EMAIL');
        $this->name = getenv('SPM_NAME');
    }

    public function login()
    {
        $result = $this->client->post(self::API_URL . 'register', [
            \GuzzleHttp\RequestOptions::JSON => [
                'client_id' => $this->clientId,
                'email' => $this->email,
                'name' => $this->name,
            ],
        ]);

        $result = \GuzzleHttp\json_decode($result->getBody()->getContents(), true);

        if (! empty($result['data']['sl_token'])) {
            $this->setSlToken($result['data']['sl_token']);
        }
    }

    public function getAllPosts()
    {
        $posts = [];


        foreach ($this->getAllPostsRawData() as $postData) {
            $posts[] = Post::createFromArray($postData);
        }

        return $posts;
    }

    public function getAllPostsRawData()
    {
        $allPosts = [];

        $i = 1;
        $lastPageRetrieved = false;

        while(!$lastPageRetrieved) {
            $pageData = $this->getRawPostsData($i);

            if ($pageData['page'] ==  $i ) {
                $allPosts =  array_merge($allPosts,  $pageData['posts']);
                $i++;
            } else {
                $lastPageRetrieved = true;
            }
        }

        return $allPosts;
    }

    public function getRawPostsData($page, $reloginIfNeeded = true)
    {
        if (empty($this->getSlToken())) {
            $this->login();
        }

        try {
            $result = $this->client->get(self::API_URL . 'posts', [
                \GuzzleHttp\RequestOptions::QUERY => [
                    "page" => $page,
                    "sl_token" => $this->getSlToken(),
                ],
            ]);
        } catch (ServerException $exception) {
            if ($reloginIfNeeded) {
                $result = \GuzzleHttp\json_decode($exception->getResponse()->getBody()->getContents(), true);

                if (! empty($result['error']['message']) && $result['error']['message'] == 'Invalid SL Token') {

                    $this->setSlToken(null);

                    return $this->getRawPostsData($page, false);
                }
            }
        }

        $result = \GuzzleHttp\json_decode($result->getBody()->getContents(), true);

        return $result['data'];
    }

    /**
     * @return mixed
     */
    public function getSlToken()
    {
        return $this->slToken;
    }

    /**
     * @param mixed $slToken
     */
    public function setSlToken($slToken)
    {
        $this->slToken = $slToken;
    }
}