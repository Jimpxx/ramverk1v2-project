<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$posts = isset($posts) ? $posts : null;

// Create urls for navigation
$urlToCreate = url("post/create");
$urlToDelete = url("post/delete");



?><h1>View all Posts</h1>

<?php if ($this->di->get("session")->get("user")) : ?>
<p>
    <a class="btn" href="<?= $urlToCreate ?>">Create new post</a> 
</p>
<?php endif; ?>

<?php if (!$posts) : ?>
    <p>There are no posts to show.</p>
    <?php
    return;
endif; ?>


<?php foreach ($posts as $post) : ?>
    <?php
        // Gravatar Image
        $email = $post->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;
    ?>

<div class="post">
    <h3><?= $post->title ?></h3>
    <div class="post-body">
        <div class="post-profile">
            <img src="<?= $grav_url ?>" alt="">
            <p><a href="<?= url("user/profile/{$post->user_id}") ?>"><?= $post->username ?></a></p>
        </div>
        <div class="post-text">
            <p><?= $filter->parse($post->text, ["markdown"])->text ?></p>
        </div>
    </div>
    <p><a class="btn" href="<?= url("post/view/{$post->postId}"); ?>">View post</a> (Created: <?= $post->pCreated ?>)</p>

</div>
<?php endforeach; ?>
