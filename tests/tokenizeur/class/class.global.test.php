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

class Global_Test extends Cornac_Tests_Tokenizeur
{
    /* 11 methodes */
    public function testGlobal1()  { $this->generic_test('global.1'); }
    public function testGlobal2()  { $this->generic_test('global.2'); }
    public function testGlobal3()  { $this->generic_test('global.3'); }
    public function testGlobal4()  { $this->generic_test('global.4'); }
    public function testGlobal5()  { $this->generic_test('global.5'); }
    public function testGlobal6()  { $this->generic_test('global.6'); }
    public function testGlobal7()  { $this->generic_test('global.7'); }
    public function testGlobal8()  { $this->generic_test('global.8'); }
    public function testGlobal9()  { $this->generic_test('global.9'); }
    public function testGlobal10()  { $this->generic_test('global.10'); }
    public function testGlobal11()  { $this->generic_test('global.11'); }

}

?>