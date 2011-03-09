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

abstract class abstract_class {
    
    public function real_method() {}
    
    public abstract function public_abstract_method();
    abstract public function abstract_public_method();

    protected abstract function protected_abstract_method();    
    abstract protected function abstract_protected_method();

    public static abstract function public_static_abstract_method();
    public abstract static function public_abstract_static_method();
    abstract public static function abstract_public_static_method();

    protected static abstract function protected_static_abstract_method();
    protected abstract static function protected_abstract_static_method();
    abstract protected static function abstract_protected_static_method();
}


?>