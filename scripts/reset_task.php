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
$args = $argv;

$mid = mysqli_connect('localhost','root','','analyseur');

$table = $argv[1];

print "Correction de $table\n";

$res = mysqli_query($mid, 'show tables like "'.$table.'"');
if ($res->num_rows == 0) {
    print "No {$table}_task. Aborting\n";
}

$res = mysqli_query($mid, 'select id, target from '.$table.'_tasks where completed=1 AND now() > date_update + interval 1 minute');
if ($res->num_rows == 0) {
    print "No task to reset.\n";
} else {
    print $res->num_rows." tasks to reset.\n";
    
    
    while($row = mysqli_fetch_assoc($res)) {
        $res2 = mysqli_query($mid, 'update '.$table.'_tasks set completed=0 where id='.$row['id']);
        print $row['target']." reset\n";
    }
}

?>