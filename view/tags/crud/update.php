<?php

namespace Anax\View;

/**
 * View to create a new book.
 */
// Show all incoming variables/functions
//var_dump(get_defined_functions());
//echo showEnvironment(get_defined_vars());

// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;

// Create urls for navigation
$urlToView = url("tags");



?><h1>Update a tag</h1>

<?= $form ?>

<p>
    <a class="btn" href="<?= $urlToView ?>">View all</a>
</p>
