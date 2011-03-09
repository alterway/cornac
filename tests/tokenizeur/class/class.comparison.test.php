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

class Comparison_Test extends Cornac_Tests_Tokenizeur
{
    /* 19 methodes */
    public function testComparison1()  { $this->generic_test('comparison.1'); }
    public function testComparison2()  { $this->generic_test('comparison.2'); }
    public function testComparison3()  { $this->generic_test('comparison.3'); }
    public function testComparison4()  { $this->generic_test('comparison.4'); }
    public function testComparison5()  { $this->generic_test('comparison.5'); }
    public function testComparison6()  { $this->generic_test('comparison.6'); }
    public function testComparison7()  { $this->generic_test('comparison.7'); }
    public function testComparison8()  { $this->generic_test('comparison.8'); }
    public function testComparison9()  { $this->generic_test('comparison.9'); }
    public function testComparison10()  { $this->generic_test('comparison.10'); }
    public function testComparison11()  { $this->generic_test('comparison.11'); }
    public function testComparison12()  { $this->generic_test('comparison.12'); }
    public function testComparison13()  { $this->generic_test('comparison.13'); }
    public function testComparison14()  { $this->generic_test('comparison.14'); }
    public function testComparison15()  { $this->generic_test('comparison.15'); }
    public function testComparison16()  { $this->generic_test('comparison.16'); }
    public function testComparison17()  { $this->generic_test('comparison.17'); }
    public function testComparison18()  { $this->generic_test('comparison.18'); }
    public function testComparison19()  { $this->generic_test('comparison.19'); }

}

?>