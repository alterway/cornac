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

final class final_class {
    
    public function real_method() {}
    
    public final function public_final_method() {}
    final public function final_public_method() {}

    protected final function protected_final_method() {}    
    final protected function final_protected_method() {}

    public static final function public_static_final_method() {}
    public final static function public_final_static_method() {}
    final public static function final_public_static_method() {}

    protected static final function protected_static_final_method() {}
    protected final static function protected_final_static_method() {}
    final protected static function final_protected_static_method() {}
}

?>