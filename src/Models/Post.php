<?php

namespace JobApplication_2019_02_24\Models;


use Carbon\Carbon;

class Post
{
    /** @var  string */
    private $id;
    /** @var  string */
    private $fromName;
    /** @var  string */
    private $fromId;
    /** @var  string */
    private $message;
    /** @var  string */
    private $type;
    /** @var  Carbon */
    private $createdTime;

    public static function createFromArray($postData)
    {
        $post = new self();
        $post->setId($postData['id'] ?? null);
        $post->setFromName($postData['from_name'] ?? null);
        $post->setFromId($postData['from_id'] ?? null);
        $post->setMessage($postData['message'] ?? null);
        $post->setType($postData['message'] ?? null);
        $post->setCreatedTime(Carbon::createFromTimestamp(strtotime($postData['created_time'] ?? null)));
        return $post;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string $fromName
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;
    }

    /**
     * @return string
     */
    public function getFromId()
    {
        return $this->fromId;
    }

    /**
     * @param string $fromId
     */
    public function setFromId($fromId)
    {
        $this->fromId = $fromId;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return Carbon
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param Carbon $createdTime
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }
}