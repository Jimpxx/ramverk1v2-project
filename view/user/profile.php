<?php

namespace Anax\View;

?>

<div class="profile-card">
    <div class="profile-title-row">
        <div class="profile-title-img">
            <img src="<?= $img ?>" alt="Gravatar image">
        </div>
        <div class="profile-title-text">
            <h2>Username: <?= $user->username ?></h2>
        </div>
    </div>
    <p>Email: <?= $user->email ?></p>
    <p>Joined: <?= $user->uCreated ?></p>
</div>


<h2>Posts created</h2>
<?php foreach ($posts as $post) : ?>
<p><a href="<?= url("post/view/{$post->postId}") ?>"><?= $post->title ?></a></p>
<?php endforeach; ?>


<h2>Commented posts</h2>
<?php foreach ($commentedPosts as $commentedPost) : ?>
<p><a href="<?= url("post/view/{$commentedPost->post_id}") ?>"><?= $commentedPost->title ?></a></p>
<?php endforeach; ?>
