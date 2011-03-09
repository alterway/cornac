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

class Throw_Test extends Cornac_Tests_Tokenizeur
{
    /* 12 methodes */
    public function testThrow1()  { $this->generic_test('throw.1'); }
    public function testThrow2()  { $this->generic_test('throw.2'); }
    public function testThrow3()  { $this->generic_test('throw.3'); }
    public function testThrow4()  { $this->generic_test('throw.4'); }
    public function testThrow5()  { $this->generic_test('throw.5'); }
    public function testThrow6()  { $this->generic_test('throw.6'); }
    public function testThrow7()  { $this->generic_test('throw.7'); }
    public function testThrow8()  { $this->generic_test('throw.8'); }
    public function testThrow9()  { $this->generic_test('throw.9'); }
    public function testThrow10()  { $this->generic_test('throw.10'); }
    public function testThrow11()  { $this->generic_test('throw.11'); }
    public function testThrow12()  { $this->generic_test('throw.12'); }

}

?>