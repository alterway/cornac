<?php

include('include/config.php');

// @todo validate this! 
$analyzer = $_GET['analyzer'];

$view = new Cornac_View();

$view->application = $ini['cornac']['prefix'];
$view->url_main = 'index.php';
$view->url_reports = 'reports.php';
$view->url_report_file = 'reports_files.php?analyzer='.$analyzer.'';
$view->url_previous = '';
$view->url_next = '';
$view->analyzer = $analyzer;

$html = '';
$stats = array();

// @todo this is ugly! Make this better soon!
$sql = <<<SQL
SELECT DISTINCT TR.element
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
ORDER BY element, file, line
SQL;
$res = $DATABASE->query($sql);
$rows = $res->fetchAll(PDO::FETCH_ASSOC);

$stats['total'] = count($rows);

$view->rows = $rows;
$view->stats = $stats;
echo $view->process('template/reports_analyzer.php', $rows);

?>