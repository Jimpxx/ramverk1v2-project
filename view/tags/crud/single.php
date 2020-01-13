<?php

namespace Anax\View;

/**
 * View to display all books.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$tags = isset($tags) ? $tags : null;

// Create urls for navigation
$urlToCreate = url("tags/create");
// $urlToDelete = url("tags/delete");

// var_dump($tags);


?>

<?php if ($this->di->get("session")->get("user")["id"]) : ?>
    <p>
    <a class="btn" href="<?= url("tags/update/{$tagId}"); ?>">Edit tag</a>
    </p>
<?php endif; ?>

<h1>The tag <?= $singleTag->tag ?></h1>

<?php if (!$tags) : ?>
    <p>There are no posts connected to this tag.</p>
    <?php
    return;
endif;
?>







<p>The following posts are tagged with <strong><?= $tags[0]->tag ?></strong></p>

<?php foreach ($tags as $tag) : ?>
    <p><a href="<?= url("post/view/{$tag->post_id}") ?>"><?= $tag->title ?></a></p>
<?php endforeach; ?>
