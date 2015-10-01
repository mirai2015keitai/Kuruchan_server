<?php

function summary($slat, $slng, $elat, $elng){

        // -- 受け取った位置情報のカウント値 -- //
        $sql1 = sprintf("select count(*) FROM tLowRSC WHERE st_lat = %9.7f AND st_lng = %10.7f AND en_lat = %9.7f AND en_lng = %10.7f;", $slat, $slng, $elat, $elng);
        $query1 = mysql_query($sql1);
        $row1 =  mysql_fetch_assoc($query1);
        $count = $row1['count(*)'];

        // -- 受け取った位置情報のno_dumpの合計値 -- //
        $sql2 = sprintf("select sum(ALL no_dump) FROM tLowRSC WHERE st_lat = %9.7f AND st_lng = %10.7f AND en_lat = %9.7f AND en_lng = %10.7f;", $slat, $slng, $elat, $elng);
        $query2 = mysql_query($sql2);
        $row2 =  mysql_fetch_assoc($query2);
        $sum_no_d = $row2['sum(ALL no_dump)'];

        // -- 受け取った位置情報のhigh_dumpの合計値 -- //
        $sql3 = sprintf("select sum(ALL high_dump) FROM tLowRSC WHERE st_lat = %9.7f AND st_lng = %10.7f AND en_lat = %9.7f AND en_lng = %10.7f;", $slat, $slng, $elat, $elng);
        $query3 = mysql_query($sql3);
        $row3 =  mysql_fetch_assoc($query3);
        $sum_hi_d = $row3['sum(ALL high_dump)'];


        // -- 平均値の計算 -- //
        $no_d = $sum_no_d / $count;
        $hi_d = $sum_hi_d / $count;

        // -- 受け取った位置情報にno_dumpとhigh_dumpの値を更新 -- //
        $sql4 = sprintf("INSERT INTO tProRSC (st_lat, st_lng, en_lat, en_lng, no_dump, high_dump) VALUES (%9.7f, %10.7f, %9.7f, %10.7f, %d, %d) ON DUPLICATE KEY UPDATE no_dump = %d, high_dump = %d", $slat, $slng, $elat, $elng, $no_d, $hi_d, $no_d, $hi_d);
        $query4 = mysql_query($sql4);

}

?>