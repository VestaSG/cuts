<?php
// define("DIR_CONF", "../dir.conf.php");
?>
<?php
define("TEXTTAB", "text_tab");
// ���� ������� �������������
define("texttab_id", "id"); // id
define("texttab_head", "name"); // ���� ���������
define("texttab_body", "body"); // ����
define("texttab_in", "inid"); // ������, � ������� ������ �������� �����������
define("texttab_date", "dtt"); // ���� ��������
define("texttab_moddate", "moddtt"); // ���� ���������
define("texttab_ishid", "ishid"); // �������� �� ������ �������
define("texttab_attid", "attachid"); // ������������� �������������� �����
define("texttab_lang", "lang"); // ���� �������

// ������� ����
define("pub_tex_face", SITE_INDEX . "?pid=" . $mobj->outid());
define("pub_tex_addfile", pub_tex_face . "&amp;a=adf");
define("pub_tex_delfile", pub_tex_face . "&amp;a=df");
?>
