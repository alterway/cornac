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
    var $a;
    var $b = 2;
    var $c, $d;

    public $e;
    public $f;
    public $g, $h;
    public $i = 3;

    private $j;
    private $k;
    private $l, $m;
    private $n = 4;

    protected $o;
    protected $p;
    protected $q, $r;
    protected $s = 5;

    public static $es;
    public static $fs;
    public static $gs, $hs;
    public static $is = 6;

    static public $se;
    static public $sf;
    static public $sg, $sh;
    static public $si = 7;
    
    function __construct($arg) {
        $local = 1;
    }
}

class y extends x {
    var $ya;
    public $ye;
}

?>