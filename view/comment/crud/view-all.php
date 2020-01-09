<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$comments = isset($comments) ? $comments : null;
$users = isset($users) ? $users : null;

// Create urls for navigation
$urlToCreate = url("comment/create");
$urlToDelete = url("comment/delete");



?>
<!-- <h1>View all items</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create</a> | 
    <a href="<?= $urlToDelete ?>">Delete</a>
</p> -->

<?php if (!$comments) : ?>
    <p>There are no comments for this post.</p>
<?php
    return;
endif;
?>

<?php foreach ($comments as $comment) : ?>
<div class="comment" style="padding-left:<?= $comment->padding ?>rem">
    <?php 
        // Gravatar Image
        $email = $comment->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;
    ?>
    <p><?= $filter->parse($comment->text, ["markdown"])->text ?></p>
    <p><a href="<?= url("user/profile/{$comment->user_id}") ?>"><?= $comment->username ?></a></p>
    <p><?= $comment->cCreated ?></p>
    <img src="<?= $grav_url ?>" alt="Gravatar Image">
    <?php if ($comment->userId == $this->di->get("session")->get("user")["id"]) : ?>
        <p>
        <a href="<?= url("comment/update/{$comment->commentId}"); ?>">Edit comment</a>
        </p>
    <?php endif; ?>
    <?php if ($this->di->get("session")->get("user")["id"]) : ?>
        <p>
        <a href="<?= url("comment/create/{$comment->post_id}?replyId={$comment->commentId}"); ?>">Reply to comment</a>
        </p>
    <?php endif; ?>
</div>
<?php endforeach; ?>


<!-- <table>
    <tr>
        <th>Id</th>
        <th>Text</th>
        <th>User_ID</th>
        <th>Post_ID</th>
        <th>Comment_ID</th>
        <th>Created</th>
    </tr>
    <?php foreach ($comments as $item) : ?>
    <tr>
        <td>
            <a href="<?= url("comment/update/{$item->id}"); ?>"><?= $item->id ?></a>
        </td>
        <td><?= $item->text ?></td>
        <td><?= $item->user_id ?></td>
        <td><?= $item->post_id ?></td>
        <td><?= $item->comment_id ?></td>
        <td><?= $item->created ?></td>
    </tr>
    <?php endforeach; ?>
</table> -->
