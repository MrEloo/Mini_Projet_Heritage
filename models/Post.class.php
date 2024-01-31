<?php


class Post
{
    private ?int $id = null;
    private string $title;
    private string $excerpt;
    private string $content;
    private User $user;
    private array $categories = [];



    public function __construct(string $title, string $excerpt, string $content, User $user)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->content = $content;
        $this->user = $user;
    }

    public function getId(): ?int
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

    public function getExcerpt(): string
    {
        return $this->excerpt;
    }
    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getAuthor(): User
    {
        return $this->user;
    }
    public function setAuthor(User $user): void
    {
        $this->user = $user;
    }

    public function getCategory(): array
    {
        return $this->categories;
    }
    public function setCategory(array $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category): void
    {
        // Vérifiez si la catégorie n'est pas déjà présente dans le tableau
        if (!in_array($category, $this->categories, true)) {
            $this->categories[] = $category;
        }
    }

    public function removeCategory($categoryToRemove): void
    {
        foreach ($this->categories as $key => $category) {
            if ($categoryToRemove === $category) {
                unset($this->categories[$key]);
            }
        }
    }
}
