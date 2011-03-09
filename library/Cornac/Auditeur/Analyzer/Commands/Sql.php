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

class Cornac_Auditeur_Analyzer_Commands_Sql extends Cornac_Auditeur_Analyzer_Names {
	protected	$title = 'SQL queries';
	protected	$description = 'SQL queries spotted in the literals';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT NULL, T1.file, T1.code AS code, T1.id, '{$this->name}', 0
FROM <tokens> T1 
WHERE T1.type = 'literals' and (
    (T1.code LIKE "%SELECT %" AND
     T1.code NOT LIKE "%<SELECT %" ) OR
    T1.code LIKE "%DELETE %" OR
    T1.code LIKE "%UPDATE %" OR
    T1.code LIKE "%INSERT %" OR
    T1.code LIKE "%CREATE TABLE%" OR
    T1.code LIKE "%JOIN%" OR
    T1.code LIKE "%ORDER BY%" OR
    T1.code LIKE "%JOIN%" OR
    T1.code LIKE "%WHERE%" OR
    T1.code LIKE "%HAVING %"
)
SQL;

        $this->exec_query_insert('report', $query);
        return true;
	}
}

?>