<?php

namespace Jiad\Post\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jiad\Post\Post;
use Jiad\TagsPost\TagsPost;
use Jiad\Comment\Comment;

/**
 * Form to delete an item.
 */
class DeleteForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $this->postId = $id;
        $post = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete an item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $post->postId,
                ],

                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $post->title,
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $post->text,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Delete post",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    protected function getAllItems() : array
    {
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));

        $posts = ["-1" => "Select an item..."];
        foreach ($post->findAll() as $obj) {
            $posts[$obj->postId] = "{$obj->title} ({$obj->postId})";
        }

        return $posts;
    }


        /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Post
     */
    public function getItemDetails($id) : object
    {
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        $post->find("postId", $id);
        return $post;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        $post->find("postId", $this->form->value("id"));
        $post->delete();

        $tagsPost = new TagsPost();
        $tagsPost->setDb($this->di->get("dbqb"));
        $tagsPost->deleteWhere("post_id = ?", $this->postId);

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->deleteWhere("post_id = ?", $this->postId);
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("post")->send();
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
