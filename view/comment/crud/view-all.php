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

<?php if (!$comments) : ?>
    <p>There are no comments for this post.</p>
    <?php
    return;
endif;
?>

<?php foreach ($comments as $comment) : ?>
<div class="comment" style="margin-left:<?= $comment->padding ?>rem">
    <?php
        // Gravatar Image
        $email = $comment->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;
    ?>
    <div class="comment-body">
        <div class="comment-profile">
            <img src="<?= $grav_url ?>" alt="Gravatar Image">
            <p><a href="<?= url("user/profile/{$comment->user_id}") ?>"><?= $comment->username ?></a></p>
        </div>
        <div class="comment-text">
            <p><?= $filter->parse($comment->text, ["markdown"])->text ?></p>
        </div>
    </div>
        <p>Created: <?= $comment->cCreated ?></p>
        <?php if ($this->di->get("session")->get("user")["id"]) : ?>
            <p>
                <a class="btn" href="<?= url("comment/create/{$comment->post_id}?replyId={$comment->commentId}"); ?>">Reply to comment</a>
                <?php if ($comment->userId == $this->di->get("session")->get("user")["id"]) : ?>
                    <a class="btn" href="<?= url("comment/update/{$comment->commentId}"); ?>">Edit comment</a>
                <?php endif; ?>
            </p>
        <?php endif; ?>
</div>
<?php endforeach; ?>
