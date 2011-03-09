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
class Cornac_Auditeur_Analyzer_Classes_Finals extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Final methods';
	protected	$description = 'List of final keyword usage. ';

	function __construct($mid) {
        parent::__construct($mid);
	}

	function dependsOn() {
	    return array();
	}

	public function analyse() {
        $this->clean_report();

// @note spot final when in first place in a class
	    $query = <<<SQL
SELECT NULL, T1.file, T2.class, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left = T1.left + 1 AND
       T2.code = 'final'
WHERE T1.type = '_class'
SQL;
        $this->exec_query_insert('report', $query);

// @note spot final when in first place in a method
	    $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T2.class,'::',T2.scope), T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left = T1.left + 1 AND
       T2.code = 'final'
WHERE T1.type = '_function'
SQL;
        $this->exec_query_insert('report', $query);

// @note spot final when in second place
	    $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T2.class,'::',T2.scope), T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left = T1.left + 3 AND
       T2.code = 'final'
WHERE T1.type = '_function'
SQL;
        $this->exec_query_insert('report', $query);

// @note spot final when in third place
	    $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T2.class,'::',T2.scope), T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left = T1.left + 5 AND
       T2.code = 'final'
WHERE T1.type = '_function'
SQL;
        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>