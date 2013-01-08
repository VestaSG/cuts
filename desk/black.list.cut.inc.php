<?php
$lOrders = $cutorderObj->load_closed_list();

for($it = 0; $it < $lOrders; ++$it) // &nbsp;
{
?>
<p class="bthetempl">
	<a href="<?=cut_http_edit ?>&amp;<?=UNIKEY ?>=<?=$cutorderObj->outid($it) ?>">
<?=$cutorderObj->out(TAB_CUTORDER_name, $it) ?></a>
</p>
<p class="edittempl"><?=$cutorderObj->out(TAB_CUTORDER_company, $it) ?></p>
<?php
}
?>
