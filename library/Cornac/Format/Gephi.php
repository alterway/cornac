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
   | Author: Damien Seguy <damien.seguy@alterway.fr>                      |
   +----------------------------------------------------------------------+
 */

// @todo set up an interface for this to extends
class Cornac_Format_Gephi {
    // @todo make a method for direct saving to file
    // @todo review this : this is too highly depend on array structure. 
    function format($data) {
        $nodes = array();
        $edges = array();
        foreach($data as $row) {
            if (($ida = in_array($row['a'], $nodes)) === false) {
                $nodes[] = $row['a'];
                $ida = count($nodes);
            }
            if (($idb = in_array($row['b'], $nodes)) === false) {
                $nodes[] = $row['b'];
                $idb = count($nodes);
            }
        
            $edges[] = "source=\"$ida\" target=\"$idb\"";
        }
        
        $liste_nodes = '';
        foreach($nodes as $id => $node) {
            $liste_nodes .= <<<XML
        <node id="$id" label="$node">
            <attvalues>
            </attvalues>
        </node>

XML;
        }
        
        $liste_edges = '';
        foreach($edges as $id => $node) {
            $liste_edges .= <<<XML
        <edge id="$id" $node />

XML;
         }

// @todo make a way to customize description and auditeur with analyzer name
         $gexf = '<?xml version="1.0" encoding="UTF-8"?>';
         $gexf .= <<<XML

<gexf xmlns="http://www.gexf.net/1.1draft" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.gexf.net/1.1draft http://gexf.net/1.1draft.xsd" version="1.1">
    <meta lastmodifieddate="2009-03-20">
        <creator>Auditeur</creator>
        <description>Cornac export</description>
    </meta>
    <graph defaultedgetype="directed">
        <attributes class="node">
        <!--
            <attribute id="0" title="url" type="string"/>
            <attribute id="1" title="indegree" type="float"/>
            <attribute id="2" title="frog" type="boolean">
                <default>true</default>
            </attribute>
            -->
        </attributes>
        <nodes>
            $liste_nodes
        </nodes>
        <edges>
            $liste_edges
        </edges>
    </graph>
</gexf>    
XML;
        return $gexf;
    }
}


?>