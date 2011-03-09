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

class Property_Test extends Cornac_Tests_Tokenizeur
{
    /* 20 methodes */
    public function testProperty1()  { $this->generic_test('property.1'); }
    public function testProperty2()  { $this->generic_test('property.2'); }
    public function testProperty3()  { $this->generic_test('property.3'); }
    public function testProperty4()  { $this->generic_test('property.4'); }
    public function testProperty5()  { $this->generic_test('property.5'); }
    public function testProperty6()  { $this->generic_test('property.6'); }
    public function testProperty7()  { $this->generic_test('property.7'); }
    public function testProperty8()  { $this->generic_test('property.8'); }
    public function testProperty9()  { $this->generic_test('property.9'); }
    public function testProperty10()  { $this->generic_test('property.10'); }
    public function testProperty11()  { $this->generic_test('property.11'); }
    public function testProperty12()  { $this->generic_test('property.12'); }
    public function testProperty13()  { $this->generic_test('property.13'); }
    public function testProperty14()  { $this->generic_test('property.14'); }
    public function testProperty15()  { $this->generic_test('property.15'); }
    public function testProperty16()  { $this->generic_test('property.16'); }
    public function testProperty17()  { $this->generic_test('property.17'); }
    public function testProperty18()  { $this->generic_test('property.18'); }
    public function testProperty19()  { $this->generic_test('property.19'); }
    public function testProperty20()  { $this->generic_test('property.20'); }

}

?>