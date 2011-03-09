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
require_once 'PHPUnit/Framework.php'; 

global $url_site;
$url_site = "http://localhost/~alterway/auditeur/index.php";

class web_Test extends PhpUnit_Framework_TestCase
{

    public function test_index()  { 
        global $url_site;
        
        $url = $url_site."";
        $html = file_get_contents($url_site."");

        $this->generic_test($url);
    }

    public function test_views_index()  { 
        global $url_site;
        
        $views = array(
                       'occurrences-frequency',
                       'files-occurrences',
                       'classes-occurrences',
                       'methods-occurrences',
                       'occurrences-fichiers',
                       'occurrences-classes',
                       'occurrences-methods',
                       'undefined',
                       
                       );
        
        foreach($views as $view) {
            $url = $url_site.'?module=arglist_disc&type='.$view;
            $html = file_get_contents($url);
            
            $this->checkForReturn($html, $url);
            $this->checkForPHPerror($html, $url);
            
            $formats = array('json','xml','png','text'); 
            foreach($formats as $format) {
                $url_format = $url.'&format='.$format;
                $this->generic_test($url);
            }
        }
    }

    public function test_modules_index()  { 
        global $url_site;
        
        $modules = array(
'zfAction',
'iffectations',
'arglist_disc',
'functionscalls',
'arglist_def',
'unused_args',
'arglist_call',
'affectations_direct_gpc',
'gpc_affectations',
'affectations_literals',
'html_tags',
'popular_libraries',
'block_of_call',
'nestedloops',
'inclusions_path',
'classes',
'php_classes',
'zfClasses',
'classes_unused',
'classes_undefined',
'dangerous_combinaisons',
'concatenation_gpc',
'defconstantes',
'constantes',
'constantes_classes',
'zfController',
'dieexit',
'doubledefclass',
'deffunctions',
'defmethodes',
'doubledeffunctions',
'zfElements',
'evals',
'thrown',
'php_modules',
'multi_def_files',
'ldap_functions',
'mssql_functions',
'xml_functions',
'error_functions',
'image_functions',
'upload_functions',
'dir_functions',
'file_functions',
'filter_functions',
'exec_functions',
'mysql_functions',
'mysqli_functions',
'session_functions',
'secu_functions',
'secu_protection_functions',
'ereg_functions',
'execs',
'undeffunctions',
'functions_unused',
'functions_without_returns',
'emptyfunctions',
'xdebug_functions',
'functions_frequency',
'globals',
'headers',
'classes_hierarchie',
'nestedif',
'ifsanselse',
'inclusions',
'indenting',
'interfaces',
'function_link',
'constantes_link',
'variables_relations',
'php_functions',
'defarray',
'literals_long',
'literals_reused',
'literals',
'variables_lots_of_letter',
'methodscall',
'method_special',
'_new',
'classes_nb_methods',
'parentheses',
'properties_defined',
'undefined_properties',
'unused_properties',
'proprietes_publiques',
'properties_used',
'references',
'regex',
'sql_queries',
'returns',
'inclusions2',
'globals_link',
'statiques',
'gpc',
'tableaux',
'tableaux_gpc_seuls',
'tableaux_gpc',
'multidimarray',
'mvc',
'arobases',
'_this',
'vardump',
'variables',
'gpc_variables',
'affectations_variables',
'variables_one_letter',
'session_variables',
'variables_unaffected',
'foreach_unused',
'variablesvariables',
'zfGetGPC',
'addElement_unaffected',
'addElement',
);
        
        foreach($modules as $module) {
            $url = $url_site."?module=".$module;
            $this->generic_test($url);
        }
    }
    
    private function generic_test($url) {
        $opts = array(
          'http'=>array(
            'max_redirects'=>"0"
          )
        );
        $context = stream_context_create($opts);

        $html = @file_get_contents($url, false, $context);
        
        $this->checkForReturn($html, $url);
        $this->checkForPHPerror($html, $url);
        
        return $html;
    }

    private function checkForPHPerror($html, $url) {
        $tests = array('Notice: Undefined index:',
                       'Notice: Undefined variable:',
                       ' error ',
//                       'SELECT', // @doc case of sql debug
//                       'select',
                       );
        foreach($tests as $test) {
            $this->assertNotContains($test, $html, "Found $test in $url");
        }
    }
    
    private function checkForReturn($html, $url) {
        $this->assertFalse(strlen($html) == 0, "$url brought back an empty page, or a redirect.");
        
        $tests = array('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">',
                       '</html>',
                       'utf-8',
                       );
        foreach($tests as $test) {
            $this->assertContains($test,$html, "Found $test in $url");
        }
        
        return true;
    }
}
?>