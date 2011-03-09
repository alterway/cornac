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

class Classes_MethodsWithoutPpp_Test extends Cornac_Tests_Auditeur
{
    function  testmethod_without_ppp()  {
        $this->expected = array( 
'method_without_ppp',
'static_method_without_ppp',
'final_method_without_ppp',
);
        $this->unexpected = array(
'method_with_private',
'static_method_with_private',
'final_method_with_private',
'static_method_with_private2',
'final_method_with_private2',
'method_with_protected',
'static_method_with_protected',
'final_method_with_protected',
'static_method_with_protected2',
'final_method_with_protected2',
'on method_with_public',
'static_method_with_public',
'final_method_with_public',
'static_method_with_public2',
'final_method_with_public2',
        );

        parent::generic_test();
    }
}
?>