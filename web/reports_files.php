<?php

include('include/config.php');

$view = new Cornac_View();

// @todo validate this! 
$analyzer = $_GET['analyzer'];

$view->analyzer = $analyzer;

$view->url_main = 'index.php';
$view->url_reports = 'reports.php';
$view->url_report_analyzer = 'reports_analyzer.php?analyzer='.$analyzer.'';

$html = '';
$stats = array();

// @todo this is ugly! Make this better soon!
$sql = <<<SQL
SELECT DISTINCT TR.file
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY element, TR.file, line
SQL;
$res = $DATABASE->query($sql);
$rows = $res->fetchAll(PDO::FETCH_ASSOC);

$stats['distinct'] = count($rows);

$sql = <<<SQL
SELECT TR.element, TR.file, T1.line
FROM <report> TR
JOIN <tokens> T1
    ON TR.token_id = T1.id
WHERE module='$analyzer'
ORDER BY file, line, element
SQL;
$res = $DATABASE->query($sql);
$rows = $res->fetchAll(PDO::FETCH_ASSOC);

$stats['total'] = count($rows);

$view->rows = $rows;
$view->stats = $stats;
echo $view->process('template/reports_files.php', $rows);

?>