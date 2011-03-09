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

class Cornac_Auditeur_Analyzer_Constants_FileLink extends Cornac_Auditeur_Analyzer
 {
    protected    $title = 'File relations via constants';
    protected    $description = 'Files that are using the same constants. They are now linked together';

    function __construct($mid) {
        parent::__construct($mid);
        
        $this->format = Cornac_Auditeur_Analyzer::FORMAT_DOT;
    }

// @doc if this analyzer is based on previous result, use this to make sure the results are here
    function dependsOn() {
        return array('Constants_Definitions','Constants_Usage');
    }
    
    public function analyse() {
        $this->clean_report();

        $query = <<<SQL
SELECT TR1.file, TR2.file, TR1.element, '{$this->name}'
FROM <report>  TR1
JOIN <report> TR2
    ON TR2.module = 'Constants_Usage' AND
       TR2.element = TR1.element
WHERE TR1.module='Constants_Definitions'
SQL;
        $this->exec_query_insert('report_dot', $query);
        
        return true;
    }
}

?>