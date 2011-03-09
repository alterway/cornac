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

class Cornac_Auditeur_Analyzer_Classes_Hierarchy extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Classes hierarchy';
	protected	$description = 'Classes hierarchy, through extends keyword';

	function __construct($mid) {
        parent::__construct($mid);
        
        $this->format = Cornac_Auditeur_Analyzer::FORMAT_DOT;
	}
	
	public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT T2.code, T2.class,'', '{$this->name}'
FROM <tokens_tags> TT
JOIN <tokens> T2
   ON TT.token_sub_id = T2.id
WHERE TT.type = 'extends'
SQL;
    
        $this->exec_query_insert('report_dot',$query);
    }
}

?>