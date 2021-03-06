<?php
/**
 * 对Having条件进行标准化
 * User: 蓝冰大侠
 * Date: 2018/4/17
 * Time: 14:24
 */
declare(strict_types=1);

namespace icePHP\Frame\Mysql;

class MysqlHaving extends MysqlCondition
{
    /**
     * 构造方法公开
     * SMysqlWhere constructor.
     * @param mixed $condition
     * @param string $operator
     */
    public function __construct($condition, $operator = 'AND')
    {
        parent::__construct($condition, $operator);
    }

    /**
     * 获取Having条件结果
     * @return array [sql,prepare,param]
     */
    public function result(): array
    {
        $sql = trim($this->sql);
        if (!$sql) {
            return ['', '', []];
        }

        //如果不是以Having开头,则,加上
        if (stripos($sql, 'HAVING') !== 0) {
            $sql = ' HAVING ' . $sql;
        }

        // 处理Prepare
        $prepare = trim($this->prepare);
        if (stripos($prepare, 'HAVING') !== 0) {
            $prepare = ' HAVING ' . $prepare;
        }

        // 返回三项
        return [$sql, $prepare, $this->param];
    }
}