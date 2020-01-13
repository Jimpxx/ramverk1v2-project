<?php

namespace Anax\View;

// var_dump($_SESSION);
// var_dump($topUsers);
// var_dump($popularTags);

?>

<h1>Everything on Stocks</h1>
<p>On this site we try to keep the conversation to Stocks and finance.</p>

<h2>Below are some stats for the site</h2>

<h3>Latest posts</h3>

<?php foreach ($latestPosts as $post) : ?>
<p><a href="<?= url("post/view/{$post->postId}") ?>"><?= $post->title ?></a></p>
<?php endforeach; ?>

<h3>Most active users</h3>

<?php foreach ($topUsers as $user) : ?>
    <?php
        // Gravatar Image
        $email = $user->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;
    ?>

    <img src="<?= $grav_url ?>" alt="">
    <p><?= $user->username ?></p>
    <p><?= $user->amount ?> posts</p>
<?php endforeach; ?>
<h3>Popular tags</h3>

<?php foreach ($popularTags as $tag) : ?>
<p><a href="<?= url("tags/view/{$tag->tagId}") ?>"><?= $tag->tag ?></a> (<?= $tag->amount ?> posts)</p>
<?php endforeach; ?>
