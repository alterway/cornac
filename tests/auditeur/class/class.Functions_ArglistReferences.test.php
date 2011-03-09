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

class Functions_ArglistReferences_Test extends Cornac_Tests_Auditeur
{
    public function testfunction_args_reference()  {
        $this->expected = array( 
'::function_one_reference',
'::function_two_references',
'::function_two_references_b',
'::function_two_references_c',
'x::method_one_reference',
'x::method_two_references',
'x::method_two_references_b',
'x::method_two_references_c',

        );
        $this->unexpected = array(
'::function_no_reference',
'x::method_no_reference',
);

        parent::generic_test();
//        parent::generic_counted_test();
    }
}
?>