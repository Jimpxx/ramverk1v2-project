<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Create urls for navigation
$urlToView = url("comment");



?><h1>Delete an item</h1>

<?= $form ?>

<p>
    <a class="btn" href="<?= $urlToView ?>">View all</a>
</p>
