<?php

namespace JobApplication_2019_02_24\Interfaces;

interface Response
{
    public function fail(string $msg);

    public function success(array $payload);
}