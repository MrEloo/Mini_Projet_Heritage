<?php

require 'managers/AbstractManager.class.php';
require 'managers/UserManager.class.php';
require 'managers/PostsManager.class.php';
require 'managers/CategoryManager.class.php';
require 'models/User.class.php';
require 'models/Post.class.php';
require 'models/Category.class.php';

$posts = new PostsManager();
$user = new UserManager();
$myUser = $user->findOne(3);


$post = new Post("Mon post", 'Mon résumé', 'Mon contenu', $myUser);
$posts->update($post, $myUser, 4);
// Afficher les utilisateurs après avoir appelé findAll()
var_dump($post);
