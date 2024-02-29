<?php
namespace Latecka;
set_time_limit(600);

use Latecka\Config\config;

use Latecka\Utils\request;
use Latecka\Utils\db;
require_once 'vendor/autoload.php';
require_once 'App/Utils/helper.php';

new config();

class formWizard {

    public $tableName;

    function __construct() {
        
    }
    
    private function dbTableColumns() {
        if (!$this->existTable()) : return []; endif;
        $q = 'explain `'.$this->tableName.'`';
        $rows = db::fa($q);
        return $rows;
    }
    
    private function existTable() {
        $q = 'SHOW TABLE STATUS FROM `'.config::$dbName.'` WHERE Name = ?';
        $ret = db::f($q, $this->tableName);
        return (count((array)$ret)>0);
    }

    public function getListDBColumns(string $tableName = '') {
        $this->tableName = $tableName;
        $cols = $this->dbTableColumns();
        $str = '';
        foreach ((array)$cols AS $col) :
            $str .= '<li class="btn btn-secondary btn-sm my-1 text-start" data-columname="'.$this->tableName.'.'.$col['Field'].'">'.$col['Field'].'</li>'.PHP_EOL;
        endforeach;
        return $str;
    }
}
