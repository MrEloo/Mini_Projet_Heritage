<?php


class Category
{
    private ?int $id = null;
    private string $title;
    private string $description;
    private array $posts = [];



    public function __construct(string $title, string $description)
    {
        $this->title = $title;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPosts(): array
    {
        return $this->posts;
    }
    public function setPosts(array $posts): void
    {
        $this->posts = $posts;
    }

    public function addPost(array $posts): void
    {
        if (!isset($posts)) {
            $this->posts[] = $posts;
        }
    }

    public function removePost(Post $postsToRemove): void
    {
        foreach ($this->posts as $key => $category) {
            if ($postsToRemove === $category) {
                unset($this->posts[$key]);
            }
        }
    }
}
