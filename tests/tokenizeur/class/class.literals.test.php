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

class Literals_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testLiterals1()  { $this->generic_test('literals.1'); }
    public function testLiterals2()  { $this->generic_test('literals.2'); }
    public function testLiterals3()  { $this->generic_test('literals.3'); }
    public function testLiterals4()  { $this->generic_test('literals.4'); }
    public function testLiterals5()  { $this->generic_test('literals.5'); }
    public function testLiterals6()  { $this->generic_test('literals.6'); }
    public function testLiterals7()  { $this->generic_test('literals.7'); }
    public function testLiterals8()  { $this->generic_test('literals.8'); }
    public function testLiterals9()  { $this->generic_test('literals.9'); }
    public function testLiterals10()  { $this->generic_test('literals.10'); }
    public function testLiterals11()  { $this->generic_test('literals.11'); }
    public function testLiterals12()  { $this->generic_test('literals.12'); }
    public function testLiterals13()  { $this->generic_test('literals.13'); }
    public function testLiterals14()  { $this->generic_test('literals.14'); }
    public function testLiterals15()  { $this->generic_test('literals.15'); }

}

?>