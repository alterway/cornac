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

class Cornac_Auditeur_Analyzer_Functions_Occurrences extends Cornac_Auditeur_Analyzer_Names {
	protected	$title = 'Function frequency';
	protected	$description = 'List all function call, and their frequency.';

	function __construct($mid) {
        parent::__construct($mid);
	}
	
	public function analyse() {
	    $this->noms['type_token'] = 'functioncall';
	    $this->noms['type_tags'] = 'function';
	    
	    parent::analyse();
	    
	    return true;
	}
}

?>