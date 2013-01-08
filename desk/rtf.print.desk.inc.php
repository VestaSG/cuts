<?php
ini_set("memory_limit", "500M");
ini_set("max_execution_time", "1200");


$cutorderObj->load($_GET[UNIKEY]);
$cutId = $cutorderObj->outid();
$deskCount = $cutunitObj->load_for_order( $cutId );

include_once(DESK_MODUL . "/desk.class.php");
include(DESK_MODUL . "/calc.print.desk.init.php");

// PNG поехали: ---------------------------------------------
$img = imageCreate($cutorderObj->out(TAB_CUTORDER_w), $cutorderObj->out(TAB_CUTORDER_h));
include(DESK_MODUL . "/desk.conf.php");

$cnv = new canv_desk( $cutorderObj->out(TAB_CUTORDER_w), $cutorderObj->out(TAB_CUTORDER_h), $img );
for($i = 0; $i < $deskCount; ++$i)
{
	$cnv->addDesk($cutunitObj->out(TAB_CUTDESKS_l, $i), $cutunitObj->out(TAB_CUTDESKS_t, $i), $cutunitObj->out(TAB_CUTDESKS_w, $i), $cutunitObj->out(TAB_CUTDESKS_h, $i));
}
// Добавление резов на схему
if(0)
{
	for($i = 0; $i < $qcuts; ++$i)
	{
		$cnv->addLine($cuts[$i]["x0"], $cuts[$i]["y0"], $cuts[$i]["x"], $cuts[$i]["y"]);
	}
}
// END: Добавление резов на схему

$cnv->drawDesk($img);

// header("Content-type: image/gif");
// header("cache-control: no-cache");
imagepng($img, DESK_MODUL . "/ord".$cutorderObj->outid().".png");
// PNG: end -------------------------------------------------

// PNG2 с резами поехали: ---------------------------------------------
if(TRASS_CUT_IMG)
{
	$img2 = imageCreate($cutorderObj->out(TAB_CUTORDER_w), $cutorderObj->out(TAB_CUTORDER_h));
	$cnv = new canv_desk( $cutorderObj->out(TAB_CUTORDER_w), $cutorderObj->out(TAB_CUTORDER_h), $img2 );
	// Добавление резов на схему
	for($i = 0; $i < $qcuts; ++$i)
	{
		$cnv->addLine($cuts[$i]["x0"], $cuts[$i]["y0"], $cuts[$i]["x"], $cuts[$i]["y"]);
	}
	// END: Добавление резов на схему

	$cnv->drawDesk($img2, true /* is wite */);
	imagepng($img2, DESK_MODUL . "/ord".$cutorderObj->outid()."2.png");
}
// PNG2: end -------------------------------------------------

require_once(RTF_LIB_DIR . "/Rtf.php");
// RTF поехали: ---------------------------------------------
$rtf = new Rtf();

$sect = &$rtf->addSection();
$sect->setMargins(2.5, 1.5, 1.5, 1.5);

$prt = new ParFormat("left"); $fnt = new Font(14, "arial");
$prt->setSpaceAfter(6);
$sect->writeText("<b>Приложение № 1 к Договору-счету " .iconv("windows-1251", "UTF-8", html_entity_decode($cutorderObj->out(TAB_CUTORDER_name), ENT_QUOTES) ). "</b>", $fnt, $prt);
$prt->setSpaceAfter(0);
$prt->setIndentLeft(0.15);
$prt->setIndentRight(0.15);
$table = &$sect->addTable();
$table->addRows(5, 0.5);
$table->addColumnsList(array(8.5, 8.5));
$table->setVerticalAlignmentOfCells("center", 1, 1, 5, 2); // вертикальное выравнивание в ячейках
$tabfont = new Font(10, "arial");
$table->writeToCell(1, 1, "Дата", $tabfont, $prt);
$table->writeToCell(2, 1, "Наименование товара", $tabfont, $prt);
$table->writeToCell(3, 1, "Габариты исходной заготовки", $tabfont, $prt);
$table->writeToCell(4, 1, "Количество исходных заготовок", $tabfont, $prt);
$table->writeToCell(5, 1, "Покупатель", $tabfont, $prt);
$table->writeToCell(1, 2, $cutorderObj->out(TAB_CUTORDER_dt), $tabfont, $prt);
$table->writeToCell(2, 2, iconv("windows-1251", "UTF-8", html_entity_decode($cutorderObj->out(TAB_CUTORDER_tmc), ENT_QUOTES) ), $tabfont, $prt);
$table->writeToCell(3, 2, $cutorderObj->out(TAB_CUTORDER_h). "x".$cutorderObj->out(TAB_CUTORDER_w) . "x" . $cutorderObj->out(TAB_CUTORDER_th), $tabfont, $prt);
$table->writeToCell(4, 2, $cutorderObj->out(TAB_CUTORDER_quanty), $tabfont, $prt);
$table->writeToCell(5, 2, iconv("windows-1251", "UTF-8", html_entity_decode($cutorderObj->out(TAB_CUTORDER_company), ENT_QUOTES) ), $tabfont, $prt);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 1, 5, 2);

