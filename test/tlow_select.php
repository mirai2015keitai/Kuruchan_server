<?php
  $url = "localhost";
  $user = "kurutest";
  $pass = "kurutest";
  $db = "kuru_test";

  // MySQLへ接続する
  $link = mysql_connect($url,$user,$pass) or die("MySQLへの接続に失敗しました。");

  // データベースを選択する
  $sdb = mysql_select_db($db,$link) or die("データベースの選択に失敗しました。");

  // クエリを送信する
  $sql = "SELECT * FROM tLowRSC";
  $result = mysql_query($sql, $link) or die("クエリの送信に失敗しました。<br />SQL:".$sql);

  //結果セットの行数を取得する
  $rows = mysql_num_rows($result);

  //表示するデータを作成
  if($rows){
    while($row = mysql_fetch_array($result)) {
      $tempHtml .= "<tr>";
      $tempHtml .= "<td>".$row["st_lat"]."</td><td>".$row["st_lng"]."</td><td>".$row["en_lat"]."</td>
                    <td>".$row["en_lng"]."</td><td>".$row["no_dump"]."</td><td>".$row["high_dump"]."</td>";
      $tempHtml .= "</tr>\n";
    }
    $msg = $rows."件のデータがあります。";
  }else{
    $msg = "データがありません。";
  }

  //結果保持用メモリを開放する
  mysql_free_result($result);

  // MySQLへの接続を閉じる
  mysql_close($link) or die("MySQL切断に失敗しました。");
?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=SHIFT-JIS">
    <title>SELECT * FROM tLowRSC</title>
  </head>
  <body>
    <h3>ALL DATA</h3>
    <?= $msg ?>
    <table width = "200" border = "0">
      <tr bgcolor="##ccffcc"><td>st_lat</td><td>st_lng</td><td>en_lat</td><td>en_lng</td><td>no_dump</td><td>high_dump</td></tr>
      <?= $tempHtml ?>
    </table>
  </body>
</html>