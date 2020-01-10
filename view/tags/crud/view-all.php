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



?><h1>View all tags</h1>

<p>
    <a href="<?= $urlToCreate ?>">Create new tag</a>
    <!-- <a href="<?= $urlToDelete ?>">Delete</a> -->
</p>

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


<!-- <table>
    <tr>
        <th>Id</th>
        <th>Tag</th>
    </tr>
    <?php foreach ($tags as $tag) : ?>
    <tr>
        <td>
            <a href="<?= url("tags/update/{$tag->tagId}"); ?>"><?= $tag->tagId ?></a>
        </td>
        <td><?= $tag->tag ?></td>
    </tr>
    <?php endforeach; ?>
</table> -->
