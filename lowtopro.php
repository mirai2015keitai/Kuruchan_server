<?php
$db_kuru = mysql_connect('localhost', 'KuRUchAn', 'chankuru');
if(!$db_kuru){
        echo "mysql not connection.";
}
$db_select = mysql_select_db('kuruchan', $db_kuru);
if (!$db_select){
        die('detabes not connection.'.mysql_error());
}else{
        $tableformat = mysql_query('TRUNCATE TABLE ProRoad');
        if (!$tableformat) {
                die('query error'.mysql_error());
        }

        $sql = "SELECT * FROM LowRoad";
        $query = mysql_query($sql);
        if (!$query) {
                die('query error'.mysql_error());
        }

        $i = 0;
        while ($row1 = mysql_fetch_assoc($query)) {
                $StartLat[$i] = $row1['st_lat'];
                $StartLng[$i] = $row1['st_lng'];
                $EndLat[$i] = $row1['en_lat'];
                $EndLng[$i] = $row1['en_lng'];
                $NoDump[$i] = $row1['no_dump'];
                $HighDump[$i] = $row1['high_dump'];
                $i++;
        }

        $j=0;
        $l=0;
        $high_dump = 0;

#LowRoadの経路を抽出
step_1:
        echo "<br>start step 1<br>";
        $k = 0;
        $node = array();
        for($j; $j < $i; $j++){
                if($EndLat[$j] == $StartLat[$j+1] && $EndLng[$j] == $StartLng[$j+1]){
                        $node[$k] = array('slat'=>$StartLat[$j], 'slng'=>$StartLng[$j], 'elat'=>$EndLat[$j], 'elng'=>$EndLng[$j]);
                        echo print_r($node[$k]);
                        echo"<br>";
                        if($k == 0) $l = $j;
                        $k++;
                }else{
                        if($EndLat[$j-1] == $StartLat[$j] && $EndLng[$j-1] == $StartLng[$j]){
                                $node[$k] = array('slat'=>$StartLat[$j], 'slng'=>$StartLng[$j], 'elat'=>$EndLat[$j], 'elng'=>$EndLng[$j]);
                                $j++;
                                echo print_r($node[$k]);
                                echo"<br>";
                                goto step_2;
                        }
                        $node[$k] = array('slat'=>$StartLat[$j], 'slng'=>$StartLng[$j], 'elat'=>$EndLat[$j], 'elng'=>$EndLng[$j]);
                        $j++;
                        echo print_r($node[$k]);
                        echo"<br>";
                        goto step_2;
                }
        }
        goto step_6;

#StartNodeの判定
step_2:
        echo "<br>start step 2<br>";
        $sqlstn = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM Node ORDER BY len LIMIT 0 , 1;", $StartLat[$l], $StartLng[$l]);
        $querystn = mysql_query($sqlstn);
        if (!$querystn) {
                die('query error'.mysql_error());
        }
        $rowstn = mysql_fetch_assoc($querystn);

#StartNodeからLinkしているNodeの抽出
        $sql2 = sprintf("SELECT * FROM Link WHERE StartNode = %d", $rowstn['NodeNo']);
        $query2 = mysql_query($sql2);
        if (!$query2) {
                die('query error'.mysql_error());
        }
        $x=0;
        while ($row2 = mysql_fetch_assoc($query2)) {
                $StartNode[$x] = $row2['StartNode'];
                $EndNode[$x] = $row2['EndNode'];
                echo 'StartNode='.$StartNode[$x].'EndNode='.$EndNode[$x].'<br>';
                $x++;
        }

#EndNodeの判定
step_3:
        echo "<br>start step 3<br>";
        for($y=0; $y < $x; $y++){
                $sql3 = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude FROM Node WHERE NodeNo = %d;", $EndNode[$y]);
                $query3 = mysql_query($sql3);
                if (!$query3) {
                        die('query error'.mysql_error());
                }
                $row3 = mysql_fetch_assoc($query3);


                $en_lat[$y] = $row3['Latitude'];
                $en_lng[$y] = $row3['Longitude'];

                $r = 0.2;
                $e1lat[$y] = $row3['Latitude'] - $r;
                $e1lng[$y] = $row3['Longitude'] - $r;
                $e2lat[$y] = $row3['Latitude'] + $r;
                $e2lng[$y] = $row3['Longitude'] + $r;
        }

        for($l; $l < $j; $l++){
                $high_dump = $high_dump + $HighDump[$l];

                for($m = 0; $m < $y; $m++){
                        if($EndLat[$l] > $e1lat[$m] && $EndLat[$l] < $e2lat[$m] && $EndLng[$l] > $e1lng[$m] && $EndLng[$l] < $e2lng[$m]){
                                echo 'EndNode='.$EndNode[$m].'<br>';
                                goto step_4;
                        }
                }
        }
        $high_dump=0;
        if($j < $i) goto step_1;
        else goto step_6;

#ProLoadの更新
step_4:
        echo "<br>start step 4<br>";
        echo 'stlat='.$rowstn['Latitude'].'stlng='.$rowstn['Longitude'].'enlat='.$en_lat[$m].'enlng='.$en_lng[$m].'high_dump='.$high_dump.'<br>';
        $sql4 = sprintf("INSERT INTO ProRoad VALUES (%9.7f, %10.7f, %9.7f, %10.7f, %d, %d)", $rowstn['Latitude'], $rowstn['Longitude'], $en_lat[$m], $en_lng[$m], 0, $high_dump);
        $query4 = mysql_query($sql4);
        if (!$query4) {
                die('query error'.mysql_error());
        }
        $l++;
        $high_dump=0;
        if($l < $j) goto step_2;
        goto step_1;
#手動入力
step_5:
        echo "<br>start step 5 <br>";

#終了
step_6:
        echo "<br>start step 6 (End)<br>";
}
?>
