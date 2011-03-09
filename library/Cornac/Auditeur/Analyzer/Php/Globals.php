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

class Cornac_Auditeur_Analyzer_Php_Globals extends Cornac_Auditeur_Analyzer
 {
    protected    $title = 'Globals';
    protected    $description = 'Usage of global variables within the application';

    function __construct($mid) {
        parent::__construct($mid);
    }
    
    public function analyse() {
        $this->clean_report();
        
        // @note variable global thanks to the global reserved word
        $query = <<<SQL
SELECT NULL, T2.file, T2.code AS code, T2.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2 
    ON T1.left + 1 = T2.left AND
       T1.file = T2.file
WHERE T1.type='_global' 
SQL;
        $this->exec_query_insert('report', $query);
        
        // @note variables globales because in $GLOBALS
       $query = <<<SQL
SELECT NULL, T1.file, T3.code AS code, T2.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2 
    ON T1.left + 1 = T2.left AND
       T1.file = T2.file
LEFT JOIN <tokens_cache> T3
    ON T1.id = T3.id
WHERE T1.type = '_array' AND
      T2.code = '\$GLOBALS';
SQL;
        $this->exec_query_insert('report', $query);
        
        return true;
    }    
    
}

?>