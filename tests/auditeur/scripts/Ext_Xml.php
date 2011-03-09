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

xml_parser_create();
xml_parser_create_ns();
xml_set_object();
xml_set_element_handler();
xml_set_character_data_handler();
xml_set_processing_instruction_handler();
xml_set_default_handler();
xml_set_unparsed_entity_decl_handler();
xml_set_notation_decl_handler();
xml_set_external_entity_ref_handler();
xml_set_start_namespace_decl_handler();
xml_set_end_namespace_decl_handler();
xml_parse();
xml_parse_into_struct();
xml_get_error_code();
xml_error_string();
xml_get_current_line_number();
xml_get_current_column_number();
xml_get_current_byte_index();
xml_parser_free();
xml_parser_set_option();
xml_parser_get_option();
utf8_encode();
utf8_decode();

?>