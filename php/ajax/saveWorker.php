<?php

//
// Save worker file, author and email.
//
// @param author {String}
// @param email {String}
// @param worker {File}
//

$file = $_FILES["worker"];
if(isset($file) && $file["error"]== UPLOAD_ERR_OK) {

  require_once('sql.php');
  connectToDatabase();

  $name = $file['name'];
  $author = getPost($_POST, "name");
  $email = getPost($_POST, "email");

  //$email = checkStartDate($email);
  checkFileSize($file);
  checkFileType($file);
  checkFileName($name);
  checkAuthor($author);
  checkEmail($email);

  if (move_uploaded_file($file['tmp_name'], $WORKER_DIR.$name)) {
    insertNewWorker($name, $author, $email);
    echo 'Worker was uploaded successfully!';
  } else {
    die('Error: Unexpected move_uploaded_file error.');
  }

} else {
  die('Error: Unexpected upload error.');
}

// --- private functions ---

function getPost($post, $key) {
  if (isset($post[$key])) {
    return $post[$key];
  }
  return null;
}

function checkFileSize($file) {
  if ($file["size"] > 100000) {
    die('Error: File size is too big! Maximal 100000 bytes are allowed.');
  }
}

function checkFileType($file) {
  if (strpos($file['type'], 'javascript') === false) {
    die('Error: Unsupported file type. Only javascript workers are allowed.');
  }
}

function checkFileName($name) {
  if (strlen($name) > 25) {
    die('Error: File name too long! Maximal 25 characters are allowed.');
  }
  if (!preg_match("#^[a-zA-Z0-9_-]+$#", pathinfo($name, PATHINFO_FILENAME))) {
    die('Error: File name contains unsupported characters! Allowed characters: a-zA-Z0-9_-');
  }
  if (!isNewWorker($name)) {
    die('Error: Workername already exists. Rename file.');
  }
}

function checkAuthor($author) {
  if (strlen($author) < 3) {
    die('Error: Enter your name! At least 3 characters.');
  }
  if (strlen($author) > 50) {
    die('Error: Your name is too long! Maximal 50 characters are allowed.');
  }
}

function checkEmail($email) {
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Error: Please enter a valid email.');
  }
  if (strlen($email) > 50) {
    die('Error: Email is too long! Maximal 50 characters are allowed.');
  }
}

function checkStartDate($email) {
  if (isSuperuser($email)) {
    return 'info@webworkercontest.net';
  }
  $currentTime = time();
  $startTime = mktime(0, 0, 0, 5, 27, 2014);
  if ($currentTime >= $startTime) {
    return $email;
  }
  die('Noch etwas Geduld. Am 27.05.2014 geht es los!');
}
?>