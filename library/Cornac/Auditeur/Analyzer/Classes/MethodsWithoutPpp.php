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


class Cornac_Auditeur_Analyzer_Classes_MethodsWithoutPpp extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'Methods without PPP';
	protected	$description = 'Spot methods that do not bear any of the ppp visibility attribute : they shoud be mentions explicitly. ';

	function __construct($mid) {
        parent::__construct($mid);
	}

	public function analyse() {
        $this->clean_report();

	    $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
LEFT JOIN <tokens> T2
    ON T2.file = T1.file        AND
       T2.type = '_ppp_' AND
       (T2.left = T1.left + 1 OR 
        T2.left = T1.left + 3 OR 
        T2.left = T1.left + 5
        )
WHERE T1.type='_function' AND
      T1.class!= ''
GROUP BY T1.class, T1.code
HAVING SUM(IF(T2.code IN ('protected','private','public'), 1, 0)) = 0
SQL;
        $this->exec_query_insert('report', $query);

        return true;
	}
}

?>