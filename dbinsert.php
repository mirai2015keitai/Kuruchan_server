<html>
<head>
<title>PHP TEST</title>
</head>
<body>

<?php

$ID = (INT)1;
$SubID = (INT)0;
$Latitude = (DOUBLE)00.0000000;
$Longitude = (DOUBLE)000.0000000;
$Category = 'bump';
$Level = 'safe';

$db_kuru = mysql_connect('localhost', 'kurutest', 'kurutest');
if (!$db_kuru) {
    die('�ڑ����s�ł��B'.mysql_error());
}

print('<p>�ڑ��ɐ������܂����B</p>');

$db_select = mysql_select_db('kuru_test', $db_kuru);
if (!$db_select){
    die('�f�[�^�x�[�X�I�����s�ł��B'.mysql_error());
}

print('<p>Kuru_test�f�[�^�x�[�X��I�����܂����B</p>');

mysql_set_charset('utf8');

    print('<p>');
    print('ID='.$ID);
    print(',SubID='.$SubID);
    print(',Latitude='.$Latitude);
    print(',Longiitude='.$Longitude);
    print(',Category='.$Category);
    print(',Level='.$Level);
    print('</p>');

print('<p>���͂��ꂽ�f�[�^��}�����܂��D</p>');

$sql1 = sprintf("INSERT INTO LowRSC (ID, SubID, Latitude, Longitude, Category, Level) VALUES (%d, %d, %9.7f, %10.7f, '%s', '%s')", $ID, $SubID, $Latitude, $Longitude, $Category, $Level);
#$sql1 = "INSERT INTO LowRSC (ID, SubID, Latitude, Longitude, Category, Level) VALUES (1, 0, 11.1111111, 111.1111111, 'bumps', 'safe')";
$insert = mysql_query($sql1);
if (!$insert){
        print('<p>�f�[�^�̑}���Ɏ��s���܂����D</p>');
}


print('<p>�}�����ꂽ�f�[�^���폜���܂��D</p>');
$sql2 = sprintf("DELETE FROM LowRSC WHERE ID = %d", $ID);
$delete = mysql_query($sql2);
if (!$delete){
        print('<p>�f�[�^�̍폜�Ɏ��s���܂����D</p>');
}

$close_flag = mysql_close($db_kuru);

if ($close_flag){
    print('<p>�ؒf�ɐ������܂����B</p>');
}

?>
</body>
</html>