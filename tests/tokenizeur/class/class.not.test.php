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

class Not_Test extends Cornac_Tests_Tokenizeur
{
    /* 9 methodes */
    public function testNot1()  { $this->generic_test('not.1'); }
    public function testNot2()  { $this->generic_test('not.2'); }
    public function testNot3()  { $this->generic_test('not.3'); }
    public function testNot4()  { $this->generic_test('not.4'); }
    public function testNot5()  { $this->generic_test('not.5'); }
    public function testNot6()  { $this->generic_test('not.6'); }
    public function testNot7()  { $this->generic_test('not.7'); }
    public function testNot8()  { $this->generic_test('not.8'); }
    public function testNot9()  { $this->generic_test('not.9'); }

}

?>