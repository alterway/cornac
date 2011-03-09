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


class Cornac_Auditeur_Analyzer_Php_Keywords extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'PHP keyword';
	protected	$description = 'Usage of PHP keywords in the application\'s literals, or structures\' names, not in the code source, where they belong. This may lead to confusion.';

	function __construct($mid) {
        parent::__construct($mid);
	}

// @doc if this analyzer is based on previous result, use this to make sure the results are here
	function dependsOn() {
	    return array();
	}

	public function analyse() {
        $this->clean_report();

        $in = Cornac_Auditeur_Analyzer::getPHPKeywords();
        $in = '"'.join('", "', $in).'"';

// @note used as literals
	    $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
WHERE T1.code IN ($in) AND
      T1.type = 'literals'
SQL;
        $this->exec_query_insert('report', $query);

// @note search in variables/properties
	    $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
WHERE RIGHT(T1.code, LENGTH(T1.code) - 1) IN ($in) AND 
      T1.type = 'variable'
SQL;
        $this->exec_query_insert('report', $query);

// @note used as function name
	    $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens_tags> TT
JOIN <tokens> T1
    ON TT.token_sub_id = T1.id
WHERE T1.code IN ($in) AND
      TT.type IN ('name')
SQL;
        $this->exec_query_insert('report', $query);

        return true;

	}
}

?>