<?php

include('include/config.php');

$formats = array('dot' => array('extension' => 'dot',
                                'mime-type' => 'text/x-graphviz',),
                 'gephi' => array('extension' => 'gexf',
                                'mime-type' => 'text/xml',),);

// @todo validate this! 
$analyzer = $_GET['analyzer'];
if (!in_array($_GET['format'], array_keys($formats))) {
    header('Location: reports_dot.php');
    die();
}
$format = $_GET['format'];

// @todo this is ugly! Make this better soon!
$sql = <<<SQL
SELECT *
FROM <report_dot> TR
WHERE module='$analyzer'
SQL;
$res = $DATABASE->query($sql);
$rows = $res->fetchAll(PDO::FETCH_ASSOC);

$class = 'Cornac_Format_'.ucfirst(strtolower($format));
$formater = new $class();

header('Content-type: '.$formats[$format]['mime-type']);
header('Content-Disposition: attachment; filename="'.$analyzer.'.'.$formats[$format]['extension'].'"');

echo $formater->format($rows);

?>