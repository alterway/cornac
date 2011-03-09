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

class Function_Test extends Cornac_Tests_Tokenizeur
{
    /* 20 methodes */
    public function testFunction1()  { $this->generic_test('function.1'); }
    public function testFunction2()  { $this->generic_test('function.2'); }
    public function testFunction3()  { $this->generic_test('function.3'); }
    public function testFunction4()  { $this->generic_test('function.4'); }
    public function testFunction5()  { $this->generic_test('function.5'); }
    public function testFunction6()  { $this->generic_test('function.6'); }
    public function testFunction7()  { $this->generic_test('function.7'); }
    public function testFunction8()  { $this->generic_test('function.8'); }
    public function testFunction9()  { $this->generic_test('function.9'); }
    public function testFunction10()  { $this->generic_test('function.10'); }
    public function testFunction11()  { $this->generic_test('function.11'); }
    public function testFunction12()  { $this->generic_test('function.12'); }
    public function testFunction13()  { $this->generic_test('function.13'); }
    public function testFunction14()  { $this->generic_test('function.14'); }
    public function testFunction15()  { $this->generic_test('function.15'); }
    public function testFunction16()  { $this->generic_test('function.16'); }
    public function testFunction17()  { $this->generic_test('function.17'); }
    public function testFunction18()  { $this->generic_test('function.18'); }
    public function testFunction19()  { $this->generic_test('function.19'); }
    public function testFunction20()  { $this->generic_test('function.20'); }

}

?>