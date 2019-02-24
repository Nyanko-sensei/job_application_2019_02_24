<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

// Response formatter
$containerBuilder->autowire(JobApplication_2019_02_24\Components\Response\JsonResponse::class)
    ->setPublic(true);

$containerBuilder->setAlias(
    JobApplication_2019_02_24\Interfaces\Response::class,
    JobApplication_2019_02_24\Components\Response\JsonResponse::class
)->setPublic(true);

// Post Repository

$containerBuilder->autowire(\JobApplication_2019_02_24\Components\SupermetricsApIWrapper\ApiWrapper::class);

$containerBuilder->setAlias(
    \JobApplication_2019_02_24\Interfaces\PostsRepository::class,
    \JobApplication_2019_02_24\Components\SupermetricsApIWrapper\ApiWrapper::class
)->setPublic(true);

// Statistics calculator

$containerBuilder->autowire(\JobApplication_2019_02_24\Components\StatisticsCalculator\PostsStatisticsCalculator::class);

$containerBuilder->setAlias(
    \JobApplication_2019_02_24\Interfaces\StatisticsCalculator::class,
    \JobApplication_2019_02_24\Components\StatisticsCalculator\PostsStatisticsCalculator::class
)->setPublic(true);

//Controllers
$containerBuilder->autowire(\JobApplication_2019_02_24\Controllers\StatisticsController::class)
    ->setPublic(true);

$containerBuilder->compile();

return $containerBuilder;