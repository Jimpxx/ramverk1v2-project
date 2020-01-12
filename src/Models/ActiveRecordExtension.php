<?php

namespace Jiad\Models;

use Anax\DatabaseActiveRecord\ActiveRecordModel;
/**
 * An implementation of the Active Record pattern to be used as
 * base class for database driven models.
 */
class ActiveRecordExtension extends ActiveRecordModel
{
        /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAllJoin($table, $condition)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->join($table, $condition)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


    /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAllOrderByLimit($order, $limit)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->orderBy($order)
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


        /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAllJoinGroupOrderLimit($select = null, $table, $condition, $group, $order, $limit)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select($select)
                        ->from($this->tableName)
                        ->join($table, $condition)
                        ->groupBy($group)
                        ->orderBy($order)
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


        /**
     * Find and return all.
     *
     * @return array of object of this class
     */
    public function findAllJoinJoinGroupOrderLimit($select = null, $table, $condition, $table2, $condition2, $group, $order, $limit)
    {
        $this->checkDb();
        return $this->db->connect()
                        ->select($select)
                        ->from($this->tableName)
                        ->join($table, $condition)
                        ->join($table2, $condition2)
                        ->groupBy($group)
                        ->orderBy($order)
                        ->limit($limit)
                        ->execute()
                        ->fetchAllClass(get_class($this));
    }


        /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function findAllWhereJoin($where, $value, $table, $condition)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where($where)
                        ->join($table, $condition)
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }


        /**
     * Find and return all matching the search criteria.
     *
     * The search criteria `$where` of can be set up like this:
     *  `id = ?`
     *  `id IN [?, ?]`
     *
     * The `$value` can be a single value or an array of values.
     *
     * @param string $where to use in where statement.
     * @param mixed  $value to use in where statement.
     *
     * @return array of object of this class
     */
    public function findAllWhereJoinJoin($where, $value, $table, $condition, $table2, $condition2)
    {
        $this->checkDb();
        $params = is_array($value) ? $value : [$value];
        return $this->db->connect()
                        ->select()
                        ->from($this->tableName)
                        ->where($where)
                        ->join($table, $condition)
                        ->join($table2, $condition2)
                        ->execute($params)
                        ->fetchAllClass(get_class($this));
    }
}
