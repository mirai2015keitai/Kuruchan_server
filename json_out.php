<?php
        if(isset($_REQUEST['st_lat']) && isset($_REQUEST['st_lng']) && isset($_REQUEST['en_lat']) && isset($_REQUEST['en_lng'])){ //�X�^�[�g�n�_�ƃS�[���n�_�̈ʒu�����󂯎�萬��
                $data1 = (String)$_REQUEST['st_lat'];
                $data2 = (String)$_REQUEST['st_lng'];
                $data3 = (String)$_REQUEST['en_lat'];
                $data4 = (String)$_REQUEST['en_lng'];
                $stlat = (DOUBLE)$data1;
                $stlng = (DOUBLE)$data2;
                $enlat = (DOUBLE)$data3;
                $enlng = (DOUBLE)$data4;

                require_once 'route_serch.php'; //�֐��Ăяo������
                echo route_serch($stlat,$stlng,$enlat,$enlng); //A*�T���֐��̌Ăяo��

        }else{ //�ڑ����s
                echo "error de gozaru !";
        }
?>