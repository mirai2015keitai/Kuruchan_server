<?php
$db_kuru = mysql_connect('localhost', 'KuRUchAn', 'chankuru');
if(!$db_kuru){
        echo "mysql not connection.";
}
$db_select = mysql_select_db('kuruchan', $db_kuru);
if (!$db_select){
        die('detabes not connection.'.mysql_error());
}else{
        $query1 = mysql_query('SELECT * FROM ProRoad');
        if(!$query1) {
                die('query error'.mysql_error());
        }

        $i = 0;
        while ($row1 = mysql_fetch_assoc($query1)) {
                $StartLat[$i] = $row1['st_lat'];
                $StartLng[$i] = $row1['st_lng'];
                $EndLat[$i] = $row1['en_lat'];
                $EndLng[$i] = $row1['en_lng'];
                $NoDump[$i] = $row1['no_dump'];
                $HighDump[$i] = $row1['high_dump'];
                $i++;
        }

        for($x = 0; $x < $i; $x++){
                $cost = 0;
                $sqls = sprintf("select NodeNo , X(latlon) as latitude , Y(latlon) as longitude from Node where X(latlon) = %f AND Y(latlon)= %f;", $StartLat[$x], $StartLng[$x]);
                $querys = mysql_query($sqls);
                if(!$querys) {
                        die('query error'.mysql_error());
                }
                $rows = mysql_fetch_assoc($querys);
                echo $rows['NodeNo'].'<br>';

                $sqle = sprintf("select NodeNo , X(latlon) as latitude , Y(latlon) as longitude from Node where X(latlon) = %f AND Y(latlon)= %f;", $EndLat[$x], $EndLng[$x]);
                $querye = mysql_query($sqle);
                if(!$querye) {
                        die('query error'.mysql_error());
                }
                $rowe = mysql_fetch_assoc($querye);
                echo $rowe['NodeNo'].'<br>';

                $sql2 = sprintf("SELECT * FROM ProRoad WHERE st_lat = %f AND st_lng = %f AND en_lat = %f AND en_lng = %f", $StartLat[$x], $StartLng[$x], $EndLat[$x], $EndLng[$x]);
                $query2 = mysql_query($sql2);
                if(!$query2) {
                        die('query error'.mysql_error());
                }
                while($row2 = mysql_fetch_assoc($query2)){
                        if($row2['high_dump']==999) $cost = 99999;
                }

                if($cost!=99999){
                        $sql3 = sprintf("SELECT SUM(high_dump), COUNT(high_dump) FROM ProRoad WHERE st_lat = %f AND st_lng = %f AND en_lat = %f AND en_lng = %f", $StartLat[$x], $StartLng[$x], $EndLat[$x], $EndLng[$x]);
                        $query3 = mysql_query($sql3);
                        if(!$query3) {
                                die('query error'.mysql_error());
                        }
                        $row3 = mysql_fetch_assoc($query3);

                        $cost = $row3['SUM(high_dump)'] / $row3['COUNT(high_dump)'];
                }

                $sqlup = sprintf("UPDATE LinkTest SET high_dump = %d WHERE StartNode = %d AND EndNode = %d", $cost, $rows['NodeNo'], $rowe['NodeNo']);
                $queryup = mysql_query($sqlup);
                if(!$queryup) {
                        die('query error'.mysql_error());
                }
                echo $cost.'<br>';
        }
}
?>