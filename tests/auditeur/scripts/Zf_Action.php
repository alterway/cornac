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

class ZF_controller extends Zend_Controller {
    function __construct() {}
    
    function realAction() {}
    
    private function staticrealAction() {}
    
    public function notarealactions() {}    
}

class ZF_Not_controller extends Zend_Auth {
    function __construct() {}
    
    public function notzfaction() {}    

    public function notarealactionanyway() {}    
}

class ZF_Not_extends implements Zend_Dummy {
    function __construct() {}
    
    public function notzfiaction() {}    

    public function notairealactionanyway() {}    
}


?>