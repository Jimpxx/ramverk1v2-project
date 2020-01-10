<?php

namespace Jiad\Tags;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jiad\Tags\HTMLForm\CreateForm;
use Jiad\Tags\HTMLForm\EditForm;
use Jiad\Tags\HTMLForm\DeleteForm;
use Jiad\Tags\HTMLForm\UpdateForm;
use Jiad\TagsPost\TagsPost;
use Jiad\Post\Post;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagsController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $tags = new Tags();
        $tags->setDb($this->di->get("dbqb"));

        $page->add("tags/crud/view-all", [
            "tags" => $tags->findAll(),
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("tags/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    // /**
    //  * Handler with form to delete an item.
    //  *
    //  * @return object as a response object
    //  */
    // public function deleteAction() : object
    // {
    //     $page = $this->di->get("page");
    //     $form = new DeleteForm($this->di);
    //     $form->check();

    //     $page->add("tags/crud/delete", [
    //         "form" => $form->getHTML(),
    //     ]);

    //     return $page->render([
    //         "title" => "Delete an item",
    //     ]);
    // }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("tags/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }

        /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function viewAction(int $id) : object
    {
        $page = $this->di->get("page");
        
        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));
        
        // $post = new Post();
        // $post->setDb($this->di->get("dbqb"));


        $page->add("tags/crud/single", [
            // "tag" => $tag->findAllWhereJoin(
            //     "tagId = ?",
            //     $id,
            //     "TagsPost",
            //     "TagsPost.tag_id = Tags.tagId"
            // ),
            "tags" => $tag->findAllWhereJoinJoin(
                "tagId = ?",
                $id,
                "TagsPost",
                "TagsPost.tag_id = Tags.tagId",
                "Post",
                "TagsPost.post_id = Post.postId"
            ),
        ]);

        // findAllWhereJoinJoin($where, $value, $table, $condition, $table2, $condition2)


        return $page->render([
            "title" => "Single post",
        ]);
    }
}
