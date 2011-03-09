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

class Cornac_Auditeur_Analyzer_Classes_MethodsSpecial extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Special method';
	protected	$description = 'List of all PHP special methods';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

        $concat = $this->concat("T1.class","'->'","T1.scope");
        $query = <<<SQL
SELECT NULL, T1.file, $concat, T1.id, '{$this->name}' , 0
FROM <tokens> T1
WHERE scope IN ( '__construct','__toString','__destruct',
                 '__set','__get','__call','__callStatic',
                 '__clone','__toString','__unset','__isset','__set_state',
                 '__invoke',
                 '__wakeup','__sleep'
                 ) 
       OR scope = class 
GROUP BY file, class, scope;
SQL;
    $this->exec_query_insert('report', $query);

        $query = <<<SQL
SELECT NULL, T1.file, T1.scope, T1.id, '{$this->name}' , 0
FROM <tokens> T1
WHERE scope IN ( '__autoload' ) AND 
      T1.type='_function'
SQL;
        $this->exec_query_insert('report', $query);
	}
}

?>