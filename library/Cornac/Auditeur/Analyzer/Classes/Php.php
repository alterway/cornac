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

class Cornac_Auditeur_Analyzer_Classes_Php extends Cornac_Auditeur_Analyzer_Functioncalls {
	protected	$description = 'PHP classes used';
	protected	$title = 'PHP Classes being used';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	function dependsOn() {
	    return array();
	}
	
	public function analyse() {
        $this->clean_report();

	    $in = join("', '", Cornac_Auditeur_Analyzer::getPHPClasses());

        $query = <<<SQL
SELECT NULL, T1.file, T2.code AS code, T1.id, '{$this->name}', 0
FROM <tokens> T1 
JOIN <tokens> T2
    ON T2.left = T1.left + 1 AND
       T2.file = T1.file
WHERE T1.type='_new' AND 
      T2.code IN ('$in')
SQL;
        $this->exec_query_insert('report', $query);
        
        return true;
    }
}

?>