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

class Cornac_Auditeur_Analyzer_Variables_Session extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Session variables';
	protected	$description = 'Variables sessions, as seen in $_SESSION';

	function __construct($mid) {
        parent::__construct($mid);
	}

	public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT NULL, T1.file, T3.code, T1.id, '{$this->name}', 0
    FROM <tokens> T1
    JOIN <tokens> T2
        ON T2.left = T1.left + 1 AND
           T1.file = T2.file AND
           T2.type = 'variable' AND
           T2.code =  BINARY '\$_SESSION'
    JOIN <tokens> T3
        ON T3.left = T2.right + 1 AND
           T3.right < T1.right     AND
           T1.file = T3.file
    WHERE T1.type='_array'
SQL;
        $res = $this->exec_query_insert('report', $query);
	}
}

?>