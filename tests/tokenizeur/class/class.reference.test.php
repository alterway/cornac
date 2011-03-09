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

class Reference_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testReference1()  { $this->generic_test('reference.1'); }
    public function testReference2()  { $this->generic_test('reference.2'); }
    public function testReference3()  { $this->generic_test('reference.3'); }
    public function testReference4()  { $this->generic_test('reference.4'); }
    public function testReference5()  { $this->generic_test('reference.5'); }
    public function testReference6()  { $this->generic_test('reference.6'); }
    public function testReference7()  { $this->generic_test('reference.7'); }
    public function testReference8()  { $this->generic_test('reference.8'); }
    public function testReference9()  { $this->generic_test('reference.9'); }
    public function testReference10()  { $this->generic_test('reference.10'); }
    public function testReference11()  { $this->generic_test('reference.11'); }
    public function testReference12()  { $this->generic_test('reference.12'); }
    public function testReference13()  { $this->generic_test('reference.13'); }
    public function testReference14()  { $this->generic_test('reference.14'); }
    public function testReference15()  { $this->generic_test('reference.15'); }

}

?>