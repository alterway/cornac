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

class Cornac_Auditeur_Analyzer_Classes_This extends Cornac_Auditeur_Analyzer {
    protected    $title = 'Wrong usage of $this';
    protected    $description = 'List usage of $this variable, outside a class scope. Noone should do this.';

    function __construct($mid) {
        parent::__construct($mid);
    }

    public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
WHERE code = '\$this'  AND 
      class = ''       AND
      type = 'variable'
SQL;
        $this->exec_query_insert('report', $query);

        return true;
    }
}

?>