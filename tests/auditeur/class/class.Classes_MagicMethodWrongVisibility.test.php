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

class Classes_MagicMethodWrongVisibility_Test extends Cornac_Tests_Auditeur
{
    public function testClasses_MagicMethodWrongVisibility()  {
        $this->expected = array( 
'x_private_static::__call',
'x_private_static::__get',
'x_private_static::__isset',
'x_private_static::__set',
'x_private_static::__unset',

'x_private::__call',
'x_private::__get',
'x_private::__isset',
'x_private::__set',
'x_private::__unset',

'x_protected_static::__call',
'x_protected_static::__get',
'x_protected_static::__isset',
'x_protected_static::__set',
'x_protected_static::__unset',

'x_protected::__call',
'x_protected::__get',
'x_protected::__isset',
'x_protected::__set',
'x_protected::__unset',

'x_static::__set', 
'x_static::__get', 
'x_static::__isset', 
'x_static::__unset', 
'x_static::__call'        
);

        $this->unexpected = array(
'x_public::__set',
'x_public::__get',
'x_public::__isset',
'x_public::__call',
'x_public::__unset',

'x_final::__set',
'x_final::__get',
'x_final::__isset',
'x_final::__call',
'x_final::__unset',
        );

        parent::generic_counted_test();
    }
}
?>