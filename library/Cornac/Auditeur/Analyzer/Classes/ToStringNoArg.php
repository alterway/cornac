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
   | Author: Damien Seguy <damien.seguy@alterway.fr>                      |
   +----------------------------------------------------------------------+
 */


class Cornac_Auditeur_Analyzer_Classes_ToStringNoArg extends Cornac_Auditeur_Analyzer
 {
    protected    $title = 'ToString with arguments';
    protected    $description = 'Spot __toString methods with arguments (Incompatible change for PHP 5.3)';
    protected    $tags = array('PHP_5.3');

    function __construct($mid) {
        parent::__construct($mid);
    }

    public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT NULL, T1.file, T1.class, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens> T2
    ON T2.file = T1.file AND
       T2.left BETWEEN T1.left AND T1.right AND
       T2.type = 'arglist'
LEFT JOIN <tokens> T3
    ON T3.file = T1.file     AND
       T3.left = T2.left + 1 AND
       T3.type = '_functioncall_'
WHERE T1.type = '_function'  AND
      T1.code = '__toString' AND
      T1.class != ''         AND
      T3.id IS NULL 
SQL;
        $this->exec_query_insert('report', $query);

        return true;
    }
}

?>