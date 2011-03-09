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

class Structures_Constants_Test extends Cornac_Tests_Auditeur
{
    public function testStructures_Constants()  {
        $this->expected = array(     
    '(_constant VAL ? literals km : literals mois)',
    'a.__FILE__.b.true.c',
    '1 && 2',
    '(e == 3)',
    'strtolower(true)',
    'g(1, 2, 3, 4, 5)',
    'array(1, 2, 3)',
    'array(e => true)',
    ' (.m::n.)',
    '2 + 4',
    '_constant VAL ? literals km : literals mois',
 'km',
 'mois',
 'VAL',
 ')',
 ' (',
 'n',
 'm',
 ' (.m.)',
 'l',
 '(e => true)',
 'e => true',
 'true',
 'e',
 '3',
 '(1, 2, 3)',
 '2',
 '1',
 '(1, 2, 3, 4, 5)',
 '5',
 '4',
 '(false)',
 'false',
 '(true)',
 'e == 3',
 'c',
 'b',
 '__FILE__',
 'a',
 'm::n', 
 'array', 
 'g', 
 'strtolower',
 '==', 
 '&&', 
 '+'
);
        $this->unexpected = array(    '$e(false)',);

        parent::generic_test();
    }
}
?>