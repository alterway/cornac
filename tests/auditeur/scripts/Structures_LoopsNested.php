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

foreach ($array as $key => $value) {
    foreach ($array_nested as $key_nested => $value_nested) {
        $x = 1;
    }
}

foreach ($array as $key => $value) {
    foreach ($array_nested as $key_nested => $value_nested) {
        foreach ($array_nested2 as $key_nested2 => $value_nested2) {
            $x = 2;
        }
    }
}

while($x = 3) {
    foreach ($array_nested as $key_nested => $value_nested) {
        $x = 4;
    }
}

foreach ($array as $key => $value) {
    while($x = 5) {
        $x = 6;
    }
}

while($x = 7) {
    foreach ($array_nested as $key_nested => $value_nested) {
        $x = 8;
    }
    while ($x = 10) {
        $x = 11;
    }
}

?>