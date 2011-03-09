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

class While_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testWhile1()  { $this->generic_test('while.1'); }
    public function testWhile2()  { $this->generic_test('while.2'); }
    public function testWhile3()  { $this->generic_test('while.3'); }
    public function testWhile4()  { $this->generic_test('while.4'); }
    public function testWhile5()  { $this->generic_test('while.5'); }
    public function testWhile6()  { $this->generic_test('while.6'); }
    public function testWhile7()  { $this->generic_test('while.7'); }
    public function testWhile8()  { $this->generic_test('while.8'); }
    public function testWhile9()  { $this->generic_test('while.9'); }
    public function testWhile10()  { $this->generic_test('while.10'); }
    public function testWhile11()  { $this->generic_test('while.11'); }
    public function testWhile12()  { $this->generic_test('while.12'); }
    public function testWhile13()  { $this->generic_test('while.13'); }
    public function testWhile14()  { $this->generic_test('while.14'); }
    public function testWhile15()  { $this->generic_test('while.15'); }

}

?>