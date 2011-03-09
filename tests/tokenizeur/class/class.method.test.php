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

class Method_Test extends Cornac_Tests_Tokenizeur
{
    /* 21 methodes */
    public function testMethod1()  { $this->generic_test('method.1'); }
    public function testMethod2()  { $this->generic_test('method.2'); }
    public function testMethod3()  { $this->generic_test('method.3'); }
    public function testMethod4()  { $this->generic_test('method.4'); }
    public function testMethod5()  { $this->generic_test('method.5'); }
    public function testMethod6()  { $this->generic_test('method.6'); }
    public function testMethod7()  { $this->generic_test('method.7'); }
    public function testMethod8()  { $this->generic_test('method.8'); }
    public function testMethod9()  { $this->generic_test('method.9'); }
    public function testMethod10()  { $this->generic_test('method.10'); }
    public function testMethod11()  { $this->generic_test('method.11'); }
    public function testMethod12()  { $this->generic_test('method.12'); }
    public function testMethod13()  { $this->generic_test('method.13'); }
    public function testMethod14()  { $this->generic_test('method.14'); }
    public function testMethod15()  { $this->generic_test('method.15'); }
    public function testMethod16()  { $this->generic_test('method.16'); }
    public function testMethod17()  { $this->generic_test('method.17'); }
    public function testMethod18()  { $this->generic_test('method.18'); }
    public function testMethod19()  { $this->generic_test('method.19'); }
    public function testMethod20()  { $this->generic_test('method.20'); }
    public function testMethod21()  { $this->generic_test('method.21'); }

}

?>