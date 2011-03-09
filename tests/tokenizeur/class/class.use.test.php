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

class Use_Test extends Cornac_Tests_Tokenizeur
{
    /* 10 methodes */
    public function testUse1()  { $this->generic_test('use.1'); }
    public function testUse2()  { $this->generic_test('use.2'); }
    public function testUse3()  { $this->generic_test('use.3'); }
    public function testUse4()  { $this->generic_test('use.4'); }
    public function testUse5()  { $this->generic_test('use.5'); }
    public function testUse6()  { $this->generic_test('use.6'); }
    public function testUse7()  { $this->generic_test('use.7'); }
    public function testUse8()  { $this->generic_test('use.8'); }
    public function testUse9()  { $this->generic_test('use.9'); }
    public function testUse10()  { $this->generic_test('use.10'); }

}

?>