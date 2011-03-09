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
include('../../libs/path_normaliser.php');
require_once 'PHPUnit/Framework.php'; 


class Path_Normalizer_Framework_TestCase  extends PHPUnit_Framework_TestCase {
    function __construct() {
    }
    
    function testAll() {
        $valeurs = array(',init.php' => 'init.php',
                         'a,../init.php' => 'init.php',
                         'a,init.php' => 'a/init.php',
                         'a/b,init.php' => 'a/b/init.php',
                         'a/b,../init.php' => 'a/init.php',
                         'a/b,../../init.php' => 'init.php',
                         'ManyWebServices/ManyWebServices.php,ManyWebServices/nusoap/nusoap.php' => 'ManyWebServices/nusoap/nusoap.php',
                         
                         );
        
        
        foreach($valeurs as $args => $wanted) {
            list($root, $path) = explode(',', $args); 
            
            $normalised = path_normaliser($root, $path);
            
            $this->assertEquals($normalised, $wanted);
        }
    }
    
}

?>