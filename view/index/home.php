<?php

namespace Anax\View;

// var_dump($_SESSION);
// var_dump($topUsers);
// var_dump($popularTags);

?>

<h1>Everything on Stocks</h1>
<p>On this site we try to keep the conversation to Stocks and finance.</p>
<p>To make posts, reply to posts and reply to comments you have to have an account and be logged in</p>

<h2>Current stats for the site</h2>

<h3>Latest posts</h3>

<?php foreach ($latestPosts as $post) : ?>
<div class="latest-posts">
    <p><a href="<?= url("post/view/{$post->postId}") ?>"><?= $post->title ?></a></p>
</div>
<?php endforeach; ?>

<h3>Most active users</h3>

<div class="active-users">
<?php foreach ($topUsers as $user) : ?>
    <?php
        // Gravatar Image
        $email = $user->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;
    ?>
    <div class="user">
    <img src="<?= $grav_url ?>" alt="">
    <p><a href="<?= url("user/profile/{$user->userId}") ?>"><?= $user->username ?> (<?= $user->amount ?> posts)</a></p>
    <!-- <p><?= $user->amount ?> posts</p> -->
    </div>
<?php endforeach; ?>
</div>

<h3>Popular tags</h3>
<div class="popular-tags">
    <?php foreach ($popularTags as $tag) : ?>
    <p><a href="<?= url("tags/view/{$tag->tagId}") ?>"><?= $tag->tag ?></a> (<?= $tag->amount ?> posts)</p>
    <?php endforeach; ?>
</div>
