<?php
define("PREF_TAB_CUTS", PREF_TAB . "cut_");
//--------------------------------------------
define("TAB_CUTORDER", PREF_TAB_CUTS . "order");

define("TAB_CUTORDER_name", "name");
define("TAB_CUTORDER_price", "price");
define("TAB_CUTORDER_company", "company");
define("TAB_CUTORDER_dt", "dt");
define("TAB_CUTORDER_tmc", "tmc");
define("TAB_CUTORDER_lcut", "lcut");
define("TAB_CUTORDER_w", "w");
define("TAB_CUTORDER_h", "h");
define("TAB_CUTORDER_th", "th");
define("TAB_CUTORDER_quanty", "quanty");
define("TAB_CUTORDER_scale", "scale");
define("TAB_CUTORDER_closed", "closed");
//--------------------------------------------
define("TAB_CUTDESKS", PREF_TAB_CUTS . "desk");

define("TAB_CUTDESKS_order", "orderid");
define("TAB_CUTDESKS_h", "h");
define("TAB_CUTDESKS_w", "w");
define("TAB_CUTDESKS_t", "t");
define("TAB_CUTDESKS_l", "l");
define("TAB_CUTDESKS_attantion", "attantion");
define("TAB_CUTDESKS_ingroup", "ingroup");
//--------------------------------------------

// Клиентские директории (HTTP)
define("cut_http_dir", SITE_INDEX . "?pid=" . $mobj->outid()); // Клиентский адрес
define("cut_http_edit", cut_http_dir . "&amp;a=edit"); // Редактирование
define("cut_http_do", cut_http_dir . "&amp;a=do"); // Редактирование (обработчик)
define("cut_http_jedit", cut_http_dir . "&amp;a=jedit"); // Редактирование схемы
define("cut_http_jdo", cut_http_dir . "&a=jdo");
define("cut_http_jdel", cut_http_dir . "&a=jdel");
define("cut_http_rtf", cut_http_dir . "&amp;a=rtf");
define("cut_http_lblack", cut_http_dir . "&a=lblack");
define("cut_http_2black", cut_http_dir . "&a=2b");
define("cut_http_form2black", cut_http_dir . "&a=f2b");
?>
