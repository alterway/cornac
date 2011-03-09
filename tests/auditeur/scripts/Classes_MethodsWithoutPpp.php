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

class x {
    
    function method_without_ppp() {}
    static function static_method_without_ppp() {}
    final function final_method_without_ppp() {}

    private function method_with_private() {}
    static private  function static_method_with_private() {}
    final private function final_method_with_private() {}
    private static function static_method_with_private2() {}
    private final function final_method_with_private2() {}

    protected function method_with_protected() {}
    static protected  function static_method_with_protected() {}
    final protected function final_method_with_protected() {}
    protected static function static_method_with_protected2() {}
    protected final function final_method_with_protected2() {}

    public function method_with_public() {}
    static public  function static_method_with_public() {}
    final public function final_method_with_public() {}
    public static function static_method_with_public2() {}
    public final function final_method_with_public2() {}
}


?>