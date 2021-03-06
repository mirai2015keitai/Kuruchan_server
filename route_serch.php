<?php
function route_serch($stlat, $stlng, $enlat, $enlng){
        $db_kuru = mysql_connect('localhost', 'KuRUchAn', 'chankuru');
        if(!$db_kuru){
                echo "DBMS not connection";
        }

        $db_select = mysql_select_db('kuruchan', $db_kuru);
        if (!$db_select){
                die('database not connection'.mysql_error());
        }else{
                $srlen = 0.00277778; //300m

                #StartNodeの判定
                $sql1s = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM Node ORDER BY len LIMIT 0 , 1;", $stlat, $stlng);
                $query1s = mysql_query($sql1s);
                if (!$query1s) {
                        die('query error'.mysql_error());
                }
                $row1s = mysql_fetch_assoc($query1s);

                if($row1s['len'] < $srlen) $start_node = (INT)$row1s['NodeNo']; #StartNode
                else return null;

                #EndNodeの判定
                $sql1e = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude, GLength(GeomFromText(CONCAT('LineString(%f %f,', X(latlon), ' ', Y(latlon),')'))) AS len FROM Node ORDER BY len LIMIT 0 , 1;", $enlat, $enlng);
                $query1e = mysql_query($sql1e);
                if (!$query1e) {
                        die('query error'.mysql_error());
                }

                $row1e = mysql_fetch_assoc($query1e);

                if($row1e['len'] < $srlen) $end_node = (INT)$row1e['NodeNo']; #EndNode
                else return null;

                $start_node = (INT)$row1s['NodeNo']; #StartNode
                $end_node = (INT)$row1e['NodeNo']; #EndNode

                #echo "startnode=$start_node, endnode=$end_node";

                #StartNodeとEndNodeの経緯度取得
                $sql2 = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude FROM Node WHERE NodeNo = %d OR NodeNo = %d", $start_node, $end_node );
                $query2 = mysql_query($sql2);
                if (!$query2) {
                        die('query error'.mysql_error());
                }

                $i = 0;
                while($row2 = mysql_fetch_assoc($query2)){
                        $x[$i] = (DOUBLE)$row2['Latitude'];
                        $y[$i] = (DOUBLE)$row2['Longitude'];
                        $i++;
                }

                $r = sqrt(pow(($x[1] - $x[0]), 2) + pow(($y[1] - $y[0]), 2));#StartNodeとEndNodeの距離
                $cx = ($x[0] + $x[1]) / 2;#StartNodeとEndNodeの中点のx座標
                $cy = ($y[0] + $y[1]) / 2;#StartNodeとEndNodeの中点のy座標

                #出力ノードの範囲指定
                $r1lat = $cx + $r;
                $r1lng = $cy + $r;
                $r2lat = $cx - $r;
                $r2lng = $cy - $r;

                $sql3 = sprintf("SELECT NodeNo, X(latlon) AS Latitude, Y(latlon) AS Longitude FROM Node WHERE MBRContains(GeomFromText('LINESTRING(%f %f, %f %f)'), latlon)", $r1lat, $r1lng, $r2lat, $r2lng);
                $query3 = mysql_query($sql3);
                if (!$query3) {
                        die('query error'.mysql_error());
                }

                $j = 0;
                while($row3 = mysql_fetch_assoc($query3)){
                        $node[$j] = $row3['NodeNo'];
                        $nodelat[$node[$j]] = $row3['Latitude'];
                        $nodelng[$node[$j]] = $row3['Longitude'];
                        $j++;
                }

                #ダイクストラ法
                include_once "dijkstra.php";

                #start_locationとend_locationのjson化
                $start_location = json_encode(array(start_location=>array('lat'=>$row1s['Latitude'], 'lng'=>$row1s['Longitude'])));
                $end_location = json_encode(array(end_location=>array('lat'=>$row1e['Latitude'], 'lng'=>$row1e['Longitude'])));
                #echo "$start_location,$end_location," ;

                #waypointのjson化startからendの順
                $waypoints = array();
                $m = 0;
                for($l = count($result) - 1; $l >= 0; $l--){
                        $waypoints[$m] = array('lat'=>(STRING)$nodelat[$result[$l]], 'lng'=>(STRING)$nodelng[$result[$l]]);
                        $m++;
                }
                echo json_encode(array(waypoint=>$waypoints));

                return null;
        }
}
?>
