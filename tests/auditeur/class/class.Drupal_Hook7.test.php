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

class Drupal_Hook7_Test extends Cornac_Tests_Auditeur
{
    public function testDrupal_Hook7()  {
        $this->expected = array( 'hoook_forms', 'hoook_help', 'hoook_info', 'hoook_info_alter', 'hoook_alter_info', 'drupal_other_hook_info');
        $this->unexpected = array('hoook_non_drupal_suffix' );

        parent::generic_test();
    }
}
?>