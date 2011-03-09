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

class Cornac_Auditeur_Analyzer_Names extends Cornac_Auditeur_Analyzer {

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
	// @doc search for tokens by name and type
	    $type_token = $this->noms['type_token'];
	    $type_tag = $this->noms['type_tags'];
        $this->noms = array();

        $this->clean_report();

        $query = <<<SQL
SELECT NULL, T1.file, T2.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens_tags> TT
    ON T1.id = TT.token_id  
JOIN <tokens> T2 
    ON TT.token_sub_id = T2.id   AND
       T1.file = T2.file
WHERE T1.type ='$type_token'     AND 
      TT.type = '$type_tag'
SQL;
        $this->exec_query_insert('report', $query);
    }
}

?>