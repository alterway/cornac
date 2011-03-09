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


class Cornac_Auditeur_Analyzer_Classes_PropertiesChained extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Chained Properties';
	protected	$description = 'Spot when several properties are chained and called one after the other.';

	function __construct($mid) {
        parent::__construct($mid);
	}

	function dependsOn() {
	    return array('Classes_Properties');
	}

	public function analyse() {
        $this->clean_report();

	    $query = <<<SQL
SELECT NULL, T1.file, TC.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens_tags> TT
ON TT.token_id = T1.id AND
   TT.type = 'object'
JOIN <tokens> T2
ON T1.file = T2.file AND
   T1.left + 1 = T2.left AND
   T2.type = 'property'
JOIN <tokens_cache> TC
ON TC.id = T1.id
WHERE T1.type = 'property'
SQL;
        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>