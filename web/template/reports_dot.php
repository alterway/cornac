<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
 <title>Cornac analysis for <?php echo $analyzer; ?> : list of all network reports</title>
</head>
<body>
<a href="index.php">Main</a>
<?php

$html = '';
$html .= "<table>\n";

foreach($rows as $id => $row) {
    $html .= "<tr>
  <td>{$row['module']}</td>
  <td>{$row['fait']}</td>
  <td><a href=\"{$row['url']}&format=dot\">DOT</a></td>
  <td><a href=\"{$row['url']}&format=gephi\">Gephi</a></td>
</tr>
";
}

$html .= "</table>\n";

print $html;

?>
</body>
</html>