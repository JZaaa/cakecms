<?php
namespace App\Lib;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;

/**
 * CakePHP 3.7+ 数据库备份，当前支持 MySQL
 * @example $backup = CakeBackup::getInstance();
 * 获取所有数据表信息：$backup->getTableStatus();
 * 获取所有数据表名：$backup->getTableList();
 * 数据库备份：$backup->backupDB();
 * 数据表备份：$backup->backupTables(['table1', 'table2', ...])
 * 默认备份位置：config/backupsql
 * @package App\Lib
 */
class CakeBackup
{
    const MYSQL = 'Cake\Database\Driver\Mysql';

    private static $_instance = null;
    private $connection = false;
    private $path;

    private function __construct($datasources, $path) {
        $this->connection = ConnectionManager::get($datasources);
        if (empty($path)) {
            $this->path = CONFIG . 'backupsql';
        }
    }

    private function __clone() {}

    /**
     * 单例接口
     * @param string|null $path
     * @param string $datasources
     * @return CakeBackup|null
     */
    public static function getInstance($path = null, $datasources = 'default') {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($datasources, $path);
        }
        return self::$_instance;
    }

    /**
     * 获取数据库类型
     * @return mixed
     */
    public function getDriver() {
        return $this->connection->config()['driver'];
    }

    /**
     * 获取表状态
     * 支持：MySQL
     * @return array
     */
    public function getTableStatus() {
        return $this->connection->execute('SHOW TABLE STATUS')->fetchAll('assoc');
    }

    /**
     * 获取所有表
     * @return array
     */
    public function getTableList() {
        return $this->connection->getSchemaCollection()->listTables();
    }

    /**
     * 获取表具体信息
     * @param $tableName string 表名
     * @return array
     */
    public function getTableInfo($tableName) {
        $schema = $this->connection->getSchemaCollection()->describe($tableName);

        // 约束
        $constraintsList = $schema->constraints();
        $constraints = [];

        foreach ($constraintsList as $item) {
            $constraints[$item] = $schema->getConstraint($item);
        }
        unset($constraintsList);

        // 字段
        $columnsList = $schema->columns();
        $columns = [];

        foreach ($columnsList as $item) {
            $columns[$item] = $schema->getColumn($item);
        }
        unset($columnsList);

        $indexesList = $schema->indexes();
        $indexes = [];
        foreach ($indexesList as $item) {
            $indexes[$item] = $schema->getIndex($item);
        }
        unset($indexesList);

        return [
            'table' => $schema->name(),
            'columns' => $columns,
            'indexes' => $indexes,
            'constraints' => $constraints,
            'options' => $schema->getOptions(),
            'typeMap' => $schema->typeMap(),
            'temporary' => $schema->isTemporary()
        ];
    }

    /**
     * 优化表
     * @param array|string $tables [table1, table2 ...] 或 'table1,table2'
     * @return bool
     */
    public function optimize($tables) {

        if (is_array($tables)) {
            $tables = implode(',', $tables);
        }

        if (empty($tables)) {
            return false;
        }

        return $this->connection
            ->execute("OPTIMIZE TABLE $tables")
            ->execute();
    }


    /**
     * 修复表
     * 注：仅 MyISAM 可用
     * @param $tables array|string [table1, table2 ...] 或 'table1,table2'
     * @return bool
     */
    public function repair($tables) {

        if (is_array($tables)) {
            $tables = implode(',', $tables);
        }

        if (empty($tables)) {
            return false;
        }

        return $this->connection
            ->execute("REPAIR TABLE $tables")
            ->execute();
    }


    /**
     * 数据表备份
     * @param array $tables
     * @return bool
     */
    public function backupTables($tables = []) {
        if (empty($tables)) {
            return false;
        }
        $time = date('YmdHis');

        $success = true;

        foreach ($tables as $item) {
            $sql = $this->_header();

            $sql .= $this->_tableStructure($item);
            $sql .= $this->_tableData($item);

            $sql .= $this->_footer();

            if (!$this->_setSqlFile($sql, $item . '_' . $time . '.sql')) {
                $success = false;
            }

        }

        return $success;
    }

    /**
     * 数据库备份
     * @return bool
     */
    public function backupDB() {
        $tables = $this->getTableList();

        $time = date('YmdHis');

        $sql = $this->_header();

        foreach ($tables as $item) {
            $sql .= $this->_tableStructure($item);
            $sql .= $this->_tableData($item);
        }

        $sql .= $this->_footer();

        return $this->_setSqlFile($sql, $this->connection->config()['database'] . '_' . $time . '.sql');
    }


    /**
     * 生成sql文件
     * @param $sql string sql内容
     * @param $fileName string 文件名
     * @return bool
     */
    private function _setSqlFile($sql, $fileName) {

        $time = date('YmdHis');
        $folder = new Folder();
        $path = $this->path . DS . $time;

        if ($folder->create($path)) {
            $file = new File($path . DS . $fileName, true);
            return $file->write($sql);
        } else {
            return false;
        }

    }


    /**
     * sql文件头 信息
     * @return string
     */
    private function _header() {
        $config = $this->connection->config();
        $databaseName = $config['database'];
        $character = isset($config['encoding']) ? $config['encoding'] : 'utf8';

        $sql = '/*' . PHP_EOL .
                'MySQL Database SQL Dump' . PHP_EOL .
                '数据库：' . $databaseName . PHP_EOL .
                '生成日期：' . date('Y-m-d H:i:s') . PHP_EOL .
                '*********************************************************************' . PHP_EOL .
                '*/' . PHP_EOL . PHP_EOL;

        $sql .= '/*!40101 SET NAMES utf8 */;' . PHP_EOL . PHP_EOL;
        $sql .= '/*!40101 SET SQL_MODE=\'\'*/;' . PHP_EOL . PHP_EOL;
        $sql .= '/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;' . PHP_EOL;
        $sql .= '/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;' . PHP_EOL;
        $sql .= '/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=\'NO_AUTO_VALUE_ON_ZERO\' */;' . PHP_EOL;
        $sql .= '/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;' . PHP_EOL;
        // 不存在创建数据库
        $sql .= 'CREATE DATABASE /*!32312 IF NOT EXISTS*/`' . $databaseName . '` /*!40100 DEFAULT CHARACTER SET ' . $character . ' */;' . PHP_EOL . PHP_EOL;
        $sql .= 'USE `' . $databaseName . '`;' . PHP_EOL . PHP_EOL;

        return $sql;

    }

    /**
     * sql文件末尾语句
     * @return string
     */
    private function _footer() {
        $sql = '/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;' . PHP_EOL;
        $sql .= '/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;' . PHP_EOL;
        $sql .= '/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;' . PHP_EOL;
        $sql .= '/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;' . PHP_EOL;

        return $sql;
    }


    /**
     * 表结构sql
     * @param $table string
     * @return string
     */
    private function _tableStructure($table) {

        $structure = $this->connection->execute('SHOW CREATE TABLE `' . $table . '`')->fetch('assoc');

        $sql = '/*Table structure for table `'.$table.'` */' . PHP_EOL . PHP_EOL;
        $sql .= 'DROP TABLE IF EXISTS `' . $table . '`;' . PHP_EOL . PHP_EOL;
        $sql .= $structure['Create Table'] . ';' . PHP_EOL . PHP_EOL;
        return $sql;

    }

    /**
     * 表数据sql
     * @param $table string
     * @return string
     */
    private function _tableData($table) {
        $data = $this->connection->newQuery()
            ->select('*')
            ->from($table)
            ->execute()
            ->fetchAll('assoc');

        if (empty($data)) {
            return '';
        }

        $columns = $this->connection->getSchemaCollection()->describe($table)->columns();

        $sql = '/*Data for the table `' . $table . '` */' . PHP_EOL . PHP_EOL;

        $sql .= "insert into `" . $table . "` (" . implode(',', $columns) . ") values" . PHP_EOL;
        $bracket = '(';
        foreach ($data as $item) {
            $sql .= $bracket;
            $temp = '';
            foreach ($columns as $value) {
                $sql .= ($temp . "'" . htmlspecialchars_decode(stripcslashes(($item[$value])), ENT_QUOTES) . "'");
                $temp = ',';
            }
            $sql .= ')';
            $bracket = "," . PHP_EOL . "(";

        }
        $sql .= ';' . PHP_EOL . PHP_EOL;

        return $sql;
    }


}