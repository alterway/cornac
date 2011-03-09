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
 */    $query = "SELECT ML.module AS element, 
                     COUNT(RL.id) AS nb, 
                     COUNT(RL.id) - SUM(checked) AS todo 
                 FROM <report_module> ML
                 LEFT JOIN <report> RL
                    ON ML.module = RL.module
                 GROUP BY ML.module";
    $res = $DATABASE->query($query);

    $rows = $res->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($rows as &$row) {
        $row['link'] = "index.php?module=".$row['element'];
        $row['element'] = $translations[$row['element']]['title'] ? $translations[$row['element']]['title'] : $row['element'];
    }
    
    usort($rows, 'cmp');
    
    print get_html_manual($rows);

    function cmp($a, $b) {
        if ($a['element'] == $b['element']) {
            return 0;
        }
        return ($a['element'] < $b['element']) ? -1 : 1;
    }
?>