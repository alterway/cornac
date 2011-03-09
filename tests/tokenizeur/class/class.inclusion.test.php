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

class Inclusion_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testInclusion1()  { $this->generic_test('inclusion.1'); }
    public function testInclusion2()  { $this->generic_test('inclusion.2'); }
    public function testInclusion3()  { $this->generic_test('inclusion.3'); }
    public function testInclusion4()  { $this->generic_test('inclusion.4'); }
    public function testInclusion5()  { $this->generic_test('inclusion.5'); }
    public function testInclusion6()  { $this->generic_test('inclusion.6'); }
    public function testInclusion7()  { $this->generic_test('inclusion.7'); }
    public function testInclusion8()  { $this->generic_test('inclusion.8'); }
    public function testInclusion9()  { $this->generic_test('inclusion.9'); }
    public function testInclusion10()  { $this->generic_test('inclusion.10'); }
    public function testInclusion11()  { $this->generic_test('inclusion.11'); }
    public function testInclusion12()  { $this->generic_test('inclusion.12'); }
    public function testInclusion13()  { $this->generic_test('inclusion.13'); }
    public function testInclusion14()  { $this->generic_test('inclusion.14'); }
    public function testInclusion15()  { $this->generic_test('inclusion.15'); }

}

?>