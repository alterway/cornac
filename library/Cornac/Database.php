<?php
/*
   +----------------------------------------------------------------------+
   | Cornac, PHP code inventory                                           |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010 - 2011                                            |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | http://www.php.net/license/3_01.txt                                  |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Damien Seguy <damien.seguy@gmail.com>                        |
   +----------------------------------------------------------------------+
 */

class Cornac_Database  {
    // @todo : must expose more functions

    private $pdo = null;
    
    function __construct($INI = null) {
        if (is_null($INI)) {
            global $INI;
        } 
        
        if (is_array($INI)) {
            if (isset($INI['mysql']) && $INI['mysql']['active'] == true) {
                $this->pdo = new pdo($INI['mysql']['dsn'],$INI['mysql']['username'], $INI['mysql']['password']);
            } elseif (isset($INI['sqlite'])  && $INI['sqlite']['active'] == true) {
                $this->pdo = new pdo($INI['sqlite']['dsn']);
            } else {
                print "No database configuration provided (no mysql, no sqlite)\n";
                die();
            }

            if (empty($INI['cornac']['prefix'])) {
                $this->prefix = 'tokens';
            } else {
                $this->prefix = $INI['cornac']['prefix'];
            }
        } else {
            global $OPTIONS;
            
            if ($OPTIONS->mysql['active'] == true) {
                $this->pdo = new pdo($OPTIONS->mysql['dsn'],$OPTIONS->mysql['username'], $OPTIONS->mysql['password']);
            } elseif ($OPTIONS->sqlite['active'] == true) {
                $this->pdo = new pdo($OPTIONS->sqlite['dsn']);
            } else {
                print "No database configuration provided (no mysql, no sqlite) (object)\n";
                die();
            }

            if (empty($OPTIONS->cornac['prefix'])) {
                $this->prefix = 'tokens';
            } else {
                $this->prefix = $OPTIONS->cornac['prefix'];
            }
        }
        
        $this->tables = array('<report>' => $this->prefix.'_report',
                              '<tokens>' => $this->prefix.'',
                              '<tokens_tmp>' => $this->prefix.'_TMP',
                              '<cache>' => $this->prefix.'_cache',
                              '<tokens_cache>' => $this->prefix.'_cache',
                              '<tokens_cache_tmp>' => $this->prefix.'_cache_TMP',
                              '<tags>' => $this->prefix.'_tags',
                              '<tokens_tags>' => $this->prefix.'_tags',
                              '<tokens_tags_tmp>' => $this->prefix.'_tags_TMP',
                              '<report_module>' => $this->prefix.'_report_module',
                              '<report_dot>' => $this->prefix.'_report_dot',
                              '<report_attributes>' => $this->prefix.'_report_attributes',
                              '<tasks>' => $this->prefix.'_tasks',
                            );
    }
    
    function setup_query($query) {
        $query = str_replace(array_keys($this->tables), 
                             array_values($this->tables), 
                             $query);

        return $query;
    }
    
    function query($query) {
        $this->last_query = $this->setup_query($query);
        
        $res = $this->pdo->query($this->last_query);
        
        // @todo make this a configuration (at least)
        $this->errorInfo(true);
        return $res;
    }
    
    function quote($string) {
        return $this->pdo->quote($string);
    }
    
    function errorInfo($print = false) {
        if ($print) {
            $errorInfo = $this->pdo->errorInfo();
            if (!$errorInfo[1] * 1) { return true; }
            print "<p style=\"border: 1px\"><div style=\"font-family: courier\">".$this->last_query."</div><br />";
            
            print $errorInfo[2];
            print "</p>";
            
            return true;
        } else {
            return $this->pdo->errorInfo();
        }
    }

    function errorCode() {
        return $this->pdo->errorCode();
    }

    function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
    
    function insert_id() {
        return $this->pdo->lastInsertId();
    }

    function query_one_array($query, $index = null) {
        $res = $this->query($query);
        if (!$res) { return false; }
        
        $array = $res->fetchAll(PDO::FETCH_ASSOC);
        $r = array();
        
        if (is_null($index)) {
            list($k, $v) = each($array);
            
            if (!is_array($v)) { 
                print __METHOD__."\n";
                var_dump($array); 
                die; 
            }
            list($index, $V) = each($v);
            
            $r[$k] = $V;
        }
        
        foreach($array as $k => $v) {
            if (isset($v[$index])) {
                $r[$k] = $v[$index];
            }
        }
    
        return $r;
    }
}

?>