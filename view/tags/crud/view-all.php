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



?><h1>View all tags</h1>

<?php if ($this->di->get("session")->get("user")["id"]) : ?>
    <p>
        <a class="btn" href="<?= $urlToCreate ?>">Create new tag</a>
    </p>
<?php endif; ?>

<?php if (!$tags) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>


<ul>
<?php foreach ($tags as $tag) : ?>
<li>
    <a href="<?= url("tags/view/{$tag->tagId}"); ?>"><?= $tag->tag ?></a>
</li>
<?php endforeach; ?>
</ul>
