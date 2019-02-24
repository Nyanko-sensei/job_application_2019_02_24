<?php

declare(strict_types=1);

use JobApplication_2019_02_24\Components\StatisticsCalculator\PostsStatisticsCalculator;
use JobApplication_2019_02_24\Models\Post;
use PHPUnit\Framework\TestCase;


final class  PostsStatisticsCalculatorTest extends TestCase
{
    /**
     *
     * @test
     */
    public function canGetUsersFromJson(): void
    {
        $posts = [
            Post::createFromArray([
                "id" => "post1",
                "from_name" => "User One",
                "from_id"  => "user_1",
                "message" => "aaaa",
                "type" => "status",
                "created_time" => "2018-09-09T02:59:01+00:00"
            ]),
            Post::createFromArray([
                "id" => "post2",
                "from_name" => "User two",
                "from_id"  => "user_2",
                "message" => "aaaaaa",
                "type" => "status",
                "created_time" => "2018-09-24T02:59:01+00:00"
            ]),
            Post::createFromArray([
                "id" => "post3",
                "from_name" => "User two",
                "from_id"  => "user_2",
                "message" => "aaaaa",
                "type" => "status",
                "created_time" => "2018-09-30T02:59:01+00:00"
            ]),
        ];


        $statisticsCalculator = new PostsStatisticsCalculator();
        $stats = $statisticsCalculator->calculate($posts);

        $this->assertEquals(5, $stats['average_character_length_per_post_per_month']['total']['2018-09-01']);
        $this->assertEquals('post2', $stats['longest_post_by_character_length']['total']['2018-09-01']['longest_post_id']);
        $this->assertEquals(1.5, $stats['average_number_of_posts_per_user_per_month']['2018-09-01']);

        $this->assertEquals(2, $stats['total_posts_per_week']['total']['2018-09-24']);

        /*
         * - Average character length / post / month
         * - Longest post by character length / month
         * - Average number of posts per user / month
         * - Total posts split by week
         */

    }
}