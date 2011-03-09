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

class Cornac_Format_Ods_Style {
    private $name = '';
    private $family = 'table-cell';
    private $parent_style = '';
    private $properties = '';
    
    
    function __construct($name, $family='table-cell', $parent_style='Default') {
        $this->name = $name;
        $this->setFamily($family);
        $this->setParentStyle($parent_style);
    }
    
    function setFamily($family = 'table-cell') {
        if (!in_array($family, array('table-cell','table-row','table-column','table'))) { return false; }
        $old = $this->family;
        $this->family = $family;
        return $old;
    }

    function setParentStyle($parent_style = 'Default') {
        //@todo : check? 
        $old = $this->parent_style;
        $this->parent_style = $parent_style;
        return $old;
    }

    function setProperties($properties = null) {
        if (is_null($properties)) { return $this->properties; }
        
        foreach($properties as $name => $value) {
            $this->properties[$name] = $value;
        }
        return true;
    }

    function asXML() {
        $properties = '';
        foreach($this->properties as $name => $value) {
            $properties .= "$name=\"$value\" ";
        }
        
        $style_tag = $this->family.'-properties';
        if ($this->family == 'table') {
            if (is_null($this->parent_style)) {
                $parent_style = "";
            } else {
                $parent_style = "style:master-page-name=\"{$this->parent_style}\"";
            }
            
        } elseif ($this->family == 'table-cell') {
            $parent_style = "style:parent-style-name=\"{$this->parent_style}\"";
            $style_tag = 'text-properties';
        } else {
            $parent_style = '';
        }
        
        return     <<<XML
		<style:style style:name="{$this->name}" style:family="{$this->family}" $parent_style>
			<style:$style_tag $properties />
		</style:style>
XML;

/*

		<style:style style:name="co1" style:family="table-column" >
			<style:table-column-properties fo:break-before="auto" style:column-width="2.267cm"  />
		</style:style>
		<style:style style:name="ro1" style:family="table-row" >
			<style:table-row-properties style:row-height="0.45cm" fo:break-before="auto" style:use-optimal-row-height="true"  />
		</style:style>
		<style:style style:name="ro2" style:family="table-row" >
			<style:table-row-properties style:row-height="0.427cm" fo:break-before="auto" style:use-optimal-row-height="true"  />
		</style:style>
		<style:style style:name="ta1" style:family="table" style:master-page-name="Default">
			<style:table-properties table:display="true" style:writing-mode="lr-tb"  />
		</style:style>
		<style:style style:name="ce1" style:family="table-cell" style:parent-style-name="Default">
			<style:text-properties fo:font-weight="bold" style:font-weight-asian="bold" style:font-weight-complex="bold"  />
		</style:style>
		<style:style style:name="ta_extref" style:family="table" style:master-page-name="Default">
			<style:table-properties table:display="false"  />
		</style:style>


 
<style:style style:name="co1" style:family="table-column">
	<style:table-column-properties fo:break-before="auto" style:column-width="2.267cm" />
</style:style>
<style:style style:name="ro1" style:family="table-row">
	<style:table-row-properties style:row-height="0.45cm" fo:break-before="auto" style:use-optimal-row-height="true" />
</style:style>
<style:style style:name="ro2" style:family="table-row">
	<style:table-row-properties style:row-height="0.427cm" fo:break-before="auto" style:use-optimal-row-height="true" />
</style:style>
<style:style style:name="ta1" style:family="table" style:master-page-name="Default">
	<style:table-properties table:display="true" style:writing-mode="lr-tb" />
</style:style>
<style:style style:name="ce1" style:family="table-cell" style:parent-style-name="Default">
	<style:table-cell-properties fo:font-weight="bold" style:font-weight-asian="bold" style:font-weight-complex="bold" />
</style:style>
<style:style style:name="ta_extref" style:family="table" style:master-page-name="Default">
	<style:table-properties table:display="false" />
</style:style>

*/
    }
}

?>