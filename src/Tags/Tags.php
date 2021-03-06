<?php

namespace Jiad\Tags;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Jiad\Models\ActiveRecordExtension;

/**
 * A database driven model using the Active Record design pattern.
 */
class Tags extends ActiveRecordExtension
// class Tags extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Tags";
    protected $tableIdColumn = "tagId";



    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $tagId;
    public $tag;
}