$shpart = new ParFormat("center");
$shpart->setSpaceAfter(24);
$sect->writeText("<b>Схема распиловки.</b>", $fnt, $shpart);
$sect->writeText("", $fnt, new ParFormat("center"));

$prt->setSpaceBefore(24);
$prt->setSpaceAfter(6);
$sect->addImage(DESK_MODUL . "/ord".$cutorderObj->outid().".png", $client, 17);

$sect->writeText("<b>Перечень и количество деталей:</b>", $tabfont, $prt);
// Таблица перечня
$table = &$sect->addTable();
$table->addColumnsList(array(1.5, 13.5, 2));
$listprt = new ParFormat("left");
$listprt->setIndentLeft(0.15);

// Группы
$nowgr = 1;
$thesameiter = 0;
$nowrow = 1;
for($i = 0; $i < $deskCount; ++$i)
{
	if(0 == $i)
	{
		$nowgr = $cutunitObj->out(TAB_CUTDESKS_ingroup, $i);
	}
	if( ( $nowgr != $cutunitObj->out(TAB_CUTDESKS_ingroup, $i) ) || ((1+$i) == $deskCount) )
	{
		if( $nowgr != $cutunitObj->out(TAB_CUTDESKS_ingroup, $i) )
		{
			$table->addRows(1, 0.3);
			$table->writeToCell($nowrow, 1, $nowrow, $tabfont, $listprt);
			$table->writeToCell($nowrow, 2, $cutorderObj->out(TAB_CUTORDER_th) . "x" .$cutunitObj->out(TAB_CUTDESKS_h, $i-1). "x".$cutunitObj->out(TAB_CUTDESKS_w, $i-1), $tabfont, $listprt);
			$table->writeToCell($nowrow, 3, ( $cutorderObj->out(TAB_CUTORDER_quanty) * $thesameiter )." шт.", $tabfont, $listprt);

			++$nowrow;
			$thesameiter = 0;
			$nowgr = $cutunitObj->out(TAB_CUTDESKS_ingroup, $i);
		}
		if((1+$i) == $deskCount)
		{
			$table->addRows(1, 0.3);
			$table->writeToCell($nowrow, 1, $nowrow, $tabfont, $listprt);
			$table->writeToCell($nowrow, 2, $cutorderObj->out(TAB_CUTORDER_th) . "x" .$cutunitObj->out(TAB_CUTDESKS_h, $i). "x".$cutunitObj->out(TAB_CUTDESKS_w, $i), $tabfont, $listprt);
			$table->writeToCell($nowrow, 3, ( $cutorderObj->out(TAB_CUTORDER_quanty) * ($thesameiter + 1) )." шт.", $tabfont, $listprt);
//			++$nowrow;
		}
	}
	++$thesameiter;

//	$cnv->addDesk($cutunitObj->out(TAB_CUTDESKS_l, $i), $cutunitObj->out(TAB_CUTDESKS_t, $i), $cutunitObj->out(TAB_CUTDESKS_w, $i), $cutunitObj->out(TAB_CUTDESKS_h, $i));
}
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 1, $nowrow, 3);
// END: Таблица перечня

// Параметры резов
$prt->setSpaceBefore(6);
$prt->setSpaceAfter(0);
$table = &$sect->addTable();
$table->addRows(1, 0.3);
$table->addColumnsList(array(17));
$table->writeToCell(1, 1, "<u>Количество резов:</u> $qcuts шт", $tabfont, $prt);
$prt->setSpaceBefore(0);
$table->writeToCell(1, 1, "<u>Длина резов:</u> $lcuts м", $tabfont, $prt);
$prt->setSpaceAfter(6);
$table->writeToCell(1, 1, "<u>Стоимость резов:</u> $costcuts руб.", $tabfont, $prt);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 1, 1, 1);
$table->setBordersOfCells(new BorderFormat(0, "#ffffff"), 1, 1, 1, 1, true, false, true, false); // left, top, right, bottom // Убрать границы
// END: Параметры резов

$prt->setSpaceBefore(6);
$table = &$sect->addTable();
$table->addRows(1, 0.3);
$table->addColumnsList(array(17));
$table->writeToCell(1, 1, "<u>Примечания:</u>", $tabfont, $prt);
$prt->setSpaceBefore(0);
$prt->setSpaceAfter(0);
$table->writeToCell(1, 1, "1. Безвозвратные потери в стружку от дисковой пилы на один разрез составляют 4-5 мм.", $tabfont, $prt);
$table->writeToCell(1, 1, "2. Погрешности резки листов и плит составляют +/-2 мм при толщине листов 2–20 мм.", $tabfont, $prt);
$table->writeToCell(1, 1, "3. Погрешности резки листов и плит составляют +/-3 мм при толщине листов 21-100 мм.", $tabfont, $prt);
$prt->setSpaceAfter(6);
$table->writeToCell(1, 1, "4. Погрешности резки втулок диаметром до 350 мм и стержней диаметром до 250 мм составляют: допуск по ширине +/- 2 мм; не параллельность торцов +/-3 мм.", $tabfont, $prt);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 1, 1, 1);
$table->setBordersOfCells(new BorderFormat(0, "#ffffff"), 1, 1, 1, 1, true, false, true, false); // left, top, right, bottom // Убрать границы

