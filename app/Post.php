<?php declare(strict_types=1);

namespace App;

class Post
{
    public float $post;

    public function __construct( float $post)
    {
        $this->post = $post;
    }

    public function getPost(): float
    {
        return $this->post;
    }
}