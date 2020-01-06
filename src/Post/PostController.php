<?php

namespace Jiad\Post;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jiad\Post\HTMLForm\CreateForm;
use Jiad\Post\HTMLForm\EditForm;
use Jiad\Post\HTMLForm\DeleteForm;
use Jiad\Post\HTMLForm\UpdateForm;
use Jiad\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class PostController implements ContainerInjectableInterface
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
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $page->add("post/crud/view-all", [
            "posts" => $post->findAll(),
            "users" => $user->findAll(),
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

        $sessionUser = $this->di->get("session")->get("user");

        if (!$sessionUser["id"]) {
            $this->di->get("response")->redirect("user/login");
        }

        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("post/crud/create", [
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
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di);
        $form->check();

        $page->add("post/crud/delete", [
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
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("post/crud/update", [
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
        $post = new Post();
        $post->setDb($this->di->get("dbqb"));
        
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $selectedPost = $post->find("id", $id);
        $author = $user->find("id", $selectedPost->user_id);

        $page->add("post/crud/single", [
            "post" => $selectedPost,
            "author" => $author,
        ]);

        $page->add("post/crud/comments", [
            // "post" => $selectedPost,
            // "author" => $author,
        ]);

        return $page->render([
            "title" => "Single post",
        ]);
    }
}