// Подписи
$prttop = new ParFormat("center");
$prttop->setSpaceBefore(6);
$prtsub = new ParFormat("center");
$fnttop = new Font(10, "arial");
$fntsub = new Font(8, "arial");

$sect->writeText("М. П.", new Font(12, "arial"), new ParFormat("right"));
$table = &$sect->addTable();
$table->addColumnsList(array(2.5, 4.5, 3.5, 4, 2.5));
$table->addRows(2, 0.3);
$table->mergeCells(1, 1, 2, 1); // mergeCells($startRow, $startColumn, $endRow, $endColumn) // Объединение ячеек
$table->writeToCell(1, 1, "Покупатель", $fnttop, $prttop);
$table->writeToCell(1, 2, "Генеральный директор", $fnttop, $prttop);
$table->writeToCell(2, 2, "должность", $fntsub, $prtsub);
$table->writeToCell(2, 3, "подпись", $fntsub, $prtsub);
$table->writeToCell(2, 4, "Ф.И.О.", $fntsub, $prtsub);
$table->writeToCell(2, 5, "дата", $fntsub, $prtsub);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 2, 1, 5, false, false, false, true); // left, top, right, bottom // Убрать границы

$table = &$sect->addTable();
$table->addColumnsList(array(2.5, 4.5, 3.5, 4, 2.5));
$table->addRows(2, 0.3);
$table->mergeCells(1, 1, 2, 1); // mergeCells($startRow, $startColumn, $endRow, $endColumn) // Объединение ячеек
$table->writeToCell(1, 1, "Принято", $fnttop, $prttop);
$table->writeToCell(1, 2, "Менеджер", $fnttop, $prttop);
$table->writeToCell(2, 2, "должность", $fntsub, $prtsub);
$table->writeToCell(2, 3, "подпись", $fntsub, $prtsub);
$table->writeToCell(2, 4, "Ф.И.О.", $fntsub, $prtsub);
$table->writeToCell(2, 5, "дата", $fntsub, $prtsub);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 2, 1, 5, false, false, false, true); // left, top, right, bottom // Убрать границы

$table = &$sect->addTable();
$table->addColumnsList(array(2.5, 4.5, 3.5, 4, 2.5));
$table->addRows(2, 0.3);
$table->mergeCells(1, 1, 2, 1); // mergeCells($startRow, $startColumn, $endRow, $endColumn) // Объединение ячеек
$table->writeToCell(1, 1, "Согласовано ", $fnttop, $prttop);
$table->writeToCell(1, 2, "Начальник цеха", $fnttop, $prttop);
$table->writeToCell(2, 2, "должность", $fntsub, $prtsub);
$table->writeToCell(2, 3, "подпись", $fntsub, $prtsub);
$table->writeToCell(2, 4, "Ф.И.О.", $fntsub, $prtsub);
$table->writeToCell(2, 5, "дата", $fntsub, $prtsub);
$table->setBordersOfCells(new BorderFormat(1, "#000000"), 1, 2, 1, 5, false, false, false, true); // left, top, right, bottom // Убрать границы
// END: Подписи

// Страница трассировок распилов
if(TRASS_CUT_IMG)
{
	$sect->insertPageBreak();
	$sect->addImage(DESK_MODUL . "/ord".$cutorderObj->outid()."2.png", $client, 17);
}
if(TRASS_CUT_LOG)
{
	$sect->insertPageBreak();
	$shpart = new ParFormat("left");
	$shpart->setSpaceAfter(12);
	$listprt->setIndentLeft(0);
	$sect->writeText("<b>Трассировка резов.</b>", $fnt, $shpart);
	$ltrass = count($trasslog);
	for($i = 0; $i < $ltrass; ++$i)
	{
		$sect->writeText($trasslog[$i], $tabfont, $listprt);
	}
}

// $sect->writeText("Расход оперативной памяти [Б]: " . memory_get_usage(), $tabfont, $listprt); // Расход оперативки

// $rtf->save(dirname(__FILE__) . "/cut.rtf");
$rtf->sendRtf($cutorderObj->out(TAB_CUTORDER_name));
// END: RTF
unlink(DESK_MODUL . "/ord".$cutorderObj->outid().".png"); // Удаление картинки
unlink(DESK_MODUL . "/ord".$cutorderObj->outid()."2.png"); // Удаление картинки с резами
?>
