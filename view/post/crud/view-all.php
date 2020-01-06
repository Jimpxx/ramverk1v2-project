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

<p>
    <a href="<?= $urlToCreate ?>">Create new post</a> 
    <!-- |  -->
    <!-- <a href="<?= $urlToDelete ?>">Delete</a> -->
</p>

<?php if (!$posts) : ?>
    <p>There are no posts to show.</p>
<?php
    return;
endif;
?>


<?php foreach ($posts as $post) : ?>

<div class="post">
    <h3><?= $post->title ?></h3>
    <p><?= $post->text ?></p>

    <?php foreach ($users as $user) : ?>
        <?php if ($user->id == $post->user_id) : ?>
            <p>Creator: <?= $user->username ?></p>
        <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?= url("post/view/{$post->id}"); ?>">View post</a>
</div>
<?php endforeach; ?>



<!-- <table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>title</th>
        <th>text</th>
    </tr>
    <?php foreach ($posts as $post) : ?>
    <tr>
        <td>
            <a href="<?= url("post/view/{$post->id}"); ?>"><?= $post->id ?></a>
        </td>
        <td>
        <?php foreach ($users as $user) : ?>
            <?php if ($user->id == $post->user_id) : ?>
                <?= $user->username ?>
            <?php endif; ?>
        <?php endforeach; ?>
        </td>
        <td><?= $post->title ?></td>
        <td><?= $post->text ?></td>
    </tr>
    <?php endforeach; ?>
</table> -->
