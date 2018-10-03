<?php

$url = $_SERVER['REQUEST_URI'];

if (strpos($url, '/') !== 0) {
   $url = "/$url";
}

$dbInstance = new DB();
$dbConn = $dbInstance->connect($db);

if ($url = "/posts" && $_SERVER['REQUEST_METHOD'] == 'GET') {
   $post = getAllPosts($dbConn);
   echo json_encode($post);
}

if ($url = '/posts' && $_SERVER['REQUEST_METHOD'] == 'POST') {
   $input = $_POST;

   $id = addPost($input, $dbConn);

   if ($id) {
      $input['id'] = $id;
      $input['link'] = "/posts/$id";
   }

   echo json_encode($input);
}

function getAllPosts($db) {
   $statement = $db->prepare("SELECT * FROM posts");
   $statement->execute();
   return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function addPost($input, $db){
   $sql = "INSERT INTO posts (title, status, content, user_id) VALUES (:title, :status, :content, :user_id)";

   $statement = $db->prepare($sql);

   $statement->bindValue(':title', $input['title']);
   $statement->bindValue(':status', $input['status']);
   $statement->bindValue(':content', $input['content']);
   $statement->bindValue(':user_id', $input['user_id']);

   $statement->execute();

   return $db->lastInsertId();
}