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

class Cornac_Format_Ods {
    // @todo move this to private! 
    private $cells = array();
    private $styles = array();
    private $ods_styles = array();
    
    private $meta = null;
    
    function __construct() {
        $this->meta = new Cornac_Format_Ods_Meta();
        
        $style = new Cornac_Format_Ods_Style('co1', 'table-column');
        $style->setProperties(array( 'fo:break-before'=> "auto",
                                     'style:column-width' => "2.267cm"));
        $this->ods_styles[] = $style;

        $style = new Cornac_Format_Ods_Style('ro1', 'table-row');
        $style->setProperties(array( 'style:row-height' => "0.45cm",
                                     'fo:break-before' => "auto",
                                     'style:use-optimal-row-height' => "true"));
        $this->ods_styles[] = $style;

        $style = new Cornac_Format_Ods_Style('ro2', 'table-row');
        $style->setProperties(array('style:row-height' => "0.427cm",
                                    'fo:break-before' => "auto",
                                    'style:use-optimal-row-height' => "true"));
        $this->ods_styles[] = $style;

        $style = new Cornac_Format_Ods_Style('ta1', 'table', "Default");
        $style->setProperties(array( "table:display" => "true",
                                     "style:writing-mode" => "lr-tb"));
        $this->ods_styles[] = $style;

        $style = new Cornac_Format_Ods_Style('ce1', 'table-cell', "Default");
        $style->setProperties(array( 'fo:font-weight' => "bold",
                                     'style:font-weight-asian' => "bold",
                                     'style:font-weight-complex' => "bold"));
        $this->ods_styles[] = $style;

        $style = new Cornac_Format_Ods_Style('ta_extref', 'table', null);
        $style->setProperties(array( 'table:display' => "false"));
        $this->ods_styles[] = $style;
 }
    
    function protect($text) {
        $in = array("\t");
        $out = array('<text:tab />');
    
        return $text;
    }

    function setCell($table, $row, $col, $content) {
        $this->cells[$table][$row][$col] = $content;
    }

    function setRow($table, $row, $array) {
        if (isset($this->cells[$table][$row])) {
            $this->cells[$table][$row] = array_merge($this->cells[$table][$row], $array);
        } else {
            $this->cells[$table][$row] =  $array;
        }
    }

    function setCol($table, $col, $array) {
        if (count($array) == 0) { return true; }
        foreach($array as $row => $cols) {
            $this->cells[$table][$row][$col] = $array[$row];
        }
        return true;
    }

// @doc set style for the cell
    function setCellStyle($table, $row, $col, $style) {
        $this->styles[$table][$row][$col] = $style;
    }

// @doc set style for the cells of the whole row
    function setRowCellsStyle($table, $row, $style) {
        if (!isset($this->cells[$table][$row])) { return false; }
        if (!is_array($this->cells[$table][$row])) { return false; }

        foreach($this->cells[$table] as $row_id => $cols) {
            $cols = array_keys($cols);
            foreach($cols as $col) {
                $this->styles[$table][$row][$col] = $style;
            }
        }
        return true;
    }

// @doc set style for the cells of the whole column
    function setColCellsStyle($table, $col, $style) {
        foreach($this->cells as $row => $cols) {
            if (isset($this->cells[$table][$row][$col])) {
                $this->styles[$table][$row][$col] = $style;
            }
        }
        return true;
    }

// @doc set style for the row
    function setRowStyle($table, $row, $style) {
        $this->styles_row[$table][$row] = $style;
        return true;
    }

// @doc set style for the col
    function setColStyle($table, $col, $style) {
        $this->styles_col[$table][$col] = $style;
        return true;
    }

    function save($filename = null) {
        $zip = new ZipArchive();

        if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
            die("cannot open <$filename>\n");
        }
        
        $this->ods_structure($zip);
        $zip->addFromString("content.xml", $this->asXML());

