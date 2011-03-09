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

class Cast_Test extends Cornac_Tests_Tokenizeur
{
    /* 15 methodes */
    public function testCast1()  { $this->generic_test('cast.1'); }
    public function testCast2()  { $this->generic_test('cast.2'); }
    public function testCast3()  { $this->generic_test('cast.3'); }
    public function testCast4()  { $this->generic_test('cast.4'); }
    public function testCast5()  { $this->generic_test('cast.5'); }
    public function testCast6()  { $this->generic_test('cast.6'); }
    public function testCast7()  { $this->generic_test('cast.7'); }
    public function testCast8()  { $this->generic_test('cast.8'); }
    public function testCast9()  { $this->generic_test('cast.9'); }
    public function testCast10()  { $this->generic_test('cast.10'); }
    public function testCast11()  { $this->generic_test('cast.11'); }
    public function testCast12()  { $this->generic_test('cast.12'); }
    public function testCast13()  { $this->generic_test('cast.13'); }
    public function testCast14()  { $this->generic_test('cast.14'); }
    public function testCast15()  { $this->generic_test('cast.15'); }

}

?>