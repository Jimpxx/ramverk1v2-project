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
$urlToCreateComment = url("comment/create/$post->postId");

// Gravatar Image
$email = $author->email;
$size = 40;
$grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;


?>

<a href="<?= $urlToPosts ?>">Back</a>

<?php if ($this->di->get("session")->get("user")["id"] == $author->userId) : ?>
<p>
<a href="<?= url("post/update/$post->postId") ?>">Edit post</a>
</p>
<?php endif; ?>

<h1><?= $post->title ?></h1>

<p><?= $filter->parse($post->text, ["markdown"])->text ?></p>
<p>Creator: <p><a href="<?= url("user/profile/{$author->userId}") ?>"><?= $author->username ?></a></p></p>
<img src="<?= $grav_url ?>" alt="Gravatar Image">

<?php if ($this->di->get("session")->get("user")) : ?>
<p>
<a href="<?= $urlToCreateComment ?>">Reply</a>
</p>
<?php endif; ?>

<!-- 
<h2>Comments</h2> -->
