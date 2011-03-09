<?php

include('include/config.php');

$sql = <<<SQL
SELECT TRM.module, TRM.fait, COUNT(*) AS count
FROM <report_module> TRM
JOIN <report_dot> TR
    ON TR.module = TRM.module
GROUP BY TR.module
ORDER BY TR.module
SQL;
$res = $DATABASE->query($sql);
$rows = $res->fetchAll(PDO::FETCH_ASSOC);

foreach($rows as $id => $row) {
    $rows[$id]['url'] = "reports_export.php?analyzer={$row['module']}";
}

$view = new Cornac_View();
$view->rows = $rows;
$view->analyzer = $ini['cornac']['prefix'];
echo $view->process('template/reports_dot.php', $rows);

?>