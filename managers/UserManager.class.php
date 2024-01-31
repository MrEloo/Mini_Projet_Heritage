<?php

class UserManager extends AbstractManager
{

    private array $allUsers = [];

    public function __construct()
    {
        parent::__construct();
    }

    public function findAll(): array
    {
        $selectAllQuery = $this->db->prepare('SELECT * FROM users');
        $selectAllQuery->execute();
        $usersDatas = $selectAllQuery->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($usersDatas as $usersData) {
            $Myusers =  new User($usersData['username'], $usersData['email'], $usersData['password'], $usersData['role']);
            $Myusers->setId($usersData["id"]);
            $users[] = $Myusers;
        }
        $this->allUsers = $users;

        return $users;
    }

    public function findOne(int $id): ?User
    {
        $selectOneQuery = $this->db->prepare('SELECT * FROM users WHERE id = :id');
        $parameters = ['id' => $id];
        $selectOneQuery->execute($parameters);
        $usersData = $selectOneQuery->fetch(PDO::FETCH_ASSOC);
        if ($usersData) {
            $Myusers =  new User($usersData['username'], $usersData['email'], $usersData['password'], $usersData['role']);
            $Myusers->setId($usersData["id"]);
            return $Myusers;
        } else {
            return null;
        }
    }

    public function create(User $user): void
    {
        $CreateQuery = $this->db->prepare('INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)');
        $parameters = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
        ];
        $CreateQuery->execute($parameters);

        $user->setId($this->db->lastInsertId());

        $this->allUsers[] = $user;
    }

    public function update(User $user, $id): void
    {
        $updateQuery = $this->db->prepare('UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id');
        $parameters = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'id' => $id,
        ];
        $updateQuery->execute($parameters);
    }

    public function delete(int $id): void
    {
        $deleteQuery = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $parameters = [
            'id' => $id,
        ];
        $deleteQuery->execute($parameters);
        foreach ($this->allUsers as $key => $users) {
            if ($users->getId() === $id) {
                unset($this->allUsers[$key]);
            }
        }
    }
}
