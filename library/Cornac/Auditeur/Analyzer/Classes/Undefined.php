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

class Cornac_Auditeur_Analyzer_Classes_Undefined extends Cornac_Auditeur_Analyzer
 {
    protected    $title = 'Undefined classes';
    protected    $description = 'List of classes used, but never defined. PHP classes are omitted.';

    function __construct($mid) {
        parent::__construct($mid);
    }

    function dependsOn() {
        return array('Classes_Definitions','Classes_News');
    }
    
    public function analyse() {
        $this->clean_report();

        $in = "'".join("','", Cornac_Auditeur_Analyzer::getPHPClasses())."'";
        $query = <<<SQL
SELECT NULL, TR1.file, TR1.element AS code, TR1.id, '{$this->name}', 0
FROM <report> TR1
LEFT JOIN <report>  TR2 
    ON TR1.element = TR2.element  AND 
       TR2.module='Classes_Definitions' 
WHERE TR1.module = 'Classes_News' AND 
      TR2.element IS NULL         AND
      TR1.element NOT IN ($in)
SQL;

        $this->exec_query_insert('report', $query);
        return true;
    }
}

?>