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
     * @return QueryBuilder
     */
    public function update($table)
    {
        if (empty($table)){
            return null;
        }
        return $this->connection->createQueryBuilder()->update($this->getTable($table));
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

    public function select($field = '*')
    {
        return $this->connection->createQueryBuilder()->select($field);//todo add table
    }

    private function getTable($table = '')
    {
        return $this->prefix.$table;
    }
}