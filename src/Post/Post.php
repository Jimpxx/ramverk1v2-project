<?php

namespace Jiad\Post;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Jiad\Models\ActiveRecordExtension;

/**
 * A database driven model using the Active Record design pattern.
 */
class Post extends ActiveRecordExtension
// class Post extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Post";
    protected $tableIdColumn = "postId";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $postId;
    public $user_id;
    public $title;
    public $text;
    public $pCreated;
    public $pUpdated;
    public $pDeleted;
    public $pActive;
}
