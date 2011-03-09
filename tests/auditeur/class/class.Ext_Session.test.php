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

class Ext_Session_Test extends Cornac_Tests_Auditeur
{
    public function testsession_functions()  {
        $this->expected = array( 
'session_name',
'session_module_name',
'session_save_path',
'session_id',
'session_regenerate_id',
'session_decode',
'session_register',
'session_unregister',
'session_is_registered',
'session_encode',
'session_start',
'session_destroy',
'session_unset',
'session_set_save_handler',
'session_cache_limiter',
'session_cache_expire',
'session_set_cookie_params',
'session_get_cookie_params',
'session_write_close',
'session_commit',
        );
        $this->unexpected = array(/*'',*/);

        parent::generic_test();
    }
}
?>