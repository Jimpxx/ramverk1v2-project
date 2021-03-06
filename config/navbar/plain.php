<?php
/**
 * Supply the basis for the navbar as an array.
 */

global $di;


$navbar = [
    // Use for styling the menu
    "class" => "my-navbar",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Home",
            "url" => "",
            "title" => "Home",
        ],
        [
            "text" => "About",
            "url" => "om",
            "title" => "About",
        ],
        [
            "text" => "Posts",
            "url" => "post",
            "title" => "Posts",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Tags",
        ],
    ],
];

$id = $di->get("session")->get("user")["id"];

if ($di->get("session")->get("user")) {
    array_push($navbar["items"], array(
        "text" => "Profile",
        "url" => "user/profile/$id",
        "title" => "Profile."
    ));
    array_push($navbar["items"], array(
        "text" => "Logout",
        "url" => "user/logout",
        "title" => "Logout"
    ));
} else {
    array_push($navbar["items"], array(
        "text" => "Login",
        "url" => "user/login",
        "title" => "Login"
    ));

    array_push($navbar["items"], array(
        "text" => "Register",
        "url" => "user/create",
        "title" => "Register"
    ));
}

return $navbar;





// return [
//     // Use for styling the menu
//     "class" => "my-navbar",
 
//     // Here comes the menu items/structure
//     "items" => [
//         [
//             "text" => "Hem",
//             "url" => "",
//             "title" => "Första sidan, börja här.",
//         ],
//         [
//             "text" => "Om",
//             "url" => "om",
//             "title" => "Om denna webbplats.",
//         ],
//     ],
// ];
