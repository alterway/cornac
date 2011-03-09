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
class Cornac_Dir_IgnoreDirsFilter extends FilterIterator {
    public function accept() {
        global $INI;
        
       $ignore_dirs = array( 'cgi-bin', '.', '..',
                             'CVS','.svn','.git','.hg', '.bzr', // @todo : mercurial? other vcs's special folder : please add 
                             'adodb','fpdf','fckeditor','incutio','lightbox','nusoap','odtphp','pear','phpthumb','phputf8','scriptaculous','simpletest','smarty','spyc','tiny_mce','tinymce'); 

        if (isset($INI['tokenizeur']['ignore_dirs']) && !empty($INI['tokenizeur']['ignore_dirs'])) {
            $ignore_dirs = array_merge($ignore_dirs, explode(',',$INI['tokenizeur']['ignore_dirs']));
        } else {
        // @emptyelse
        }      

        $ignore_dirs = array_map('preg_quote', $ignore_dirs);
        $regex = '#/('.join('|',$ignore_dirs).')/#';

// @todo use splinfo!
        return !preg_match($regex, $this->getInnerIterator()->key());
    }
}

?>