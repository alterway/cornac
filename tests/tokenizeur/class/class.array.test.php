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

class Array_Test extends Cornac_Tests_Tokenizeur
{
    /* 14 methodes */
    public function testArray1()  { $this->generic_test('array.1'); }
    public function testArray2()  { $this->generic_test('array.2'); }
    public function testArray3()  { $this->generic_test('array.3'); }
    public function testArray4()  { $this->generic_test('array.4'); }
    public function testArray5()  { $this->generic_test('array.5'); }
    public function testArray6()  { $this->generic_test('array.6'); }
    public function testArray7()  { $this->generic_test('array.7'); }
    public function testArray8()  { $this->generic_test('array.8'); }
    public function testArray9()  { $this->generic_test('array.9'); }
    public function testArray10()  { $this->generic_test('array.10'); }
    public function testArray11()  { $this->generic_test('array.11'); }
    public function testArray12()  { $this->generic_test('array.12'); }
    public function testArray13()  { $this->generic_test('array.13'); }
    public function testArray14()  { $this->generic_test('array.14'); }

}

?>