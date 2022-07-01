<?php
const ERROR_REQUIRED = 'Le champ doit etre rempli';
const ERROR_TOO_SHORT = 'Il faut 5 caractère minimun';
$error = '';
$filename = __DIR__ . "/data/todos.json";
$todos = [];
$todo = '';

if (file_exists($filename)) {
  $data = file_get_contents($filename);
  $todos = json_decode($data, true)  ?? [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $todo = $_POST['todo'] ?? '';

  if (!$todo) {
    $error = ERROR_REQUIRED;
  } elseif (mb_strlen($todo) < 5) {
    $error = ERROR_TOO_SHORT;
  }

  if (!$error) {
    $todos = [...$todos, [
      'name' => $todo,
      'done' => false,
      'id' => time()
    ]];

    file_put_contents($filename, json_encode($todos));
  }
}



?>






<!DOCTYPE html>
<html lang="fr">

<head>
  <?= require_once('includes/head.php') ?>
  <title>Document</title>
</head>

<body>
  <div class="container">
    <h1>Exercice Todo List</h1>
    <div class="todo-container">
      <form action="" method="POST" class="form">
        <input type="text" name="todo" class="form-todo">
        <button type="submit" class="btn">Ajouter</button>
      </form>
      <div class="form-error">
        <p><?= $error ?? '' ?></p>
      </div>
      <ul>
        <?php foreach ($todos as $t) : ?>
          <li class="todo-list">
            <p><?= $t['name'] ?></p>
            <button class="btn">Modifier</button>
            <button class="btn">Supprimmer</button>
          </li>
        <?php endforeach ?>

      </ul>
    </div>
  </div>
</body>

</html>