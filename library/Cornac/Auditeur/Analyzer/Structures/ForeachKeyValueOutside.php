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

class Cornac_Auditeur_Analyzer_Structures_ForeachKeyValueOutside extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Foreach Key/values outside the loop';
	protected	$description = 'Spot blind variables used in a foreach loop, but also used outside of it';

	function __construct($mid) {
        parent::__construct($mid);
	}

// @doc if this analyzer is based on previous result, use this to make sure the results are here
	function dependsOn() {
	    return array('Structures_ForeachKeyValue');
	}
	
	public function analyse() {
        $this->clean_report();

// @rfu SELECT TR1.element, T1.left, T1.right, T2.left, T1.file, T1.line, T2.line

	    $query = <<<SQL
SELECT NULL, T1.file, T2.code, T2.id, '{$this->name}',0
FROM <report> TR1
JOIN <tokens> T1 
    ON T1.id = TR1.token_id
JOIN  <tokens> T2
    ON T1.file = T2.file     AND
       T1.class = T2.class   AND
       T1.scope = T2.scope   AND
       T2.code = TR1.element AND
       T2.left > T1.right
WHERE TR1.module='Structures_ForeachKeyValue'
SQL;
        $this->exec_query_insert('report', $query);
        
        return true;
	}
}

?>