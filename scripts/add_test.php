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
$name = $argv[1];

if (empty($name)) {
    print "usage : add_test [project name]\n\n";
    die();
}

$files = glob('../References/'.$name.'*');
if (count($files) == 0) {
    print "Can't find $name project in reference. Aborting\n\n";
    die();
} elseif ( in_array('../References/'.$name, $files)) {
    print "Found exact matching \n";
} elseif ( count($files) > 1) {
    print "Found too many project (".count($files)."): ".str_replace('../References/','', join(', ', $files)).". Aborting\n\n";
    die();
}

if (file_exists('./ini/'.$name.'.ini')) {
    print "$name.ini already exists.\n\nNothing to do\n";
    print "\n./bin/tok -r -I $name -g mysql,cache -d {$files[0]}/\n";
    die();
}
// ini file
copy('./ini/akelos.ini','ini/'.$name.'.ini');
$code = file_get_contents('ini/'.$name.'.ini');
$code = preg_replace('$origin = "./References/akelos-1.0.1"$','origin = "'.$files[0].'"', $code);
$code = str_replace('akelos',$name, $code);
file_put_contents('ini/'.$name.'.ini', $code);
print "ini/$name created\n";

// tokenizeur.sh
$code = file_get_contents('../References/tokenizeur.sh');
$code = str_replace("# next test\n","echo \"$name\\n\";
./bin/tok -r -I $name -g mysql,cache -d {$files[0]}/
# next test\n", $code);
file_put_contents('../References/tokenizeur.sh', $code);
print "tokenizeur.sh updated\n";

print "\n./bin/tok -r -I $name -g mysql,cache -d {$files[0]}/\n";

print preg_match_all('$echo$is', $code, $r)." projects\n";




?>