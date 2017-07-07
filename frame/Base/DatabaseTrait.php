<?php
/**
 * Created by PhpStorm.
 * User: wjw33
 * Date: 2017-07-04
 * Time: 21:18
 */
namespace LittlePeach\Base;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use LittlePeach\Service\Kernel;

trait DatabaseTrait{

    private $prefix = '';
    /**
     * @var Connection
     */
    private $connection = null;


    /**
     * @return Model
     */
    public function loadDB()
    {
        $this->connection = Kernel::getInstance()->getContainer()->get('database');
        $configs = $this->connection->getParams();
        if (isset($configs['prefix'])) {
            $this->prefix = $configs['prefix'];
        }
        return $this;
    }

    /**
     * @param $table
     * @param null $alias
     * @return QueryBuilder
     */
    public function update($table, $alias = null)
    {
        if (empty($table)){
            return null;
        }
        return $this->connection->createQueryBuilder()->update($this->getTable($table), $alias);
    }

    /**
     * @param $table
     * @param null $alias
     * @return QueryBuilder
     */
    public function delete($table, $alias = null)
    {
        if (empty($table)){
            return null;
        }
        return $this->connection->createQueryBuilder()->delete($this->getTable($table), $alias);
    }

    /**
     * @param $table
     * @return bool|QueryBuilder
     */
    public function insert($table)
    {
        if (empty($table)){
            return false;
        }
        return $this->connection->createQueryBuilder()->insert($this->getTable($table));
    }

    public function selectFrom($field = '*', $table = '', $alias = null)
    {
        return $this->connection->createQueryBuilder()
            ->select($field)
            ->from($this->getTable($table), $alias);//todo add table
    }

    private function getTable($table = '')
    {
        return $this->prefix.$table;
    }

    /**
     * 开始事务
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commit()
    {
        $this->connection->commit();
    }

    public function rollback()
    {
        $this->connection->rollBack();
    }
}