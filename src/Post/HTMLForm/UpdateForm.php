<?php

namespace Jiad\Post\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Jiad\Post\Post;
use Jiad\Tags\Tags;
use Jiad\TagsPost\TagsPost;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
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
        $this->postId = $id;
        $post = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
                "escape-values" => false
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
                    "value" => $post->title,
                ],

                "text" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "value" => $post->text,
                ],

                "tags" => [
                    "type" => "checkbox-multiple",
                    "label" => "Tags",
                    "values" => $this->getAllItems(),
                    "checked" => $this->getAllChecked(),
                    // "checked" => ["Stocks", "Money"]
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
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    protected function getAllChecked() : array
    {
        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));

        $post = new Post();
        $post->setDb($this->di->get("dbqb"));

        $tagsPost = new TagsPost();
        $tagsPost->setDb($this->di->get("dbqb"));

        $checked = [];
        // $checked = ["-1" => "Select an item..."];
        foreach ($tag->findAllWhereJoinJoin("TagsPost.post_id = ?", $this->postId, "TagsPost", "TagsPost.tag_id = Tags.tagId", "Post", "Post.postId = TagsPost.post_id") as $obj) {
            $checked[$obj->tagId] = "{$obj->tag}";
            // $checked["checked"] = "{$obj->tagId}";

        }

        return $checked;
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

        // $post = new Post();
        // $post->setDb($this->di->get("dbqb"));

        // $tagsPost = new TagsPost();
        // $tagsPost->setDb($this->di->get("dbqb"));

        $tags = [];
        // $tags = ["-1" => "Select an item..."];
        foreach ($tag->findAll() as $obj) {
            $tags[$obj->tagId] = "{$obj->tag}";
            // $tags["checked"] = "{$obj->tagId}";

        }

        return $tags;
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
        $post->title  = $this->form->value("title");
        $post->text = $this->form->value("text");
        $post->pUpdated = date("Y-m-d H:i");
        $post->save();

        if ($this->form->value("tags")) {
            $tag = new Tags();
            $tag->setDb($this->di->get("dbqb"));
            $items = $this->form->value("tags");
            // $tag->save();

            $tagsPost = new TagsPost();
            $tagsPost->setDb($this->di->get("dbqb"));
            $tagsPost->deleteWhere("post_id = ?", $this->postId);
            
            foreach($items as $item){
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
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        // $this->di->get("response")->redirect("post")->send();
        $this->di->get("response")->redirect("post/view/{$this->postId}");
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
