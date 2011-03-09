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

class Cornac_Auditeur_Analyzer_Quality_GpcModified extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'GPC assignations';
	protected	$description = 'GPC variables being reassigned during the execution of a script';

	function __construct($mid) {
        parent::__construct($mid);
	}

	function dependsOn() {
	    return array('Structures_AffectationsVariables');
	}

	public function analyse() {
        $this->clean_report();

        $gpc_regexp = '(\\\\'.join('|\\\\',Cornac_Auditeur_Analyzer::getPHPGPC()).')';

        $query = <<<SQL
SELECT NULL, TR1.file, TR1.element, TR1.id, '{$this->name}', 0
FROM <report> TR1
WHERE TR1.module = 'Structures_AffectationsVariables' AND 
      BINARY TR1.element REGEXP '^$gpc_regexp'
SQL;
        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>