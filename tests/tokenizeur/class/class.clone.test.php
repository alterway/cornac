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

class Clone_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testClone1()  { $this->generic_test('clone.1'); }
    public function testClone2()  { $this->generic_test('clone.2'); }
    public function testClone3()  { $this->generic_test('clone.3'); }
    public function testClone4()  { $this->generic_test('clone.4'); }
    public function testClone5()  { $this->generic_test('clone.5'); }
    public function testClone6()  { $this->generic_test('clone.6'); }
    public function testClone7()  { $this->generic_test('clone.7'); }
    public function testClone8()  { $this->generic_test('clone.8'); }
    public function testClone9()  { $this->generic_test('clone.9'); }
    public function testClone10()  { $this->generic_test('clone.10'); }
    public function testClone11()  { $this->generic_test('clone.11'); }
    public function testClone12()  { $this->generic_test('clone.12'); }
    public function testClone13()  { $this->generic_test('clone.13'); }
    public function testClone14()  { $this->generic_test('clone.14'); }
    public function testClone15()  { $this->generic_test('clone.15'); }

}

?>