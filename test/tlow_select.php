<?php
  $url = "localhost";
  $user = "kurutest";
  $pass = "kurutest";
  $db = "kuru_test";

  // MySQL�֐ڑ�����
  $link = mysql_connect($url,$user,$pass) or die("MySQL�ւ̐ڑ��Ɏ��s���܂����B");

  // �f�[�^�x�[�X��I������
  $sdb = mysql_select_db($db,$link) or die("�f�[�^�x�[�X�̑I���Ɏ��s���܂����B");

  // �N�G���𑗐M����
  $sql = "SELECT * FROM tLowRSC";
  $result = mysql_query($sql, $link) or die("�N�G���̑��M�Ɏ��s���܂����B<br />SQL:".$sql);

  //���ʃZ�b�g�̍s�����擾����
  $rows = mysql_num_rows($result);

  //�\������f�[�^���쐬
  if($rows){
    while($row = mysql_fetch_array($result)) {
      $tempHtml .= "<tr>";
      $tempHtml .= "<td>".$row["st_lat"]."</td><td>".$row["st_lng"]."</td><td>".$row["en_lat"]."</td>
                    <td>".$row["en_lng"]."</td><td>".$row["no_dump"]."</td><td>".$row["high_dump"]."</td>";
      $tempHtml .= "</tr>\n";
    }
    $msg = $rows."���̃f�[�^������܂��B";
  }else{
    $msg = "�f�[�^������܂���B";
  }

  //���ʕێ��p���������J������
  mysql_free_result($result);

  // MySQL�ւ̐ڑ������
  mysql_close($link) or die("MySQL�ؒf�Ɏ��s���܂����B");
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