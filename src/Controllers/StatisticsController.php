<?php

namespace JobApplication_2019_02_24\Controllers;


use JobApplication_2019_02_24\Interfaces\Response;

class StatisticsController
{
    public function index(Response $response)
    {
        $response->success(['test' => "test"]);
    }
}