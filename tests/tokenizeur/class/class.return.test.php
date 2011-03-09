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

class Return_Test extends Cornac_Tests_Tokenizeur
{
    /* 10 methodes */
    public function testReturn1()  { $this->generic_test('return.1'); }
    public function testReturn2()  { $this->generic_test('return.2'); }
    public function testReturn3()  { $this->generic_test('return.3'); }
    public function testReturn4()  { $this->generic_test('return.4'); }
    public function testReturn5()  { $this->generic_test('return.5'); }
    public function testReturn6()  { $this->generic_test('return.6'); }
    public function testReturn7()  { $this->generic_test('return.7'); }
    public function testReturn8()  { $this->generic_test('return.8'); }
    public function testReturn9()  { $this->generic_test('return.9'); }
    public function testReturn10()  { $this->generic_test('return.10'); }

}

?>