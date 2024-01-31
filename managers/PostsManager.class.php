<?php


class PostsManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $selectAllQuery = $this->db->prepare('SELECT * FROM posts JOIN users ON posts.author = users.id ');
        $selectAllQuery->execute();
        $postsDatas = $selectAllQuery->fetchAll(PDO::FETCH_ASSOC);

        $posts = [];

        foreach ($postsDatas as $key => $postsData) {
            $Myusers =  new User($postsData['username'], $postsData['email'], $postsData['password'], $postsData['role']);
            $Myposts =  new Post($postsData['title'], $postsData['excerpt'], $postsData['content'], $Myusers);
            $Myusers->setId($postsData['id']);
            $Myposts->setId($postsData['id']);
            $posts[] = $Myposts;
        }

        return $posts;
    }

    public function findOne(int $id): ?Post
    {
        $selectOneQuery = $this->db->prepare('SELECT * FROM posts JOIN users ON posts.author = users.id WHERE posts.id = :id');
        $parameters = ['id' => $id];
        $selectOneQuery->execute($parameters);
        $postData = $selectOneQuery->fetch(PDO::FETCH_ASSOC);

        if ($postData) {
            $user = new User($postData['username'], $postData['email'], $postData['password'],  $postData['role']);

            $post = new Post($postData['title'], $postData['excerpt'], $postData['content'], $user);
            $post->setId($postData['id']); // Déplacez cette ligne avant le return
            $user->setId($postData['id']);
            return $post;
        } else {
            return null;
        }
    }

    public function create(object $post, User $user): void
    {
        $CreateQuery = $this->db->prepare('INSERT INTO posts (title, excerpt, content, author) VALUES (:title, :excerpt, :content, :author)');
        $parameters = [
            'title' => $post->getTitle(),
            'excerpt' => $post->getExcerpt(),
            'content' => $post->getContent(),
            'author' => $user->getId(),
        ];
        $CreateQuery->execute($parameters);
    }

    public function update(object $post, User $user, int $id): void
    {
        $updateQuery = $this->db->prepare('UPDATE posts SET title = :title, excerpt = :excerpt, content = :content, author = :author WHERE id = :id');
        $parameters = [
            'id' => $id,
            'title' => $post->getTitle(),
            'excerpt' => $post->getExcerpt(),
            'content' => $post->getContent(),
            'author' => $user->getId(),
        ];
        $updateQuery->execute($parameters);
    }

    public function delete(int $id): void
    {
        $deleteQuery = $this->db->prepare('DELETE FROM posts WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $deleteQuery->execute($parameters);
    }
}
