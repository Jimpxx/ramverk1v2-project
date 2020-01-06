<?php

namespace Anax\View;

// /**
//  * View to display all books.
//  */
// // Show all incoming variables/functions
// //var_dump(get_defined_functions());
// //echo showEnvironment(get_defined_vars());

// // Gather incoming variables and use default values if not set
// $posts = isset($posts) ? $posts : null;

// // Create urls for navigation
// $urlToCreate = url("post/create");
$urlToPosts = url("post");




?>

<a href="<?= $urlToPosts ?>">Back</a>

<h1><?= $post->title ?></h1>

<p><?= $post->text ?></p>
<p>Creator: <?= $author->username ?></p>

<!-- 
<h2>Comments</h2> -->
