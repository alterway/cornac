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

class Typehint_Test extends Cornac_Tests_Tokenizeur
{
    /* 13 methodes */
    public function testTypehint1()  { $this->generic_test('typehint.1'); }
    public function testTypehint2()  { $this->generic_test('typehint.2'); }
    public function testTypehint3()  { $this->generic_test('typehint.3'); }
    public function testTypehint4()  { $this->generic_test('typehint.4'); }
    public function testTypehint5()  { $this->generic_test('typehint.5'); }
    public function testTypehint6()  { $this->generic_test('typehint.6'); }
    public function testTypehint7()  { $this->generic_test('typehint.7'); }
    public function testTypehint8()  { $this->generic_test('typehint.8'); }
    public function testTypehint9()  { $this->generic_test('typehint.9'); }
    public function testTypehint10()  { $this->generic_test('typehint.10'); }
    public function testTypehint11()  { $this->generic_test('typehint.11'); }
    public function testTypehint12()  { $this->generic_test('typehint.12'); }
    public function testTypehint13()  { $this->generic_test('typehint.13'); }

}

?>