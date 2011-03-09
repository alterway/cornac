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

class Ext_Xdebug_Test extends Cornac_Tests_Auditeur
{
    public function testxdebug_functions()  {
        $this->expected = array( 
'xdebug_get_stack_depth',
'xdebug_get_function_stack',
'xdebug_print_function_stack',
'xdebug_get_declared_vars',
'xdebug_call_class',
'xdebug_call_function',
'xdebug_call_file',
'xdebug_call_line',
'xdebug_var_dump',
'xdebug_debug_zval',
'xdebug_debug_zval_stdout',
'xdebug_enable',
'xdebug_disable',
'xdebug_is_enabled',
'xdebug_break',
'xdebug_start_trace',
'xdebug_stop_trace',
'xdebug_get_tracefile_name',
'xdebug_get_profiler_filename',
'xdebug_dump_aggr_profiling_data',
'xdebug_clear_aggr_profiling_data',
'xdebug_memory_usage',
'xdebug_peak_memory_usage',
'xdebug_time_index',
'xdebug_start_code_coverage',
'xdebug_stop_code_coverage',
'xdebug_get_code_coverage',
'xdebug_get_function_count',
'xdebug_dump_superglobals',
);
        $this->unexpected = array(/*'',*/);

        parent::generic_test();
    }
}
?>