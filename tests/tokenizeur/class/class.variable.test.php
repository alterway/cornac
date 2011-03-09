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

class Variable_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testVariable1()  { $this->generic_test('variable.1'); }
    public function testVariable2()  { $this->generic_test('variable.2'); }
    public function testVariable3()  { $this->generic_test('variable.3'); }
    public function testVariable4()  { $this->generic_test('variable.4'); }
    public function testVariable5()  { $this->generic_test('variable.5'); }
    public function testVariable6()  { $this->generic_test('variable.6'); }
    public function testVariable7()  { $this->generic_test('variable.7'); }
    public function testVariable8()  { $this->generic_test('variable.8'); }
    public function testVariable9()  { $this->generic_test('variable.9'); }
    public function testVariable10()  { $this->generic_test('variable.10'); }
    public function testVariable11()  { $this->generic_test('variable.11'); }
    public function testVariable12()  { $this->generic_test('variable.12'); }
    public function testVariable13()  { $this->generic_test('variable.13'); }
    public function testVariable14()  { $this->generic_test('variable.14'); }
    public function testVariable15()  { $this->generic_test('variable.15'); }

}

?>