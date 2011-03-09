#!/usr/bin/env php
<?php

include('../library/Cornac/Autoload.php');
spl_autoload_register('Cornac_Autoload::autoload');

print "\n";
if (in_array('-W', $_SERVER['argv'])) {
    print "Updating disclaimer\n\n";
    sleep(3);
    define("WRITE", true);
} else {
    define("WRITE", false);
}

$text = <<<TEXT
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
TEXT;

$olds = array(
"2010-12-31" => <<<TEXT
/*
   +----------------------------------------------------------------------+
   | Cornac, PHP code inventory                                           |
   +----------------------------------------------------------------------+
   | Copyright (c) 2010                                                   |
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
TEXT
,

);

/*
$olds['7/9/2010b'] = <<<TEXT

TEXT;
*/

global $INI;
$INI = array('tokenizeur' => 
           array('ignore_dirs' => 'References',
                 'ignore_ext' => explode(',', ".ini,.exp,.log,.architect,.CAB,.DLL,.JPG,.afm,.ai,.as3proj,.awk,.bak,.bat,.bdsgroup,.bdsproj,.bin,.bmp,.bpk,.bpr,.c,.cgi,.conf,.config,.cpp,.csproj,.css,.csv,.ctp,.darwin,.dat,.db,.dba,.default,.desc,.dia,.dist,.dll,.doc,.docx,.dtd,.eot,.exe,.ezt,.fla,.flv,.fre,.gem,.gif,.gz,.h,.hlp,.htm,.html,.icc,.ico,.in,.info,.jar,.java,.jpeg,.jpg,.js,.jsb,.launch,.lin,.linux,.lss,.manifest,.markdown,.md,.md5,.mno,.mo,.mp3,.mpg,.mso,.mwb,.mxml,.o,.odg,.odp,.odt,.old,.ott,.pas,.patch,.pcx,.pdf,.pfb,.pl,.png,.po,.ppt,.psd,.py,.rar,.rdf,.resx,.rng,.rss,.sample,.scc,.selenium,.sgml,.sh,.sit,.sitx,.so,.sql,.src,.svg,.swf,.swz,.sxd,.sxw,.table,.tar,.tex,.tga,.tif,.tiff,.ts,.ttf,.txt,.vsd,.war,.woff,.wsdl,.xad,.xap,.xcf,.xls,.xmi,.xml,.xsd,.xsl,.xslt,.xul,.yml,.z,.zip"),
                 'limit' => 0,
           )
        );

$spl = new Cornac_Dir_RecursiveDirectoryIterator();
$fichiers = $spl->list_files('../');

$stats = array('old' => 0,'ready' => 0,'already' => 0,'wrong' => 0);

foreach($fichiers as $fichier) {
    if (basename($fichier) == 'disclaimer.php') { continue; }
    
    $pathinfo = pathinfo($fichier);
    if (!isset($pathinfo['extension'])) { continue; }

    $code = file_get_contents($fichier);
    
    $x = preg_match_all('/damien.seguy@gmail.com/is', $code, $r);
    if ($x > 1) {
        print "$x occurrences of disclaimer in $fichier\n";
    }

    foreach($olds as $version => $old) {
        if (strpos($code, $old) !== false) {
            print "$fichier : old disclaimer found ($version)\n";
            $code = str_replace($old, '', $code);
            $stats['old']++;
        }
        if (WRITE) {
            file_put_contents($fichier, $code);
        }
    }

    if (preg_match('/\?>\s+/is', $code)) {
        $code = trim($code);
        file_put_contents($fichier, $code);
    }
    
    if (strpos($code, $text) !== false) {
//        print "$fichier : already fixed\n";
        $stats['already']++;
    } elseif (substr($code, 0, 25) == "#!/usr/bin/env php\n<?php\n") {
        print "$fichier : OK\n";
        $stats['ready']++;
        if (WRITE) {
            $code = "#!/usr/bin/env php\n<?php\n".$text.substr(trim($code), 25);
            file_put_contents($fichier, $code);
        }
    } elseif (substr($code, 0, 6) == "<?php ") {
        $code = "<?php\n".substr($code, 6);
        file_put_contents($fichier, $code);

        print "$fichier : OK\n";
        $stats['ready']++;
        if (WRITE) {
            $code = "<?php\n".$text.substr(trim($code), 6);
            file_put_contents($fichier, $code);
        }
    } elseif (substr($code, 0, 6) == "<?php\n") {
        print "$fichier : OK\n";
        $stats['ready']++;
        if (WRITE) {
            $code = "<?php\n".$text.substr(trim($code), 6);
            file_put_contents($fichier, $code);
        }
    } else {
        print "$fichier : not starting right\n";
        $stats['wrong']++;
    }
}

$total = array_sum($stats);
print "=============================\n";
foreach($stats as $stat => $nb) {
    print "$stat : $nb (".number_format($nb /$total * 100, 0)." %)\n";
}
print "=============================\n";
print "Total : $total\n";

?>