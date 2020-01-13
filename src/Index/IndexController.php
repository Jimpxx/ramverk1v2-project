<?php

namespace Jiad\Index;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
// use VendorName\User\HTMLForm\UserLoginForm;
// use VendorName\User\HTMLForm\CreateUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

use Jiad\User\User;
use Jiad\Post\Post;
use Jiad\Comment\Comment;
use Jiad\Tags\Tags;
use Jiad\TagsPost\TagsPost;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class IndexController implements ContainerInjectableInterface
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

        // $user = $this->di->get("session")->get("user");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        // findAllJoinGroupOrderLimit($select = null, $table, $condition, $group, $order, $limit)
        $topUsers = $user->findAllJoinGroupOrderLimit(
            "Post",
            "User.userId = Post.user_id",
            "User.userId",
            "amount DESC",
            "5",
            "*, count(User.userId) as amount"
        );

        $post = new Post();
        $post->setDb($this->di->get("dbqb"));

        $latestPosts = $post->findAllOrderByLimit("Post.pCreated DESC", "3");

        $tag = new Tags();
        $tag->setDb($this->di->get("dbqb"));

        // findAllJoinJoinGroupOrderLimit($select = null, $table, $condition, $table2, $condition2, $group, $order, $limit)
        $popularTags = $tag->findAllJoinJoinGroupOrderLimit(
            "TagsPost",
            "TagsPost.tag_id = Tags.tagId",
            "Post",
            "TagsPost.post_id = Post.postId",
            "Tags.tagId",
            "amount DESC",
            "5",
            "*, count(Tags.tagId) as amount"
        );

        $page->add("index/home", [
            "topUsers" => $topUsers,
            "latestPosts" => $latestPosts,
            "popularTags" => $popularTags,
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
    public function omActionGet() : object
    {
        $page = $this->di->get("page");

        $user = $this->di->get("session")->get("user");

        $page->add("index/om", [
            "user" => $user,
        ]);

        return $page->render([
            "title" => "A about page",
        ]);
    }
}
