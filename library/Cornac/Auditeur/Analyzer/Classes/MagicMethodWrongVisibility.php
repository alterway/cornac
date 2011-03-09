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


class Cornac_Auditeur_Analyzer_Classes_MagicMethodWrongVisibility extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Magic methods with wrong visibility';
	protected	$description = 'Spot Magic methods with wrong visibility.';

	function __construct($mid) {
        parent::__construct($mid);
	}

	public function analyse() {
        $this->clean_report();

// @doc spot private and protected
	    $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T1.class,'::',T1.code), T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left BETWEEN T1.left AND T1.right AND
       T2.type = '_ppp_' 
WHERE T1.type = '_function' AND
      T1.code IN ('__get','__set','__unset','__isset','__call') AND 
      T2.code IN ('private','protected')
SQL;
        $this->exec_query_insert('report', $query);

// @doc spot static
	    $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T1.class,'::',T1.code), T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left BETWEEN T1.left AND T1.right AND
       T2.type = '_static_' 
LEFT JOIN <report> TR
    ON TR.module = 'Classes_MagicMethodWrongVisibility' AND
       TR.token_id = T1.id
WHERE T1.type = '_function' AND
      T1.code IN ('__get','__set','__unset','__isset','__call') AND
      TR.id IS NULL
SQL;
        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>