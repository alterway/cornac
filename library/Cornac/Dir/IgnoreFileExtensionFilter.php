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
class Cornac_Dir_IgnoreFileExtensionFilter extends FilterIterator {
    public function accept() {
        global $INI;
        
        if (isset($INI['tokenizeur']['ignore_suffixe']) && !empty($INI['tokenizeur']['ignore_suffixe'])) {
            $regex_suffix = str_replace(',','|',  preg_quote($INI['tokenizeur']['ignore_suffixe']));
            $regex_suffix = '/('.$regex_suffix.')$/i';
            $regex_suffix = str_replace('.', '\\.', $regex_suffix);
        } else {
            $regex_suffix = explode(',', ".ini,.log,.exp,.CAB,.DLL,.JPG,.afm,.ai,.as3proj,.awk,.bak,.bat,.bdsgroup,.bdsproj,.bin,.bmp,.bpk,.bpr,.c,.cgi,.conf,.config,.cpp,.csproj,.css,.csv,.ctp,.darwin,.dat,.db,.dba,.default,.desc,.dia,.dist,.dll,.doc,.docx,.dtd,.eot,.exe,.ezt,.fla,.flv,.fre,.gem,.gif,.gz,.h,.hlp,.htm,.html,.icc,.ico,.in,.info,.jar,.java,.jpeg,.jpg,.js,.jsb,.launch,.lin,.linux,.lss,.manifest,.markdown,.md,.md5,.mno,.mo,.mp3,.mpg,.mso,.mwb,.mxml,.o,.odg,.odp,.odt,.old,.ott,.pas,.patch,.pcx,.pdf,.pfb,.pl,.png,.po,.ppt,.psd,.py,.rar,.rdf,.resx,.rng,.rss,.sample,.scc,.selenium,.sgml,.sh,.sit,.sitx,.so,.sql,.src,.svg,.swf,.swz,.sxd,.sxw,.table,.tar,.tex,.tga,.tif,.tiff,.ts,.ttf,.txt,.vsd,.war,.woff,.wsdl,.xad,.xap,.xcf,.xls,.xmi,.xml,.xsd,.xsl,.xslt,.xul,.yml,.z,.zip");
            $regex_suffix = '/('.join('|', $regex_suffix).')$/i';
            $regex_suffix = str_replace('.', '\\.', $regex_suffix);
        }
        
        return !preg_match($regex_suffix, $this->getInnerIterator()->key());
    }
}

?>