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

class myclasse {
    public $public_defined_inited = 1;
    protected $protected_defined_inited = 2;
    private $private_defined_inited = 3;
    var $var_defined_inited = 4;

    public $public_defined_inited_unused = 1;
    protected $protected_defined_inited_unused = 2;
    private $private_defined_inited_unused = 3;
    var $var_defined_inited_unused = 4;

    function methode($arg_for_methode) {
        $this->public_defined_inited++;
        $this->protected_defined_inited++;
        $this->private_defined_inited++;
        $this->var_defined_inited++;
    }
}

?>