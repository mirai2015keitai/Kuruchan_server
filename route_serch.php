<?php

        function A_star_serch($slat, $slng, $elat, $elng){
                $db_kuru = mysql_connect('localhost', 'kurutest', 'kurutest'); //mariadbのkurutestのユーザに接続
                if(!$db_kuru){
                        echo "DBMS not connection";
                }

                $db_select = mysql_select_db('kuru_test', $db_kuru); //データベースkuru_testを選択
                if (!$db_select){
                        die('database not connection'.mysql_error());
                }else{
                        return json_encode(array(
                        start_location=>array( 'lat'=>$slat, 'lng'=>$slng),
                        end_location=>array( 'lat'=>$elat, 'lng'=>$elng),
                        waypoint=>array(
                        array( 'lat'=>'40.5555555', 'lng'=>'140.5555555'),
                        array( 'lat'=>'40.7777777', 'lng'=>'140.7777777')
                        )
                        ));
                }
        }

?>