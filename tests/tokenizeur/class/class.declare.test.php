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

class Declare_Test extends Cornac_Tests_Tokenizeur
{
    /* 10 methodes */
    public function testDeclare1()  { $this->generic_test('declare.1'); }
    public function testDeclare2()  { $this->generic_test('declare.2'); }
    public function testDeclare3()  { $this->generic_test('declare.3'); }
    public function testDeclare4()  { $this->generic_test('declare.4'); }
    public function testDeclare5()  { $this->generic_test('declare.5'); }
    public function testDeclare6()  { $this->generic_test('declare.6'); }
    public function testDeclare7()  { $this->generic_test('declare.7'); }
    public function testDeclare8()  { $this->generic_test('declare.8'); }
    public function testDeclare9()  { $this->generic_test('declare.9'); }
    public function testDeclare10()  { $this->generic_test('declare.10'); }

}

?>