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

class Property_static_Test extends Cornac_Tests_Tokenizeur
{
    /* 13 methodes */
    public function testProperty_static1()  { $this->generic_test('property_static.1'); }
    public function testProperty_static2()  { $this->generic_test('property_static.2'); }
    public function testProperty_static3()  { $this->generic_test('property_static.3'); }
    public function testProperty_static4()  { $this->generic_test('property_static.4'); }
    public function testProperty_static5()  { $this->generic_test('property_static.5'); }
    public function testProperty_static6()  { $this->generic_test('property_static.6'); }
    public function testProperty_static7()  { $this->generic_test('property_static.7'); }
    public function testProperty_static8()  { $this->generic_test('property_static.8'); }
    public function testProperty_static9()  { $this->generic_test('property_static.9'); }
    public function testProperty_static10()  { $this->generic_test('property_static.10'); }
    public function testProperty_static11()  { $this->generic_test('property_static.11'); }
    public function testProperty_static12()  { $this->generic_test('property_static.12'); }
    public function testProperty_static13()  { $this->generic_test('property_static.13'); }

}

?>