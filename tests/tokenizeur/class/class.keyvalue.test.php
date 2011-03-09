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

class keyvalue_Test extends Cornac_Tests_Tokenizeur
{
    /* 9 methodes */
    public function testkeyvalue1()  { $this->generic_test('keyvalue.1'); }
    public function testkeyvalue2()  { $this->generic_test('keyvalue.2'); }
    public function testkeyvalue3()  { $this->generic_test('keyvalue.3'); }
    public function testkeyvalue4()  { $this->generic_test('keyvalue.4'); }
    public function testkeyvalue5()  { $this->generic_test('keyvalue.5'); }
    public function testkeyvalue6()  { $this->generic_test('keyvalue.6'); }
    public function testkeyvalue7()  { $this->generic_test('keyvalue.7'); }
    public function testkeyvalue8()  { $this->generic_test('keyvalue.8'); }
    public function testkeyvalue9()  { $this->generic_test('keyvalue.9'); }

}

?>