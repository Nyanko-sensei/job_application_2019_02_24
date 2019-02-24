<?php

namespace JobApplication_2019_02_24\Components\StatisticsCalculator;


use JobApplication_2019_02_24\Interfaces\StatisticsCalculator;
use JobApplication_2019_02_24\Models\Post;

class PostsStatisticsCalculator implements StatisticsCalculator
{
    private $unprocessedStats;

    /**
     * @param Post[] $posts
     *
     * @return mixed
     */
    public function calculate(array $posts)
    {
        $this->clearUnprocessedStats();

        foreach ($posts as $post) {
            $this->addPost($post);
        }

        return $this->aggregateData();
    }

    private function clearUnprocessedStats()
    {
        $this->unprocessedStats = [
            'by_month' => [
                'total' => [],
                'users' => [],
            ],
            'by_week' => [
                'total' => [],
                'users' => [],
            ],
        ];
    }

    private function addPost(Post $post)
    {
        $user_id = $post->getFromId();
        $week = $post->getCreatedTime()->copy()->startOfWeek()->toDateString();
        $month = $post->getCreatedTime()->copy()->firstOfMonth()->toDateString();
        $postLength = strlen($post->getMessage());


        $this->unprocessedStats['by_month']['total'][$month] = $this->getUpdatedEntry($post,
            $this->unprocessedStats['by_month']['total'][$month] ?? [], $postLength);

        $this->unprocessedStats['by_month']['users'][$month][$user_id] = $this->getUpdatedEntry($post,
            $this->unprocessedStats['by_month']['users'][$month][$user_id] ?? [], $postLength);

        $this->unprocessedStats['by_week']['total'][$week] = $this->getUpdatedEntry($post,
            $this->unprocessedStats['by_week']['total'][$week] ?? [], $postLength);

        $this->unprocessedStats['by_week']['users'][$week][$user_id] = $this->getUpdatedEntry($post,
            $this->unprocessedStats['by_week']['users'][$week][$user_id] ?? [], $postLength);
    }

    private function aggregateData()
    {
        $result =  [];

        foreach ($this->unprocessedStats['by_month']['total'] ?? [] as $month => $data) {
            $result['average_character_length_per_post_per_month']['total'][$month] =
                $data['total_characters']/$data['total_posts'];

            $result['longest_post_by_character_length']['total'][$month] =  [
                'longest_post_message' => $data['longest_post_message'],
                'longest_post_id'=> $data['longest_post_id']
            ];
        }


        foreach ($this->unprocessedStats['by_month']['users'] ?? [] as $month => $data){
            $totalUserPosts = 0;
            foreach ($data as $userData)  {
                $totalUserPosts += $userData['total_posts'];
            }
            $result['average_number_of_posts_per_user_per_month'][$month] = $totalUserPosts/count($data);
        }

        foreach ($this->unprocessedStats['by_week']['total'] as $week => $data) {
            $result['total_posts_per_week']['total'][$week] = $data['total_posts'];
        }

        return $result;
    }

    private function getUpdatedEntry(Post$post, $result = [], $postLength)
    {
        if (empty($result)) {
            $result = [
                'total_posts' => 1,
                'total_characters' => $postLength,
                'longest_post_length' => $postLength,
                'longest_post_message' => $post->getMessage(),
                'longest_post_id' => $post->getId(),
            ];
        } else {
            $result['total_posts']++;
            $result['total_characters'] += $postLength;

            if ($result['longest_post_length'] < $postLength) {
                $result['longest_post_length'] = $postLength;
                $result['longest_post_message'] = $post->getMessage();
                $result['longest_post_id'] = $post->getId();
            }
        }

        return $result;
    }
}