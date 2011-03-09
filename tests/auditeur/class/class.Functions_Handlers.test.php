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

class Functions_Handlers_Test extends Cornac_Tests_Auditeur
{
    public function testhandlers()  { 
        $this->expected = array( 
                                'register_tick_function',
                                'register_shutdown_function',
                                'unregister_tick_function',
                                'xpath_register_ns',
                                'xpath_register_ns_auto',
                                'w32api_register_function',
                                'stream_register_wrapper',
                                'session_register',
                                'session_unregister',
                                'spl_autoload_register',
                                'stream_filter_register',
                                'xmlrpc_server_register_introspection_callback',
                                'xmlrpc_server_register_method',
                                'stream_wrapper_register',
                                'spl_autoload_unregister',
                                'stream_wrapper_unregister',
                                'http_request_method_register',
                                'http_request_method_unregister',
                               );
        $this->unexpected = array();
        
        parent::generic_test();
    }
}
?>