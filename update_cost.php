<?php
function cost1(){
        #StartNode‚Ì”»’è
        $sql1s = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM node ORDER BY len LIMIT 0 , 1;", $stlat, $stlng);
        $query1s = mysql_query($sql1s);
        if (!$query1s) {
                die('query error'.mysql_error());
                }
        $row1s = mysql_fetch_assoc($query1s);

        #EndNode‚Ì”»’è
        $sql1e = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM node ORDER BY len LIMIT 0 , 1;", $enlat, $enlng);
        $query1e = mysql_query($sql1e);
        if (!$query1e) {
                die('query error'.mysql_error());
        }

        $row1e = mysql_fetch_assoc($query1e);
}
function cost2(){
        #StartNode‚Ì”»’è
        $sql1s = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM node ORDER BY len LIMIT 0 , 1;", $stlat, $stlng);
        $query1s = mysql_query($sql1s);
        if (!$query1s) {
                die('query error'.mysql_error());
                }
        $row1s = mysql_fetch_assoc($query1s);

        #EndNode‚Ì”»’è
        $sql1e = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM node ORDER BY len LIMIT 0 , 1;", $enlat, $enlng);
        $query1e = mysql_query($sql1e);
        if (!$query1e) {
                die('query error'.mysql_error());
        }

        $row1e = mysql_fetch_assoc($query1e);
}
?>