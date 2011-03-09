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

class Rawtext_Test extends Cornac_Tests_Tokenizeur
{
    /* 13 methodes */
    public function testRawtext1()  { $this->generic_test('rawtext.1'); }
    public function testRawtext2()  { $this->generic_test('rawtext.2'); }
    public function testRawtext3()  { $this->generic_test('rawtext.3'); }
    public function testRawtext4()  { $this->generic_test('rawtext.4'); }
    public function testRawtext5()  { $this->generic_test('rawtext.5'); }
    public function testRawtext6()  { $this->generic_test('rawtext.6'); }
    public function testRawtext7()  { $this->generic_test('rawtext.7'); }
    public function testRawtext8()  { $this->generic_test('rawtext.8'); }
    public function testRawtext9()  { $this->generic_test('rawtext.9'); }
    public function testRawtext10()  { $this->generic_test('rawtext.10'); }
    public function testRawtext11()  { $this->generic_test('rawtext.11'); }
    public function testRawtext12()  { $this->generic_test('rawtext.12'); }
    public function testRawtext13()  { $this->generic_test('rawtext.13'); }

}

?>