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


class Cornac_Auditeur_Analyzer_Commands_SqlConcatenation extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'SQL concatenations';
	protected	$description = 'Spot concatenations that are building SQL queries.';

	function __construct($mid) {
        parent::__construct($mid);
	}

// @doc if this analyzer is based on previous result, use this to make sure the results are here
	function dependsOn() {
	    return array('Commands_Sql');
	}


	public function analyse() {
        $this->clean_report();

	    $query = <<<SQL
SELECT NULL, T1.file, TC.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left BETWEEN T1.left AND T1.right AND
       T2.type = 'literals'
JOIN <report> TR
    ON T2.id = TR.token_id AND
       TR.module = 'Commands_Sql'
JOIN <tokens_cache> TC
    ON T1.id = TC.id
WHERE T1.type = 'concatenation'
SQL;

        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>