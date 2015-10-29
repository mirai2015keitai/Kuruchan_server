<?php
                $data1 = '41.8280593';
                $data2 = '140.7543736';
                $data3 = '41.8154347';
                $data4 = '140.7546968';
                $stlat = (DOUBLE)$data1;
                $stlng = (DOUBLE)$data2;
                $enlat = (DOUBLE)$data3;
                $enlng = (DOUBLE)$data4;

                require_once 'route_serch.php';
                echo route_serch($stlat,$stlng,$enlat,$enlng);

?>