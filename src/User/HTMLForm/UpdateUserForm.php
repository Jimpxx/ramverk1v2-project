<?php

namespace Jiad\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jiad\User\User;

/**
 * Form to update an item.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update profile",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->userId,
                ],

                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->username,
                ],

                "email" => [
                    "type" => "email",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],

                "current-password" => [
                    "type" => "password",
                ],

                "new-password" => [
                    "type" => "password",
                ],

                "new-password-again" => [
                    "type" => "password",
                    "validation" => [
                        "match" => "new-password"
                    ]
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return User
     */
    public function getItemDetails($id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $id);
        return $user;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $username       = $this->form->value("username");
        $email       = $this->form->value("email");
        $oldPassword      = $this->form->value("current-password");
        $newPassword = $this->form->value("new-password");
        $newPasswordAgain = $this->form->value("new-password-again");

        // Check password matches
        if ($newPassword !== $newPasswordAgain ) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }
        
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $this->form->value("id"));

        if (!$user->verifyPassword($username, $oldPassword)) {
            $this->form->rememberValues();
            $this->form->addOutput("Your current password did not match.");
            return false;
        }
        // $user->username  = $this->form->value("username");
        $user->email = $email;
        if ($newPassword !== "") {
            $user->setPassword($newPassword);
        }
        $user->uUpdated = date("Y-m-d");
        $user->save();

        $currentUser = [
            "id" => $user->userId,
            "username" => $user->username,
            "email" => $user->email,
            "password" => $user->password,
            "newpass" => $newPassword
        ];
        $this->di->get("session")->set("user", $currentUser);

        // $this->form->addOutput("User updated.");
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/profile/{$this->form->value("id")}")->send();
        //$this->di->get("response")->redirect("book/update/{$book->id}");
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}
