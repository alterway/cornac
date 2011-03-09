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

class Cornac_Auditeur_Analyzer_Classes_MethodsDefinition extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Methods definitions';
	protected	$description = 'List of defined methods';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

        $concat = $this->concat("T1.class","'->'","T2.code");
        $query = <<<SQL
SELECT NULL, T1.file, $concat AS code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens_tags> TT
    ON T1.id = TT.token_id  
JOIN <tokens> T2 
    ON TT.token_sub_id = T2.id
WHERE T1.type='_function'      AND 
      TT.type = 'name'         AND
      T1.class != ''
SQL;

        $this->exec_query_insert('report', $query);
        return true;
	}
}

?>