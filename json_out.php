<?php
        if(isset($_REQUEST['st_lat']) && isset($_REQUEST['st_lng']) && isset($_REQUEST['en_lat']) && isset($_REQUEST['en_lng'])){ //�X�^�[�g�n�_�ƃS�[���n�_�̈ʒu�����󂯎�萬��
                $data1 = (String)$_REQUEST['st_lat'];
                $data2 = (String)$_REQUEST['st_lng'];
                $data3 = (String)$_REQUEST['en_lat'];
                $data4 = (String)$_REQUEST['en_lng'];

                require_once 'route_serch.php'; //�֐��Ăяo������
                echo A_star_serch(0,0,0,0); //A*�T���֐��̌Ăяo��

        }else{ //�ڑ����s
                echo "error de gozaru !";

                require_once 'route_serch.php'; //�֐��Ăяo���f�o�b�N
                echo A_star_serch(0,0,0,0); //A*�T���֐��̃f�o�b�N

        }
?>