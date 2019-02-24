<?php

namespace JobApplication_2019_02_24\Components\StatisticsCalculator;


use JobApplication_2019_02_24\Interfaces\StatisticsCalculator;
use JobApplication_2019_02_24\Models\Post;

class PostsStatisticsCalculator implements StatisticsCalculator
{
    /**
     * @param Post[] $posts
     *
     * @return mixed
     */
    public function calculate(array $posts)
    {
        return  ['test'  => 'testas'];
    }
}