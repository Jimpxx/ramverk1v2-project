<?php

namespace Jiad\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Jiad\User\HTMLForm\UserLoginForm;
use Jiad\User\HTMLForm\CreateUserForm;
use Jiad\User\HTMLForm\UpdateUserForm;
use Jiad\Post\Post;
use Jiad\Comment\Comment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
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
        // $user = new User();
        // $user->setDb($this->di->get("dbqb"));
        // $user->find("id", $id);

        // $status = "Not logged in";

        $sessionUser = $this->di->get("session")->get("user");

        if (!$sessionUser["id"] == $id) {
            $this->di->get("response")->redirect("user/login");
        }

        // var_dump($status);
        
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $id);
        $form->check();

        // $page->add("book/crud/update", [
        //     "form" => $form->getHTML(),
        // ]);

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update User",
        ]);
    }

    
    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function profileAction(int $id) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("userId", $id);

        $page = $this->di->get("page");

        // $status = "Not logged in";

        $sessionUser = $this->di->get("session")->get("user");

        $page->add("user/profileTitle");

        if ($sessionUser["id"] == $id) {
            // $status = "Logged in";
            $page->add("user/loggedInEditUser", [
                "id" => $id,
            ]);
        }


        // Gravatar Image
        $email = $user->email;
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "&s=" . $size;
        // $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
        

        $post = new Post();
        $post->setDb($this->di->get("dbqb"));

        $posts = $post->findAllWhereJoin(
            "Post.user_id = ?",
            $id,
            "User",
            "User.userId = Post.user_id"
        );

        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));

        // $comments = $comment->findAllWhereJoin(
        //     "Comment.user_id = ?",
        //     $id,
        //     "User",
        //     "User.userId = Comment.user_id"
        // );

        $commentedPosts = $comment->findAllWhereJoin(
            "Comment.user_id = ?",
            $id,
            "Post",
            "Post.postId = Comment.post_id"
        );

        // var_dump($commentedPosts);
        $commentedPosts = array_unique($commentedPosts, SORT_REGULAR);

        $page->add("user/profile", [
            "user" => $user,
            "img" => $grav_url,
            "posts" => $posts,
            "commentedPosts" => $commentedPosts
        ]);

        return $page->render([
            "title" => "Profile",
        ]);
    }


    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function logoutAction() : object
    {
        $this->di->get("session")->delete("user");
        // $this->di->get("session")->delete("test");
        $this->di->get("response")->redirect("index");
    }
}
