<?php
        if(isset($_REQUEST['st_lat']) && isset($_REQUEST['st_lng']) && isset($_REQUEST['en_lat']) && isset($_REQUEST['en_lng'])){ //スタート地点とゴール地点の位置情報を受け取り成功
                $data1 = (String)$_REQUEST['st_lat'];
                $data2 = (String)$_REQUEST['st_lng'];
                $data3 = (String)$_REQUEST['en_lat'];
                $data4 = (String)$_REQUEST['en_lng'];

                require_once 'route_serch.php'; //関数呼び出し準備
                echo A_star_serch(0,0,0,0); //A*探索関数の呼び出し

        }else{ //接続失敗
                echo "error de gozaru !";

                require_once 'route_serch.php'; //関数呼び出しデバック
                echo A_star_serch(0,0,0,0); //A*探索関数のデバック

        }
?>