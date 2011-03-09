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

class Ext_Mssql_Test extends Cornac_Tests_Auditeur
{
    public function testmssql_functions()  {
        $this->expected = array( 
'mssql_bind',
'mssql_close',
'mssql_connect',
'mssql_data_seek',
'mssql_execute',
'mssql_fetch_array',
'mssql_fetch_assoc',
'mssql_fetch_batch',
'mssql_fetch_field',
'mssql_fetch_object',
'mssql_fetch_row',
'mssql_field_length',
'mssql_field_name',
'mssql_field_seek',
'mssql_field_type',
'mssql_free_result',
'mssql_free_statement',
'mssql_get_last_message',
'mssql_guid_string',
'mssql_init',
'mssql_min_error_severity',
'mssql_min_message_severity',
'mssql_next_result',
'mssql_num_fields',
'mssql_num_rows',
'mssql_pconnect',
'mssql_query',
'mssql_result',
'mssql_rows_affected',
'mssql_select_db',);
        $this->unexpected = array(/*'',*/);

        parent::generic_test();
    }
}
?>