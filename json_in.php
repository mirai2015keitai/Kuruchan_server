<?php
        if(isset($_REQUEST['st_lat']) && isset($_REQUEST['st_lng']) && isset($_REQUEST['en_lat'])
                && isset($_REQUEST['en_lng']) && isset($_REQUEST['no_dump']) && isset($_REQUEST['high_dump'])){
                $data1 = (String)$_REQUEST['st_lat'];
                $data2 = (String)$_REQUEST['st_lng'];
                $data3 = (String)$_REQUEST['en_lat'];
                $data4 = (String)$_REQUEST['en_lng'];
                $data5 = (String)$_REQUEST['no_dump'];
                $data6 = (String)$_REQUEST['high_dump'];
                echo $data1, $data2,$data3, $data4, $data5, $data6;

                $db_kuru = mysql_connect('localhost', 'kurutest', 'kurutest');
                if(!$db_kuru){
                        echo "not connection";
                }

                $db_select = mysql_select_db('kuru_test', $db_kuru);
                if (!$db_select){
                        die('detabes not connection.'.mysql_error());
                }else{
                        $stlat = (DOUBLE)$data1;
                        $stlng = (DOUBLE)$data2;
                        $enlat = (DOUBLE)$data3;
                        $enlng = (DOUBLE)$data4;
                        $n_d = (INT)$data5;
                        $h_d = (INT)$data6;

                        if($stlat != 0){
                                $sql = sprintf("INSERT INTO tLowRSC (st_lat, st_lng, en_lat, en_lng, no_dump, high_dump)
                                        VALUES (%9.7f, %10.7f, %9.7f, %10.7f, %d, %d)", $stlat, $stlng, $enlat, $enlng, $n_d, $h_d);
                                $query = mysql_query($sql);

                                require_once 'value_move.php';
                                summary($stlat, $stlng, $enlat, $enlng);
                        }
                }
        }else{
                echo "error!";
        }
?>