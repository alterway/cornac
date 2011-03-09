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

class Constant_Test extends Cornac_Tests_Tokenizeur
{
    /* 12 methodes */
    public function testConstant1()  { $this->generic_test('constant.1'); }
    public function testConstant2()  { $this->generic_test('constant.2'); }
    public function testConstant3()  { $this->generic_test('constant.3'); }
    public function testConstant4()  { $this->generic_test('constant.4'); }
    public function testConstant5()  { $this->generic_test('constant.5'); }
    public function testConstant6()  { $this->generic_test('constant.6'); }
    public function testConstant7()  { $this->generic_test('constant.7'); }
    public function testConstant8()  { $this->generic_test('constant.8'); }
    public function testConstant9()  { $this->generic_test('constant.9'); }
    public function testConstant10()  { $this->generic_test('constant.10'); }
    public function testConstant11()  { $this->generic_test('constant.11'); }
    public function testConstant12()  { $this->generic_test('constant.12'); }

}

?>