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
$size = 80;
$grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;


?>

<a class="btn" href="<?= $urlToPosts ?>">Back</a>


<div class="post">
    
    <h1><?= $post->title ?></h1>
    <div class="post-body">
        <div class="post-profile">
            <img src="<?= $grav_url ?>" alt="Gravatar Image">
            <p><a href="<?= url("user/profile/{$author->userId}") ?>"><?= $author->username ?></a></p>
        </div>
        <div class="post-text">
            <p><?= $filter->parse($post->text, ["markdown"])->text ?></p>
        </div>
    </div>
    <p>Created: <?= $post->pCreated ?></p>
    <?php if ($this->di->get("session")->get("user")) : ?>
        <p>
            <a class="btn" href="<?= $urlToCreateComment ?>">Reply</a>
            <?php if ($this->di->get("session")->get("user")["id"] == $author->userId) : ?>
            <a class="btn" href="<?= url("post/update/$post->postId") ?>">Edit post</a>
            <a class="btn" href="<?= url("post/delete/$post->postId") ?>">Delete post</a>
            <?php endif; ?>
        </p>
        <?php endif; ?>
</div>

<!-- 
<h2>Comments</h2> -->
