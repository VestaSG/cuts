<?php
// HTTP-����������
define("adm_pub_dir", SITE_INDEX . "?pid=" . $mobj->outid()); // ����� �������
define("adm_pub_hr", adm_pub_dir . "&amp;a=hr"); // �����. u=1 - ������������, p=1 - ������
define("adm_pub_userdo", adm_pub_dir . "&amp;a=udo" ); // ���������� ������������
define("adm_pub_rightsdo", adm_pub_hr . "&amp;b=do" ); // ���������� ����

// ����� ����������
define("user_id", "u");
define("part_id", "p");
define("err", "err");

// ������
define("user_err", "1"); // ��� ������������
define("part_err", "2"); // ��� �������
define("free_err", "3"); // ��� �����
?>
