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


class Cornac_Auditeur_Analyzer_Zf_Redirect extends Cornac_Auditeur_Analyzer
 {
	protected	$title = 'ZF : redirection';
	protected	$description = 'List of redirection using Zend Framework. ';

	function __construct($mid) {
        parent::__construct($mid);
	}

	function dependsOn() {
	    return array();
	}

	public function analyse() {
        $this->clean_report();

	    $query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{$this->name}', 0
FROM <tokens> T1
JOIN <tokens_tags> TT
    ON TT.token_sub_id = T1.id
WHERE
    T1.code in ('_redirect',
                'redirect'  ) AND 
    TT.type='function'
SQL;

    $this->exec_query_insert('report', $query);
	}
}

?>