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

class Structures_AffectationsVariables_Test extends Cornac_Tests_Auditeur
{
    public function testVariables()  { 
        $this->expected = array('$a','$b',
                                '$c','$d',
                                '$e','$g',
                                '$j','$objet->propriete',
                                '$statique','$k',
                                '$l','$m',
                                '$fe_key',
                                '$fe_value','$fe_value2',
                                );
        $this->unexpected = array('$e','$h','$i',
                                  'propriete','$fe_array',
                                  '$fe_array2','$fe_array3',
                                  '$fe_key3',);
        parent::generic_test();
    }
}

?>