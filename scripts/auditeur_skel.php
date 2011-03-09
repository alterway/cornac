#!/usr/bin/env php
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

chdir('../auditeur');

if (!isset($argv[1])) {
    die("Usage : skel [new analyzer name]\nCreates a new skeleton for analyze, in classes directory. \n");
}

$analyzer = trim($argv[1]);

if (empty($analyzer)) {
    print "'$analyzer' must be non empty.\n";
    die();
}

if (preg_match_all('/[^a-zA-Z0-9_]/', $analyzer, $r)) {
    print "'$analyzer' should be a unique name, made of letters, figures and _ (Here, ".join(', ', $r[0])." were found).\n";
    die();
}

if (count(explode('_', $analyzer)) != 2) {
    print "'$analyzer' name should contains only one _. ";
    die();
}

$analyzer_path = str_replace('_', '/', $analyzer);

if (!file_exists('classes/'.dirname($analyzer_path))) {
    print "'".'classes/'.basename($analyzer_path)."' : folder non-existent. \n";
    die();
}

if (file_exists('classes/'.$analyzer_path.'.php')) {
    print "'$analyzer' already exists.\n";
    die();
}

$code = '<?'.'php ';
$code .= "


class $analyzer extends modules {
	protected	\$title = 'Title for $analyzer';
	protected	\$description = 'This is the special analyzer $analyzer (default doc).';

	function __construct(\$mid) {
        parent::__construct(\$mid);
	}

// @doc if this analyzer is based on previous result, use this to make sure the results are here
	function dependsOn() {
	    return array();
	}

	public function analyse() {
        \$this->clean_report();

// @todo of course, update this useless query. :)
	    \$query = <<<SQL
SELECT NULL, T1.file, T1.code, T1.id, '{\$this->name}', 0
    FROM <tokens> T1
    WHERE type = 'variable'
SQL;
        \$this->exec_query_insert('report', \$query);

        return true;
	}
}

"
.'?'.'>';

file_put_contents('classes/'.$analyzer_path.'.php', $code);

$auditeur = file_get_contents('./auditeur.php');
$auditeur = str_replace("// new analyzers\n", "'$analyzer',\n// new analyzers\n", $auditeur);
file_put_contents('auditeur.php', $auditeur);
shell_exec('git add classes/'.$analyzer_path.'.php');

print "$analyzer created\n";
?>