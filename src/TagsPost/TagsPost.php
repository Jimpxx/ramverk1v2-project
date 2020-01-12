<?php

namespace Jiad\TagsPost;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Jiad\Models\ActiveRecordExtension;

/**
 * A database driven model using the Active Record design pattern.
 */
class TagsPost extends ActiveRecordExtension
// class TagsPost extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "TagsPost";
    // protected $tableIdColumn = "tag_id";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $tag_id;
    public $post_id;
}
