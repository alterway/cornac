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

class Cornac_Auditeur_Analyzer_Php_ArrayDefinitions extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Arrays as lists';
	protected	$description = 'Long arrays, that contains data dictionaries, or lists';

	function __construct($mid) {
        parent::__construct($mid);
	}

	public function analyse() {
        $this->clean_report();

	    $query = <<<SQL
SELECT NULL, T2.file, CONCAT(SUM(IF(T3.type='_empty_',0,1)), ' elements'), T2.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file      AND
       T2.left = T1.right + 1 AND
       T2.type='arglist'
JOIN <tokens> T3
    ON T3.file = T1.file AND
       T3.left BETWEEN T2.left AND T2.right AND
       T3.level = T2.level + 1 
WHERE T1.code='array' AND 
      T2.right - T2.left > 1
GROUP BY T2.id
SQL;
        $this->exec_query_insert('report', $query);
        
        return true;
	}
}

?>