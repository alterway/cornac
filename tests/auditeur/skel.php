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

if (!isset($argv[1])) {
    die("Usage : skel [new analyzer name]\nCreates a new skeleton for tests. \n");
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

if (file_exists('class.'.$analyzer.'.test.php')) {
    print "'class.$analyzer.test.php' already exists.\n";
    die();
}

if (file_exists('scripts/'.$analyzer.'.php')) {
    print "script for '$analyzer' already exists. Remove it first.\n";
    die();
}

$analyzer_path = str_replace('_','/', $analyzer);
if (!file_exists('../../auditeur/classes/'.$analyzer_path.'.php')) {
    print "'$analyzer' analyzers doesn't exist. Create the analyzer first.\n";
    die();
}

$code = '<?'.'php ';
$code .= "



include_once('../../library/Cornac/Autoload.php');
spl_autoload_register('Cornac_Autoload::autoload');

class {$analyzer}_Test extends Cornac_Tests_Auditeur
{
    public function test{$analyzer}()  {
        \$this->expected = array( '');
        \$this->unexpected = array(/*'',*/);

        parent::generic_test();
//        parent::generic_counted_test();
    }
}
"
.'?'.'>';

file_put_contents('class.'.$analyzer.'.test.php', $code);
$auditeur = file_get_contents('./alltests.php');
$auditeur = str_replace("// new tests\n", "'class.$analyzer.test.php',\n// new tests\n", $auditeur);
file_put_contents('alltests.php', $auditeur);

file_put_contents('scripts/'.$analyzer.'.php', '<?'.'php'.<<<PHP




PHP
."\n\n\n".'?'.'>');

// @synopsis add to git
shell_exec('git add class.'.$analyzer.'.test.php');
shell_exec('git add scripts/'.$analyzer.'.php');

// @synopsis tell user
print "$analyzer created\n";
?>