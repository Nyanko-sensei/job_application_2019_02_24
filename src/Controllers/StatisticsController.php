<?php

namespace JobApplication_2019_02_24\Controllers;


use JobApplication_2019_02_24\Interfaces\PostsRepository;
use JobApplication_2019_02_24\Interfaces\Response;
use JobApplication_2019_02_24\Interfaces\StatisticsCalculator;

class StatisticsController
{
    public function index(Response $response, PostsRepository $repository, StatisticsCalculator  $statisticsCalculator)
    {
        $posts = $repository->getAllPosts();
        $statistics = $statisticsCalculator->calculate($posts);
        $response->success($statistics);
    }
}