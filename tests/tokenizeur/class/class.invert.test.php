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

class Invert_Test extends Cornac_Tests_Tokenizeur
{
    /* 11 methodes */
    public function testInvert1()  { $this->generic_test('invert.1'); }
    public function testInvert2()  { $this->generic_test('invert.2'); }
    public function testInvert3()  { $this->generic_test('invert.3'); }
    public function testInvert4()  { $this->generic_test('invert.4'); }
    public function testInvert5()  { $this->generic_test('invert.5'); }
    public function testInvert6()  { $this->generic_test('invert.6'); }
    public function testInvert7()  { $this->generic_test('invert.7'); }
    public function testInvert8()  { $this->generic_test('invert.8'); }
    public function testInvert9()  { $this->generic_test('invert.9'); }
    public function testInvert10()  { $this->generic_test('invert.10'); }
    public function testInvert11()  { $this->generic_test('invert.11'); }

}

?>