<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->autowire(JobApplication_2019_02_24\Components\Response\JsonResponse::class)
    ->setPublic(true);

$containerBuilder->setAlias(
    JobApplication_2019_02_24\Interfaces\Response::class,
    JobApplication_2019_02_24\Components\Response\JsonResponse::class
)->setPublic(true);

$containerBuilder->autowire(\JobApplication_2019_02_24\Controllers\StatisticsController::class)
    ->setPublic(true);

$containerBuilder->compile();

return $containerBuilder;