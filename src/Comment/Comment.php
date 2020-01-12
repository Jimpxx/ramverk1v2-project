<?php

namespace Jiad\Comment;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Jiad\Models\ActiveRecordExtension;

/**
 * A database driven model using the Active Record design pattern.
 */
class Comment extends ActiveRecordExtension
// class Comment extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Comment";
    protected $tableIdColumn = "commentId";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $commentId;
    public $user_id;
    public $post_id;
    public $reply_id;
    public $text;
    public $cCreated;
    public $cUpdated;
    public $cDeleted;
    public $cActive;


    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param array $comments array of objects
     *
     * @return array
     */
    public function sort($comments)
    {
        $sorted = [];
        foreach ($comments as $comment) {
            if ($comment->reply_id == "") {
                $comment->padding = 0;
                array_push($sorted, $comment);
            } else {
                for ($i = 0; $i < count($sorted); $i++) {
                    if ($sorted[$i]->commentId == $comment->reply_id) {
                        $comment->padding = $sorted[$i]->padding + 3;
                        array_splice($sorted, $i + 1, 0, [$comment]);
                    }
                }
            }
        }
        return $sorted;
    }
}
