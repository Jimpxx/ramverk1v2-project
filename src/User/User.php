<?php

namespace Jiad\User;

// use Anax\DatabaseActiveRecord\ActiveRecordModel;
use Jiad\Models\ActiveRecordExtension;

/**
 * A database driven model.
 */
class User extends ActiveRecordExtension
// class User extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";
    protected $tableIdColumn = "userId";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $userId;
    public $username;
    public $email;
    public $password;
    public $uCreated;
    public $uUpdated;
    public $uDeleted;
    public $uActive;

    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Verify the acronym and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string $acronym  acronym to check.
     * @param string $password the password to use.
     *
     * @return boolean true if acronym and password matches, else false.
     */
    public function verifyPassword($username, $password)
    {
        $this->find("username", $username);
        return password_verify($password, $this->password);
    }

    /**
     * Get user
     *
     * @param string $acronym  acronym to check.
     *
     * @return object An object of the user is returned.
     */
    public function authUser($sessionId, $id)
    {
        return $sessionId == $id;
    }
}
