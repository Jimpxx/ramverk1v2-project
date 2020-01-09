<?php

namespace Jiad\Comment\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jiad\Comment\Comment;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $post_id)
    {
        parent::__construct($di);
        // $this->post_id = $post_id;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "New comment",
                "escape-values" => false
            ],
            [
                "post_id" => [
                    "type" => "hidden",
                    "validation" => ["not_empty"],
                    "value" => $post_id
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->user_id  = $this->di->get("session")->get("user")["id"];
        // $comment->post_id  = $post_id;
        $comment->post_id  = $this->form->value("post_id");
        if ($this->di->get("request")->getGet("replyId")) {
            $comment->reply_id = $this->di->get("request")->getGet("replyId");
        }
        $comment->text  = $this->form->value("text");
        $comment->cCreated = date("Y-m-d H:i");
        $comment->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("post/view/{$this->form->value("post_id")}")->send();
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
