<?php

namespace Jiad\Comment;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jiad\Comment\HTMLForm\CreateForm;
use Jiad\Comment\HTMLForm\EditForm;
use Jiad\Comment\HTMLForm\DeleteForm;
use Jiad\Comment\HTMLForm\UpdateForm;
use Anax\TextFilter\TextFilter;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class CommentController implements ContainerInjectableInterface
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
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        $filter = new TextFilter();

        $page->add("comment/crud/view-all", [
            "comments" => $comment->findAllWhere("post_id = ?", 5),
            "filter" => $filter,
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
    public function createAction($post_id) : object
    {
        $sessionUser = $this->di->get("session")->get("user");

        if (!$sessionUser["id"]) {
            $this->di->get("response")->redirect("user/login");
        }
        
        $page = $this->di->get("page");
        $form = new CreateForm($this->di, $post_id);
        $form->check();

        $page->add("comment/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction() : object
    {
        $sessionUser = $this->di->get("session")->get("user");

        if (!$sessionUser["id"]) {
            $this->di->get("response")->redirect("user/login");
        }
        
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di);
        $form->check();

        $page->add("comment/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $sessionUser = $this->di->get("session")->get("user");

        if (!$sessionUser["id"]) {
            $this->di->get("response")->redirect("user/login");
        }
        
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        $page->add("comment/crud/update", [
            "form" => $form->getHTML(),
            "comment" => $comment->find("commentId", $id),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }
}
