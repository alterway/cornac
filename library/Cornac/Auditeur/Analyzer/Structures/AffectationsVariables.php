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

class Cornac_Auditeur_Analyzer_Structures_AffectationsVariables extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Variables affected';
	protected	$description = 'List of affected variables : somewhere, they do receive a value.';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

// @note simple variables
        $query = <<<SQL
SELECT NULL, T1.file, T2.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T1.file = T2.file AND T2.left = T1.left + 1
WHERE T1.type = 'affectation'  AND 
      T2.type = 'variable'
SQL;
        $this->exec_query_insert('report', $query);    

// @note array
        $query = <<<SQL
SELECT NULL, T1.file, T3.code, T1.id,'{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T1.file = T2.file AND
       T2.left = T1.left + 1
JOIN <tokens> T3
    ON T1.file = T3.file AND T3.left = T1.left + 2
WHERE T1.type = 'affectation'  AND
      T2.type = '_array'
SQL;
        $this->exec_query_insert('report', $query);    

// @note property
        $query = <<<SQL
SELECT NULL, T1.file, TC.code, T1.id,'{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T1.file = T2.file AND 
       T2.left = T1.left + 1
JOIN tu_cache TC
    ON TC.id = T2.id
WHERE T1.type = 'affectation' AND
      T2.type = 'property'
SQL;
        $this->exec_query_insert('report', $query);    

// @note  static property
        $query = <<<SQL
SELECT NULL, T1.file, T3.code, T1.id,'{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T1.file = T2.file AND 
       T2.left = T1.left + 1
JOIN <tokens_tags> TT
    ON TT.token_id = T2.id AND 
       TT.type = 'property'
JOIN <tokens> T3
    ON T1.file = T3.file AND 
       T3.id = TT.token_sub_id
WHERE T1.type = 'affectation'  AND 
      T2.type = 'property_static'
SQL;
        $this->exec_query_insert('report', $query);    

// @note list() case
        $query = <<<SQL
SELECT NULL, T1.file, T4.code, T1.id,'{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T1.file = T2.file     AND 
       T2.left = T1.left + 1 AND
       T2.type = 'functioncall'
JOIN <tokens> T3
    ON T1.file = T3.file AND
       T3.left = T1.left + 2 AND
       T3.type = '_functionname_' AND
       T3.code = 'list'
JOIN <tokens> T4
    ON T1.file = T4.file AND
       T4.left BETWEEN T2.left AND T2.right AND
       T4.type = 'variable'
WHERE T1.type = 'affectation' 
SQL;
        $this->exec_query_insert('report', $query);    

// @note foreach() case
        $query = <<<SQL
SELECT NULL, T1.file, T2.code, T1.id,'{$this->name}', 0
FROM <tokens> T1
JOIN <tokens_tags> TT1
    ON TT1.token_id = T1.id AND 
       TT1.type IN ('value','key')
JOIN <tokens> T2
    ON T1.file = T2.file AND 
       TT1.token_sub_id = T2.id
WHERE T1.type = '_foreach'
SQL;
        $this->exec_query_insert('report', $query);    
        
        return true;
    }
}

?>