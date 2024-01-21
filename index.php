<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Noto Sans">
    <style>
        body {
            font-family: 'Noto Sans', regular;
            font-size: 14px;
            margin: 0;
        }

        th {color: #444444; background-color: #efefef; font-weight: bold;}
        tr:nth-child(even) {background-color: #f5f5f5;}
        tr:hover td {border-bottom: 1px solid #04AA6D; border-collapse: collapse; background-color: #e3e3e3;}
        table, th, td, tr {font-size: 14px; padding: 3px; border: 1px solid #ccc; border-collapse: collapse;}
    </style>
        <link href="theme.css" rel="stylesheet">
        <script src="jquery-3.6.3.min.js"></script>
        <script src="jquery.tablesorter.min.js"></script>
        <script src="jquery.tablesorter.widgets.min.js"></script>
        <script>
        $(function(){
                $('table').tablesorter({
                        widgets        : [ 'zebra', 'columns', "filter" ],
                        usNumberFormat : false,
                        sortReset      : true,
                        sortRestart    : true
                });
        });
        </script>
<body>
<?php

// SQLite3 Database Location
$db = new SQLite3('/var/www/html/solus-versions/packages.db');
// SQLite3 Database Query
$res = $db->query('SELECT * FROM packages ORDER by package asc');

// Table headers
echo "<body>";
echo "<table class=tablesorter><thead><tr>";
echo "<th>Package Name</th>";
echo "<th>Package Homepage</th>";
echo "<th>Package Monitor</th>";
echo "<th>Version in Solus</th>";
echo "<th>Version Upstream</th>";
echo "<th>Maintainer(s)</th>";
echo "<th>Status</th>";
echo "</tr></thead>";
// Table rows
while ($row = $res->fetchArray()) {
    echo "<tr>";
    echo "<td><a target=_blank href=https://github.com/getsolus/packages/blob/main/packages/{$row['letter']}/{$row['package']}/package.yml>{$row['package']}</a> 🡕 </td>";
    echo "<td><a target=_blank href={$row['homepage']}>Homepage</a> 🡕</td>";
    echo "<td><a target=_blank href=https://release-monitoring.org/project/{$row['rm_id']}/>Monitor</a> 🡕</td>";
    echo "<td>{$row['sver']}</td>";
    echo "<td>{$row['rmver']}</td>";
    echo "<td>{$row['maintainer']}</td>";
    echo "<td><center>{$row['outofdate']}</center></td>";
    echo "</tr>";
}
?>
</table></font></body></html>
