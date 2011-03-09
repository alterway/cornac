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

class Cornac_Auditeur_Analyzer_Php_FunctionsCalls extends Cornac_Auditeur_Analyzer
 {
    protected $description = "Function calls"; 
    protected $title = "List all PHP function calls (native, user-land)"; 

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

	    $total = Cornac_Auditeur_Analyzer::getPHPFunctions();
	    $in = join("', '", $total);

        $query = <<<SQL
SELECT NULL, T1.file, T2.code AS code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
     ON T1.file = T2.file AND
        T1.left = T2.left - 1
LEFT JOIN <tokens_tags> TT
     ON T1.id = TT.token_sub_id
WHERE  T1.type='functioncall' AND
       (TT.token_id IS NULL OR TT.type != 'method')
SQL;

// AND
//       T2.code NOT IN ('$in')

        $this->exec_query_insert('report', $query);
        return true;
	}
}

?>