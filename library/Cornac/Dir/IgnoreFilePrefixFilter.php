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
class Cornac_Dir_IgnoreFilePrefixFilter extends FilterIterator {
    public function accept() {
        global $INI;
        
        if (isset($INI['tokenizeur']['ignore_prefixe']) && !empty($INI['tokenizeur']['ignore_prefixe'])) {
            $regex_prefix = str_replace(',','|',  preg_quote($INI['tokenizeur']['ignore_prefixe']));
            $regex_prefix = '/('.$regex_prefix.')$/';
        } else {
        // @doc no default values;
            return true; 
        }        
        
        return !preg_match($regex_prefix, $this->getInnerIterator()->key());
    }
}

?>