<?php

namespace App;

class Post
{
    public string $post;

    public function __construct(string $post)
    {
        $this->post = $post;
    }

    public function getPost(): string
    {
        return $this->post;
    }
}