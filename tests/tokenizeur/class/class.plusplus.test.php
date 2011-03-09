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

class Plusplus_Test extends Cornac_Tests_Tokenizeur
{
    /* 16 methodes */
    public function testPlusplus1()  { $this->generic_test('plusplus.1'); }
    public function testPlusplus2()  { $this->generic_test('plusplus.2'); }
    public function testPlusplus3()  { $this->generic_test('plusplus.3'); }
    public function testPlusplus4()  { $this->generic_test('plusplus.4'); }
    public function testPlusplus5()  { $this->generic_test('plusplus.5'); }
    public function testPlusplus6()  { $this->generic_test('plusplus.6'); }
    public function testPlusplus7()  { $this->generic_test('plusplus.7'); }
    public function testPlusplus8()  { $this->generic_test('plusplus.8'); }
    public function testPlusplus9()  { $this->generic_test('plusplus.9'); }
    public function testPlusplus10()  { $this->generic_test('plusplus.10'); }
    public function testPlusplus11()  { $this->generic_test('plusplus.11'); }
    public function testPlusplus12()  { $this->generic_test('plusplus.12'); }
    public function testPlusplus13()  { $this->generic_test('plusplus.13'); }
    public function testPlusplus14()  { $this->generic_test('plusplus.14'); }
    public function testPlusplus15()  { $this->generic_test('plusplus.15'); }
    public function testPlusplus16()  { $this->generic_test('plusplus.16'); }

}

?>