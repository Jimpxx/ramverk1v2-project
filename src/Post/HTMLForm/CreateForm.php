<?php

namespace Jiad\Post\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jiad\Post\Post;
use Anax\TextFilter\TextFilter;
use Jiad\Tags\Tags;
use Jiad\TagsPost\TagsPost;

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
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Details of the post",
                "escape-values" => false
            ],
            [
                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                        
                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],
                        
                "tags" => [
                    "type" => "checkbox-multiple",
                    "label" => "Tags",
                    "values" => $this->getAllItems(),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create Post",
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
        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));

        $tags = [];
        // $tags = ["-1" => "Select an item..."];
        foreach ($tag->findAll() as $obj) {
            $tags[$obj->tagId] = "{$obj->tag}";
        }

        return $tags;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        // $textFilter = new TextFilter();
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        $post->user_id  = $this->di->get("session")->get("user")["id"];
        $post->title  = $this->form->value("title");
        $post->text = $this->form->value("text");
        $post->pCreated = date("Y-m-d H:i");
        $post->save();

        // var_dump($this->form->value("tags"));
        if ($this->form->value("tags")) {
            $tag = new Tags();
            $tag->setDb($this->di->get("dbqb"));
            $items = $this->form->value("tags");
            // $tag->save();

            
            foreach ($items as $item) {
                $tagsPost = new TagsPost();
                $tagsPost->setDb($this->di->get("dbqb"));
                // var_dump($item);
                $foundTag = $tag->find("tag", $item);
                if ($foundTag) {
                    // var_dump($foundTag);
                    $tagsPost->tag_id = $foundTag->tagId;
                    $tagsPost->post_id = $post->postId;
                    $tagsPost->save();
                }
            }
        }

        return true;
        // return false;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("post")->send();
        // $this->di->get("response")->redirectSelf()->send();
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
