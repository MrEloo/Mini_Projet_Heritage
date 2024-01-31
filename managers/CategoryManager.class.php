<?php


class CategoryManager extends AbstractManager
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $selectAllQuery = $this->db->prepare('SELECT * FROM categories');
        $selectAllQuery->execute();
        $categoriesDatas = $selectAllQuery->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];

        foreach ($categoriesDatas as $key => $categoryData) {
            $categoryData =  new Category($categoryData['title'], $categoryData['description']);
            $categoryData->setId($categoryData['id']);
            $categories[] = $categoryData;
        }

        return $categories;
    }

    public function findOne(int $id): ?Category
    {
        $selectOneQuery = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $parameters = ['id' => $id];
        $selectOneQuery->execute($parameters);
        $categoryData = $selectOneQuery->fetch(PDO::FETCH_ASSOC);
        if ($categoryData) {
            return            $categoryData =  new Category($categoryData['title'], $categoryData['description']);
        } else {
            return null;
        }
    }

    public function create(Category $category): void
    {
        $CreateQuery = $this->db->prepare('INSERT INTO posts (title, description) VALUES (:title, :description)');
        $parameters = [
            'id' => $category['id'],
            'title' => $category['title'],
            'desciption' => $category['desciption'],
        ];
        $CreateQuery->execute($parameters);
    }

    public function update(Category $category): void
    {
        $updateQuery = $this->db->prepare('UPDATE categories SET title = :title, description = :descriptionWHERE id = :id');
        $parameters = [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'desciption' => $category->getDescription(),
        ];
        $updateQuery->execute($parameters);
    }

    public function delete(int $id): void
    {
        $deleteQuery = $this->db->prepare('DELETE FROM categories WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $deleteQuery->execute($parameters);
    }
}
