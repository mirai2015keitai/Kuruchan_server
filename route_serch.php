<?php
        if(isset($_REQUEST['st_lat']) && isset($_REQUEST['st_lng']) && isset($_REQUEST['en_lat']) && isset($_REQUEST['en_lng'])){ //スタート地点とゴール地点の位置情報を受け取るとき
                $data1 = (String)$_REQUEST['st_lat'];
                $data2 = (String)$_REQUEST['st_lng'];
                $data3 = (String)$_REQUEST['en_lat'];
                $data4 = (String)$_REQUEST['en_lng'];

                $db_kuru = mysql_connect('localhost', 'kurutest', 'kurutest'); //mariadbのkurutestのユーザに接続
                if(!$db_kuru){
                        echo "DBMS not connection";
                }

                $db_select = mysql_select_db('kuru_test', $db_kuru); //データベースkuru_testを選択
                if (!$db_select){
                        die('database not connection'.mysql_error());
                }else{
                        #$stlat = (DOUBLE)$data1;
                        #$stlng = (DOUBLE)$data2;
                        #$enlat = (DOUBLE)$data3;
                        #$enlng = (DOUBLE)$data4;

                        #$select = mysql_query('SELECT st_lat, st_lng, en_lat, en_lng, no_dump, low_dump, high_dump FROM ProRSC');
                        #if (!$select) {
                        #       die('query miss'.mysql_error());
                        #}
                        echo json_encode(array(
                                start_location=>array( 'lat'=>'40.1234567', 'lng'=>'135.1234567'),
                                end_location=>array( 'lat'=>'40.7654321', 'lng'=>'135.7654321'),
                                waypoint=>array(
                                array( 'lat'=>'40.5555555', 'lng'=>'135.5555555'),
                                array( 'lat'=>'40.7777777', 'lng'=>'135.7777777')
                                )
                        ));
                }

        }else{ //受け取れなかったとき
                echo "error de gozaru !";
        }
?>