        return $zip->close();
    }
    
    function asXML() {
        $styles = "	<office:automatic-styles>\n";
        foreach($this->ods_styles as $style) {
            $styles .= $style->asXML()."\n";
        }
        $styles .= "	</office:automatic-styles>\n";
        
        $skel_xml = '<?xml version="1.0" encoding="UTF-8"?>
<office:document-content xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0" xmlns:fo="urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:meta="urn:oasis:names:tc:opendocument:xmlns:meta:1.0" xmlns:number="urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0" xmlns:presentation="urn:oasis:names:tc:opendocument:xmlns:presentation:1.0" xmlns:svg="urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0" xmlns:chart="urn:oasis:names:tc:opendocument:xmlns:chart:1.0" xmlns:dr3d="urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0" xmlns:math="http://www.w3.org/1998/Math/MathML" xmlns:form="urn:oasis:names:tc:opendocument:xmlns:form:1.0" xmlns:script="urn:oasis:names:tc:opendocument:xmlns:script:1.0" xmlns:ooo="http://openoffice.org/2004/office" xmlns:ooow="http://openoffice.org/2004/writer" xmlns:oooc="http://openoffice.org/2004/calc" xmlns:dom="http://www.w3.org/2001/xml-events" xmlns:xforms="http://www.w3.org/2002/xforms" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:rpt="http://openoffice.org/2005/report" xmlns:of="urn:oasis:names:tc:opendocument:xmlns:of:1.2" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:grddl="http://www.w3.org/2003/g/data-view#" xmlns:field="urn:openoffice:names:experimental:ooo-ms-interop:xmlns:field:1.0" office:version="1.2" grddl:transformation="http://docs.oasis-open.org/office/1.2/xslt/odf2rdf.xsl">
	<office:scripts />
	<office:font-face-decls>
		<style:font-face style:name="Arial" svg:font-family="Arial" style:font-family-generic="swiss" style:font-pitch="variable" />
		<style:font-face style:name="Arial Unicode MS" svg:font-family="&apos;Arial Unicode MS&apos;" style:font-family-generic="system" style:font-pitch="variable" />
		<style:font-face style:name="Lucida Sans" svg:font-family="&apos;Lucida Sans&apos;" style:font-family-generic="system" style:font-pitch="variable" />
		<style:font-face style:name="Tahoma" svg:font-family="Tahoma" style:font-family-generic="system" style:font-pitch="variable" />
	</office:font-face-decls>
	'.$styles.'
	<office:body>
		<office:spreadsheet>
		    <tables>
		</office:spreadsheet>
	</office:body>
</office:document-content>
';
        $tables_xml = '';
        
        foreach($this->cells as $name => $tables) {
            $rows_xml = '';
            
            foreach($tables as $row => $cols) {
                if ($row == 0) { continue; } // no use for row 0 
                $cols_xml = '';
            
                foreach($cols as $col => $cell) {
                    if ($col == 0) { continue; } // no use for row 0 
                    
                    // @rfu : date, time, percentage, float, number, string. (Add a 'guess' case)
                    if (intval($cell)) {
                        $type = "number";
                    } else {
                        $type = "string";
                    }

                    $cell = $this->protect($cell);
                    if (isset($this->styles[$name][$row][$col])) {
                        $style = ' table:style-name="'.$this->styles[$name][$row][$col].'"';
                    } else {
                        $style = '';
                    }
                    
                    $cols_xml .= <<<XML
					<table:table-cell$style office:value-type="string">
						<text:p>{$cell}</text:p>
					</table:table-cell>
XML;
                }

            $rows_xml .= <<<XML
				<table:table-row table:style-name="ro1">
				    $cols_xml
				</table:table-row>
XML;
            }
            $tables_xml .= <<<XML
			<table:table table:name="{$name}" table:style-name="ta1" table:print="false">
				<table:table-column table:style-name="co1" table:number-columns-repeated="2" table:default-cell-style-name="Default" />
				$rows_xml
			</table:table>
XML;
        } 
        
        return $this->content =  str_replace('<tables>',$tables_xml,$skel_xml);
    }
    
    function ods_structure($zip) {
    // meta.xml

    $meta = $this->meta->asXML();
    $zip->addFromString("meta.xml", '<?xml version="1.0" encoding="UTF-8"?'.">\n".$meta);
    
    $settings = <<<'XML'
<office:document-settings xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:config="urn:oasis:names:tc:opendocument:xmlns:config:1.0" xmlns:ooo="http://openoffice.org/2004/office" office:version="1.2"><office:settings><config:config-item-set config:name="ooo:view-settings"><config:config-item config:name="VisibleAreaTop" config:type="int">0</config:config-item><config:config-item config:name="VisibleAreaLeft" config:type="int">0</config:config-item><config:config-item config:name="VisibleAreaWidth" config:type="int">4516</config:config-item><config:config-item config:name="VisibleAreaHeight" config:type="int">448</config:config-item><config:config-item-map-indexed config:name="Views"><config:config-item-map-entry><config:config-item config:name="ViewId" config:type="string">View1</config:config-item><config:config-item-map-named config:name="Tables"><config:config-item-map-entry config:name="Feuille1"><config:config-item config:name="CursorPositionX" config:type="int">2</config:config-item><config:config-item config:name="CursorPositionY" config:type="int">1</config:config-item><config:config-item config:name="HorizontalSplitMode" config:type="short">0</config:config-item><config:config-item config:name="VerticalSplitMode" config:type="short">0</config:config-item><config:config-item config:name="HorizontalSplitPosition" config:type="int">0</config:config-item><config:config-item config:name="VerticalSplitPosition" config:type="int">0</config:config-item><config:config-item config:name="ActiveSplitRange" config:type="short">2</config:config-item><config:config-item config:name="PositionLeft" config:type="int">0</config:config-item><config:config-item config:name="PositionRight" config:type="int">0</config:config-item><config:config-item config:name="PositionTop" config:type="int">0</config:config-item><config:config-item config:name="PositionBottom" config:type="int">0</config:config-item><config:config-item config:name="ZoomType" config:type="short">0</config:config-item><config:config-item config:name="ZoomValue" config:type="int">180</config:config-item><config:config-item config:name="PageViewZoomValue" config:type="int">60</config:config-item></config:config-item-map-entry></config:config-item-map-named><config:config-item config:name="ActiveTable" config:type="string">Feuille1</config:config-item><config:config-item config:name="HorizontalScrollbarWidth" config:type="int">270</config:config-item><config:config-item config:name="ZoomType" config:type="short">0</config:config-item><config:config-item config:name="ZoomValue" config:type="int">180</config:config-item><config:config-item config:name="PageViewZoomValue" config:type="int">60</config:config-item><config:config-item config:name="ShowPageBreakPreview" config:type="boolean">false</config:config-item><config:config-item config:name="ShowZeroValues" config:type="boolean">true</config:config-item><config:config-item config:name="ShowNotes" config:type="boolean">true</config:config-item><config:config-item config:name="ShowGrid" config:type="boolean">true</config:config-item><config:config-item config:name="GridColor" config:type="long">12632256</config:config-item><config:config-item config:name="ShowPageBreaks" config:type="boolean">true</config:config-item><config:config-item config:name="HasColumnRowHeaders" config:type="boolean">true</config:config-item><config:config-item config:name="HasSheetTabs" config:type="boolean">true</config:config-item><config:config-item config:name="IsOutlineSymbolsSet" config:type="boolean">true</config:config-item><config:config-item config:name="IsSnapToRaster" config:type="boolean">false</config:config-item><config:config-item config:name="RasterIsVisible" config:type="boolean">false</config:config-item><config:config-item config:name="RasterResolutionX" config:type="int">1000</config:config-item><config:config-item config:name="RasterResolutionY" config:type="int">1000</config:config-item><config:config-item config:name="RasterSubdivisionX" config:type="int">1</config:config-item><config:config-item config:name="RasterSubdivisionY" config:type="int">1</config:config-item><config:config-item config:name="IsRasterAxisSynchronized" config:type="boolean">true</config:config-item></config:config-item-map-entry></config:config-item-map-indexed></config:config-item-set><config:config-item-set config:name="ooo:configuration-settings"><config:config-item config:name="IsKernAsianPunctuation" config:type="boolean">false</config:config-item><config:config-item config:name="IsRasterAxisSynchronized" config:type="boolean">true</config:config-item><config:config-item config:name="LinkUpdateMode" config:type="short">3</config:config-item><config:config-item config:name="SaveVersionOnClose" config:type="boolean">false</config:config-item><config:config-item config:name="AllowPrintJobCancel" config:type="boolean">true</config:config-item><config:config-item config:name="HasSheetTabs" config:type="boolean">true</config:config-item><config:config-item config:name="ShowPageBreaks" config:type="boolean">true</config:config-item><config:config-item config:name="RasterResolutionX" config:type="int">1000</config:config-item><config:config-item config:name="PrinterSetup" config:type="base64Binary"/><config:config-item config:name="RasterResolutionY" config:type="int">1000</config:config-item><config:config-item config:name="LoadReadonly" config:type="boolean">false</config:config-item><config:config-item config:name="RasterSubdivisionX" config:type="int">1</config:config-item><config:config-item config:name="ShowNotes" config:type="boolean">true</config:config-item><config:config-item config:name="ShowZeroValues" config:type="boolean">true</config:config-item><config:config-item config:name="RasterSubdivisionY" config:type="int">1</config:config-item><config:config-item config:name="ApplyUserData" config:type="boolean">true</config:config-item><config:config-item config:name="GridColor" config:type="long">12632256</config:config-item><config:config-item config:name="RasterIsVisible" config:type="boolean">false</config:config-item><config:config-item config:name="IsSnapToRaster" config:type="boolean">false</config:config-item><config:config-item config:name="PrinterName" config:type="string"/><config:config-item config:name="ShowGrid" config:type="boolean">true</config:config-item><config:config-item config:name="CharacterCompressionType" config:type="short">0</config:config-item><config:config-item config:name="HasColumnRowHeaders" config:type="boolean">true</config:config-item><config:config-item config:name="IsOutlineSymbolsSet" config:type="boolean">true</config:config-item><config:config-item config:name="AutoCalculate" config:type="boolean">true</config:config-item><config:config-item config:name="IsDocumentShared" config:type="boolean">false</config:config-item><config:config-item config:name="UpdateFromTemplate" config:type="boolean">true</config:config-item></config:config-item-set></office:settings></office:document-settings>
XML;
    $zip->addFromString("settings.xml", '<?xml version="1.0" encoding="UTF-8"?'.">\n".$settings);

    $styles = <<<'XML'
<office:document-styles xmlns:office="urn:oasis:names:tc:opendocument:xmlns:office:1.0" xmlns:style="urn:oasis:names:tc:opendocument:xmlns:style:1.0" xmlns:text="urn:oasis:names:tc:opendocument:xmlns:text:1.0" xmlns:table="urn:oasis:names:tc:opendocument:xmlns:table:1.0" xmlns:draw="urn:oasis:names:tc:opendocument:xmlns:drawing:1.0" xmlns:fo="urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:meta="urn:oasis:names:tc:opendocument:xmlns:meta:1.0" xmlns:number="urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0" xmlns:presentation="urn:oasis:names:tc:opendocument:xmlns:presentation:1.0" xmlns:svg="urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0" xmlns:chart="urn:oasis:names:tc:opendocument:xmlns:chart:1.0" xmlns:dr3d="urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0" xmlns:math="http://www.w3.org/1998/Math/MathML" xmlns:form="urn:oasis:names:tc:opendocument:xmlns:form:1.0" xmlns:script="urn:oasis:names:tc:opendocument:xmlns:script:1.0" xmlns:ooo="http://openoffice.org/2004/office" xmlns:ooow="http://openoffice.org/2004/writer" xmlns:oooc="http://openoffice.org/2004/calc" xmlns:dom="http://www.w3.org/2001/xml-events" xmlns:rpt="http://openoffice.org/2005/report" xmlns:of="urn:oasis:names:tc:opendocument:xmlns:of:1.2" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:grddl="http://www.w3.org/2003/g/data-view#" office:version="1.2" grddl:transformation="http://docs.oasis-open.org/office/1.2/xslt/odf2rdf.xsl"><office:font-face-decls><style:font-face style:name="Arial" svg:font-family="Arial" style:font-family-generic="swiss" style:font-pitch="variable"/><style:font-face style:name="Arial Unicode MS" svg:font-family="&apos;Arial Unicode MS&apos;" style:font-family-generic="system" style:font-pitch="variable"/><style:font-face style:name="Lucida Sans" svg:font-family="&apos;Lucida Sans&apos;" style:font-family-generic="system" style:font-pitch="variable"/><style:font-face style:name="Tahoma" svg:font-family="Tahoma" style:font-family-generic="system" style:font-pitch="variable"/></office:font-face-decls><office:styles><style:default-style style:family="table-cell"><style:table-cell-properties style:decimal-places="2"/><style:paragraph-properties style:tab-stop-distance="1.25cm"/><style:text-properties style:font-name="Arial" fo:language="fr" fo:country="FR" style:font-name-asian="Arial Unicode MS" style:language-asian="zh" style:country-asian="CN" style:font-name-complex="Tahoma" style:language-complex="hi" style:country-complex="IN"/></style:default-style><number:number-style style:name="N0"><number:number number:min-integer-digits="1"/></number:number-style><number:currency-style style:name="N106P0" style:volatile="true"><number:number number:decimal-places="2" number:min-integer-digits="1" number:grouping="true"/><number:text> </number:text><number:currency-symbol number:language="fr" number:country="FR">€</number:currency-symbol></number:currency-style><number:currency-style style:name="N106"><style:text-properties fo:color="#ff0000"/><number:text>-</number:text><number:number number:decimal-places="2" number:min-integer-digits="1" number:grouping="true"/><number:text> </number:text><number:currency-symbol number:language="fr" number:country="FR">€</number:currency-symbol><style:map style:condition="value()&gt;=0" style:apply-style-name="N106P0"/></number:currency-style><style:style style:name="Default" style:family="table-cell"><style:text-properties style:font-name-complex="Lucida Sans"/></style:style><style:style style:name="Result" style:family="table-cell" style:parent-style-name="Default"><style:text-properties fo:font-style="italic" style:text-underline-style="solid" style:text-underline-width="auto" style:text-underline-color="font-color" fo:font-weight="bold"/></style:style><style:style style:name="Result2" style:family="table-cell" style:parent-style-name="Result" style:data-style-name="N106"/><style:style style:name="Heading" style:family="table-cell" style:parent-style-name="Default"><style:table-cell-properties style:text-align-source="fix" style:repeat-content="false"/><style:paragraph-properties fo:text-align="center"/><style:text-properties fo:font-size="16pt" fo:font-style="italic" fo:font-weight="bold"/></style:style><style:style style:name="Heading1" style:family="table-cell" style:parent-style-name="Heading"><style:table-cell-properties style:rotation-angle="90"/></style:style></office:styles><office:automatic-styles><style:page-layout style:name="Mpm1"><style:page-layout-properties style:writing-mode="lr-tb"/><style:header-style><style:header-footer-properties fo:min-height="0.751cm" fo:margin-left="0cm" fo:margin-right="0cm" fo:margin-bottom="0.25cm"/></style:header-style><style:footer-style><style:header-footer-properties fo:min-height="0.751cm" fo:margin-left="0cm" fo:margin-right="0cm" fo:margin-top="0.25cm"/></style:footer-style></style:page-layout><style:page-layout style:name="Mpm2"><style:page-layout-properties style:writing-mode="lr-tb"/><style:header-style><style:header-footer-properties fo:min-height="0.751cm" fo:margin-left="0cm" fo:margin-right="0cm" fo:margin-bottom="0.25cm" fo:border="0.088cm solid #000000" fo:padding="0.018cm" fo:background-color="#c0c0c0"><style:background-image/></style:header-footer-properties></style:header-style><style:footer-style><style:header-footer-properties fo:min-height="0.751cm" fo:margin-left="0cm" fo:margin-right="0cm" fo:margin-top="0.25cm" fo:border="0.088cm solid #000000" fo:padding="0.018cm" fo:background-color="#c0c0c0"><style:background-image/></style:header-footer-properties></style:footer-style></style:page-layout></office:automatic-styles><office:master-styles><style:master-page style:name="Default" style:page-layout-name="Mpm1"><style:header><text:p><text:sheet-name>???</text:sheet-name></text:p></style:header><style:header-left style:display="false"/><style:footer><text:p>Page <text:page-number>1</text:page-number></text:p></style:footer><style:footer-left style:display="false"/></style:master-page><style:master-page style:name="Report" style:page-layout-name="Mpm2"><style:header><style:region-left><text:p><text:sheet-name>???</text:sheet-name> (<text:title>???</text:title>)</text:p></style:region-left><style:region-right><text:p><text:date style:data-style-name="N2" text:date-value="2010-08-25">25/08/2010</text:date>, <text:time>15:26:22</text:time></text:p></style:region-right></style:header><style:header-left style:display="false"/><style:footer><text:p>Page <text:page-number>1</text:page-number> / <text:page-count>99</text:page-count></text:p></style:footer><style:footer-left style:display="false"/></style:master-page></office:master-styles></office:document-styles>
XML;
    $zip->addFromString("styles.xml", '<?xml version="1.0" encoding="UTF-8"?'.">\n".$styles);

    $manifest = <<<'XML'
<manifest:manifest xmlns:manifest="urn:oasis:names:tc:opendocument:xmlns:manifest:1.0">
 <manifest:file-entry manifest:media-type="application/vnd.oasis.opendocument.spreadsheet" manifest:version="1.2" manifest:full-path="/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/statusbar/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/accelerator/current.xml"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/accelerator/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/floater/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/popupmenu/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/progressbar/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/menubar/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/toolbar/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/images/Bitmaps/"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Configurations2/images/"/>
 <manifest:file-entry manifest:media-type="application/vnd.sun.xml.ui.configuration" manifest:full-path="Configurations2/"/>
 <manifest:file-entry manifest:media-type="text/xml" manifest:full-path="content.xml"/>
 <manifest:file-entry manifest:media-type="text/xml" manifest:full-path="styles.xml"/>
 <manifest:file-entry manifest:media-type="text/xml" manifest:full-path="meta.xml"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Thumbnails/thumbnail.png"/>
 <manifest:file-entry manifest:media-type="" manifest:full-path="Thumbnails/"/>
 <manifest:file-entry manifest:media-type="text/xml" manifest:full-path="settings.xml"/>
</manifest:manifest>
XML;

    $zip->addEmptyDir("Thumbnails");    

    $img = imagecreatetruecolor(188,256);
    imagecolorallocate($img, 255,255,255);
    ob_start();
    imagepng($img);
    $thumbnail = ob_get_contents();
    ob_end_clean();
    
    $zip->addFromString("Thumbnails/thumbnail.png", $thumbnail); 
    $zip->addEmptyDir("META-INF");
    $zip->addFromString("META-INF/manifest.xml", '<?xml version="1.0" encoding="UTF-8"?'.">\n".$manifest);

    $zip->addFromString("mimetype",'application/vnd.oasis.opendocument.spreadsheet');

    $zip->addEmptyDir("Configurations2");
    $zip->addEmptyDir("Configurations2/accelerator");
    $zip->addFromString("Configurations2/accelerator/current.xml",'');
    
    $zip->addEmptyDir("Configurations2/floater");
    $zip->addEmptyDir("Configurations2/images");
    $zip->addEmptyDir("Configurations2/images/Bitmaps");
    $zip->addEmptyDir("Configurations2/menubar");
    $zip->addEmptyDir("Configurations2/popupmenu");
    $zip->addEmptyDir("Configurations2/progressbar");
    $zip->addEmptyDir("Configurations2/statusbar");
    $zip->addEmptyDir("Configurations2/toolbar");
    }
}


?>