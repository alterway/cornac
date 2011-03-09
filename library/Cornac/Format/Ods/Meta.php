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

class Cornac_Format_Ods_Meta {
    private $meta;
    
    function __construct() {
        $this->meta = array(
            'creator' => '',
            'keyword' => 'PHP Cornac',
            'editing-cycles' => 1,
            'generator' => 'OOO_ODS for PHP (version 0.00a)',

        );
        $this->dc = array(
            'date' => date('r'),
            'description' => 'Inventory for an PHP application, by cornac.',
            'subject' => '',
            'title' => '',
        );
    }

    function setMeta($name, $value = null) {
        if (isset($this->meta[$name])) {
            $old = $this->meta[$name];
            if (!is_null($value)) {
                $this->meta[$name] = $value;
            }
            return $old;
        }
        if (isset($this->dc[$name])) {
            $old = $this->dc[$name];
            if (!is_null($value)) {
                $this->dc[$name] = $value;
            }
            return $old;
        }
        return false;
    }
    
    function asXML() {

        foreach($this->meta as $name => $value) {
            $this->meta[$name] = htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        }
        
        $date = date('r');
        $creator = 'OOO_ODS for PHP (version 0.00a)';
        $return = <<<XML
<office:document-meta xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:meta="urn:oasis:names:tc:opendocument:xmlns:meta:1.0" xmlns:ooo="http://openoffice.org/2004/office" xmlns:grddl="http://www.w3.org/2003/g/data-view#" office:version="1.2" grddl:transformation="http://docs.oasis-open.org/office/1.2/xslt/odf2rdf.xsl">
	<office:meta>
		<meta:initial-creator>
			{$this->meta['creator']}
		</meta:initial-creator>
		<meta:creation-date>
			$date
		</meta:creation-date>
XML;

        foreach($this->meta as $name => $value) {
            $return .= "        <meta:$name>$value</meta:$name>\n";
        }
        foreach($this->dc as $name => $value) {
            if (!empty($value)) {
                $return .= "        <dc:$name>$value</dc:$name>\n";
            }
        }
        
        $return .= <<<XML
		<dc:creator>
			{$this->meta['creator']}
		</dc:creator>
		<meta:editing-duration>
			PT00H04M17S
		</meta:editing-duration>
		<meta:document-statistic meta:table-count="3" meta:cell-count="2" meta:object-count="0" />
	</office:meta>
</office:document-meta>
XML;
        return $return;
    }
}

?>