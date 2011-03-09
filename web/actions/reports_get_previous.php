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
include('../include/config.php');

// @todo tss tss @security
$analyzer = $_GET['analyzer'];

$sql = <<<SQL
SELECT TRM.module, TRM.fait
FROM <report_module> TRM
WHERE TRM.module < '$analyzer'
ORDER BY TRM.module DESC
LIMIT 1
SQL;
$res = $DATABASE->query($sql);
$res = $res->fetchAll();

// @todo Also clean reports
// @todo also clean token tables

if (!empty($res[0]['module'])) {
    header('Location: ../reports_analyzer.php?analyzer='.$res[0]['module']);
} else {
    header('Location: ../reports.php');
}
die();
?>