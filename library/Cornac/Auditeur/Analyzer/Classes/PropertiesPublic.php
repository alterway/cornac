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

class Cornac_Auditeur_Analyzer_Classes_PropertiesPublic extends Cornac_Auditeur_Analyzer
 {
	protected	$description = 'Public properties';
	protected	$title = 'List of public properties in classes. Defined as such, or used as such.';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
        $this->clean_report();

        // @doc case of simple public var and ppp : public $x
        $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T1.class,'::',T3.code), T1.id,  '{$this->name}', 0
FROM <tokens> T1 
LEFT JOIN <tokens> T2
    ON T1.left + 1 = T2.left AND
       T1.file = T2.file     AND
       T2.code = 'public'    AND
       T2.type = '_ppp_'
JOIN <tokens> T3
    ON T1.file = T2.file     AND 
       T3.left = T1.left + 3 AND
       T1.file = T3.file     AND
       T3.type != '_static_'
WHERE T1.type = '_var'
SQL;
        $this->exec_query_insert('report',$query);

// @doc case of static public $x
// @doc case of public static $x
        $query = <<<SQL
SELECT NULL, T1.file, CONCAT(T1.class,'::',T4.code), T1.id,  '{$this->name}', 0
FROM <tokens> T1 
JOIN <tokens> T2
    ON T1.left + 1 = T2.left AND
       T1.file = T2.file     AND 
       T2.type = '_ppp_'     AND
       T2.code = 'public'
JOIN <tokens> T3
    ON T3.left = T1.left + 3 AND
       T1.file = T3.file     AND
       T3.type = '_static_' 
JOIN <tokens> T4
    ON T1.file = T4.file AND 
       T4.left = T1.left + 5 AND
       T1.file = T4.file
WHERE T1.type = '_var'
SQL;
        $this->exec_query_insert('report',$query);

    // @todo support class and methods
    // @todo support also static and var keyword
    
        return true;
    }
}

?>