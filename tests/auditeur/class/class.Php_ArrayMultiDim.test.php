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

include_once('../../library/Cornac/Autoload.php');
spl_autoload_register('Cornac_Autoload::autoload');

class Php_ArrayMultiDim_Test extends Cornac_Tests_Auditeur
{
    public function testVariables()  { 
        $this->expected = array(
//'$x1[1]',
'$x2[2][3]',
'$x3[4][5][6]',
'$x4[$x[7][8]][9]',
'$x[7][8]',
//'$x10[1]',
'$x2[10][]',
'$x3[1][2]',
'$x3[][10]',
'$x3[1][2][3][4][5]',
'$x3[][]',
'$x6[10][20][30][40][50][60]',
);
        $this->unexpected = array();
        
        parent::generic_counted_test();
    }
}

?>