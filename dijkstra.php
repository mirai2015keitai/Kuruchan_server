<?php
# スタート地点とゴール地点のノード番号
# $start_node = "1";
# $end_node = "5";

# 経路コストの配列
$cost_list  = array(
         "1"=>array("2"=>7,"3"=>9,"6"=>14)
        ,"2"=>array("1"=>7,"3"=>10,"4"=>15)
        ,"3"=>array("1"=>9,"2"=>10,"4"=>11,"6"=>2)
        ,"4"=>array("2"=>15,"3"=>11,"5"=>6)
        ,"5"=>array("4"=>6,"6"=>9)
        ,"6"=>array("1"=>14,"3"=>2,"5"=>9)
);

# ダイクストラ法
function dijkstra($start_node, $cost_list){

        step_1:
        echo "start step 1<br>\n";
        $cost["dist_node"][$start_node]= 0;

        foreach ( $cost_list as $key_node => $next_node) {
                if ( !isset($cost["dist_node"][$key_node]) ) {
                        $cost["dist_node"][$key_node]= INF;
                }
        }

        step_2:
        echo "start step 2<br>\n";
        foreach ( $cost_list as $key_node => $next_node) {
                $cost["visited_node"][$key_node]= 0;
        }

        $cost["prev_node"][$start_node]= $start_node;
        $cost["unvisited_node"][$start_node]= 0;
        $curr_node= $start_node;

        step_3:
        echo "start step 3<br>\n";
        foreach ( $cost_list[$curr_node] as $next_node => $distEdge ) {
                if ( $cost["visited_node"][$next_node] != 1 ) {
                        $distTrial= $cost["dist_node"][$curr_node] + $distEdge;
                        $distPrev= $cost["dist_node"][$next_node];

                        if ( $distTrial < $distPrev ) {
                                $cost["dist_node"][$next_node]= $distTrial;
                                $cost["unvisited_node"][$next_node]= $distTrial;
                                $cost["prev_node"][$next_node]= $curr_node;
                        } // end of if ( $distTrial < $distPrev )

        step_4:
        echo "start step 4<br>\n";
                } // end of if ( $cost["visited_node"][$next_node] != 1 )
        } // end of foreach ( $cost_list[$curr_node] as $next_node => $distEdge )

        $cost["visited_node"][$curr_node]= 1;
        unset($cost["unvisited_node"][$curr_node]);
        echo "The minimum distance from $start_node to $curr_node is ".$cost["dist_node"][$curr_node]."<br>\n";

        step_5:
        echo "start step 5<br>\n";
        if ( count($cost["unvisited_node"]) == 0 ) {
                finish:
                echo "finish<br>\n";
                return array($cost["dist_node"],$cost["prev_node"]);
        }else {
                asort($cost["unvisited_node"]);
                $node_list= array_keys($cost["unvisited_node"]);
                $curr_node= $node_list[0];
        }

        goto step_3;

} // end of function dijkstra()

function min_path($end_node, $node_prev_list){
        $curr_node = $end_node;
        $prev_node = $node_prev_list[$curr_node];
                while ( strcmp($curr_node, $prev_node) ) {
                        $back_opt_path[] = $curr_node;
                        $curr_node = $prev_node;
                        $prev_node = $node_prev_list[$curr_node];
                }
        $back_opt_path[]= $curr_node;
        return $back_opt_path;
}

function serch_path($start_node, $end_node, $cost_list){
        list($dist_node_list, $node_prev_list) = dijkstra($start_node, $cost_list);
        return min_path($end_node, $node_prev_list);
}

        $result = serch_path($start_node, $end_node, $cost_list);
        var_dump($result);

# dist_node
# visited_node = 検証したノードかどうかのフラグ
# prev_node
# unvisited_node = 検証していないノードかどうかのフラグ
# back_opt_path = 最適経路
?>