<?php

$file = file_get_contents('build.properties');

preg_match("/version=(\d+)\.(\d)(\d+)\n/is", $file, $r);

$version = $r[1].".".$r[2].($r[3] + 1);

$file = preg_replace("/version=.*?\n/is", "version=".$version."\n", $file);

$file = preg_replace("/version_date=.*?\n/is", "version_date=".date('r')."\n", $file);
file_put_contents('build.properties', $file);

print "New version : ".$version."\n";

?>