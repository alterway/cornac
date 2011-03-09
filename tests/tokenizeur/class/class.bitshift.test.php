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

class bitshift_Test extends Cornac_Tests_Tokenizeur
{
    /* 10 methodes */
    public function testbitshift1()  { $this->generic_test('bitshift.1'); }
    public function testbitshift2()  { $this->generic_test('bitshift.2'); }
    public function testbitshift3()  { $this->generic_test('bitshift.3'); }
    public function testbitshift4()  { $this->generic_test('bitshift.4'); }
    public function testbitshift5()  { $this->generic_test('bitshift.5'); }
    public function testbitshift6()  { $this->generic_test('bitshift.6'); }
    public function testbitshift7()  { $this->generic_test('bitshift.7'); }
    public function testbitshift8()  { $this->generic_test('bitshift.8'); }
    public function testbitshift9()  { $this->generic_test('bitshift.9'); }
    public function testbitshift10()  { $this->generic_test('bitshift.10'); }

}

?>