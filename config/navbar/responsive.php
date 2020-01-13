<?php
/**
 * Supply the basis for the navbar as an array.
 */

global $di;


$navbar = [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",
 
    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Posts",
            "url" => "post",
            "title" => "Posts.",
        ],
        [
            "text" => "Tags",
            "url" => "tags",
            "title" => "Tags.",
        ],
    ],
];

$id = $di->get("session")->get("user")["id"];

if ($di->get("session")->get("user")) {
    array_push($navbar["items"], array(
        "text" => "Profile",
        "url" => "user/profile/$id",
        "title" => "User profile."
    ));
    array_push($navbar["items"], array(
        "text" => "Logout",
        "url" => "user/logout",
        "title" => "User Logout."
    ));
} else {
    array_push($navbar["items"], array(
        "text" => "Login",
        "url" => "user/login",
        "title" => "User Login."
    ));

    array_push($navbar["items"], array(
        "text" => "Register",
        "url" => "user/create",
        "title" => "Register new user"
    ));
}

return $navbar;










// return [
//     // Use for styling the menu
//     "id" => "rm-menu",
//     "wrapper" => null,
//     "class" => "rm-default rm-mobile",
 
//     // Here comes the menu items
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
