<?php

namespace JobApplication_2019_02_24\Interfaces;

use JobApplication_2019_02_24\Models\Post;

interface StatisticsCalculator
{
    /**
     * @param Post[] $posts
     *
     * @return mixed
     */
    public function calculate(array $posts);

}