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

class Arrayfct_Test extends Cornac_Tests_Tokenizeur
{
    /* 13 methodes */
    public function testArrayfct1()  { $this->generic_test('arrayfct.1'); }
    public function testArrayfct2()  { $this->generic_test('arrayfct.2'); }
    public function testArrayfct3()  { $this->generic_test('arrayfct.3'); }
    public function testArrayfct4()  { $this->generic_test('arrayfct.4'); }
    public function testArrayfct5()  { $this->generic_test('arrayfct.5'); }
    public function testArrayfct6()  { $this->generic_test('arrayfct.6'); }
    public function testArrayfct7()  { $this->generic_test('arrayfct.7'); }
    public function testArrayfct8()  { $this->generic_test('arrayfct.8'); }
    public function testArrayfct9()  { $this->generic_test('arrayfct.9'); }
    public function testArrayfct10()  { $this->generic_test('arrayfct.10'); }
    public function testArrayfct11()  { $this->generic_test('arrayfct.11'); }
    public function testArrayfct12()  { $this->generic_test('arrayfct.12'); }
    public function testArrayfct13()  { $this->generic_test('arrayfct.13'); }

}

?>