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

class Functions_Security_Test extends Cornac_Tests_Auditeur
{
    public function testsecu_protection_functions()  {
        $this->expected = array( 'addcslashes', 'ctype_alpha', 'ctype_cntrl', 'ctype_digit', 'ctype_graph', 'ctype_lower', 'ctype_print', 'ctype_punct', 'ctype_space', 'ctype_upper', 'ctype_xdigit', 'filter_input', 'filter_var', 'html_entity_decode', 'htmlspecialchars', 'is_double', 'is_executable', 'is_file', 'is_int', 'is_link', 'is_writeable', 'md5_file', 'mysql_real_escape_string', 'mysqli_bind_param', 'pg_escape_bytea', 'rawurlencode', 'sha1_file', 'addslashes', 'checkdate', 'ctype_alnum', 'escapeshellarg', 'escapeshellcmd', 'filter_input_array', 'filter_var_array', 'getimagesize', 'hash_file', 'htmlentities', 'htmlspecialchars_decode', 'ip2long', 'is_bool', 'is_dir', 'is_numeric', 'is_readable', 'is_uploaded_file', 'mysql_escape_string', 'mysqli_bind_result', 'mysqli_real_escape_string', 'pg_escape_string', 'preg_quote', 'quotemeta', 'realpath', 'sqlite_escape_string', 'strip_tags', 'strtotime', 'urlencode');
        // @todo 'pdo->quote', add this
        $this->unexpected = array(/*'',*/);

        parent::generic_test();
    }
}
?>