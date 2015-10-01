<?php

        function A_star_serch($a, $b, $c, $d){
                $db_kuru = mysql_connect('localhost', 'kurutest', 'kurutest'); //mariadbのkurutestのユーザに接続
                if(!$db_kuru){
                        echo "DBMS not connection";
                }

                $db_select = mysql_select_db('kuru_test', $db_kuru); //データベースkuru_testを選択
                if (!$db_select){
                        die('database not connection'.mysql_error());
                }else{
                        return json_encode(array(
                        start_location=>array( 'lat'=>'40.1234567', 'lng'=>'135.1234567'),
                        end_location=>array( 'lat'=>'40.7654321', 'lng'=>'135.7654321'),
                        waypoint=>array(
                        array( 'lat'=>'40.5555555', 'lng'=>'135.5555555'),
                        array( 'lat'=>'40.7777777', 'lng'=>'135.7777777')
                        )
                        ));
                }
        }

?>