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

$res = mysqli_query($mid, 'show tables like "%_tasks"');

$tables = array();
$taille_max = 0;
while($row = mysqli_fetch_assoc($res)) {
    $table =  array_shift($row);
    $tables[] = $table;
    $taille_max = max($taille_max, strlen($table));
//    print"$table\n";
}

$total = 0;
foreach($tables as $table) {
    $res = mysqli_query($mid, "select count(*) as tasks, 
        sum(completed) / count(*) as processed, 
        sum(if(completed = 2,1,0)) as error, 
        sum(if(completed = 1,1,0)) as unfinished,
        count(*) as nb
        from $table WHERE completed != 3 and task='tokenize'");
    $row = mysqli_fetch_assoc($res);
    $total += $row['nb'];
    
    if ($row['processed'] == 100 && !in_array('-a', $args)) { continue; }
    
    print substr($table.str_repeat(' ', 30), 0, $taille_max)."\t{$row['tasks']}\t{$row['processed']} \t{$row['error']}\t{$row['unfinished']}\n";

    $res = mysqli_query($mid, "select right(target, locate('.', reverse(target))) as ext, count(*) as nb from $table where completed = 2 group by right(target, locate('.', reverse(target)))");
    $exts = array();
    while($row = mysqli_fetch_assoc($res)) {
        $exts[] = $row['ext']." (".$row['nb'].")";
    }
    if (count($exts)>0) {
        print join(", ", $exts)."\n";
    }
}

print count($tables)." projets testes\n";
print $total." fichiers testes\n";

?>