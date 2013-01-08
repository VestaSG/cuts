<div class="admmenu">
<table cellspacing="0" cellpadding="0" style="width:100%;">
	<tr>
		<td style="width:196px;"><div style="width:200px;">&nbsp;</div></td>
		<td style="width:auto;">
			<div class="left">
				<div style="font-family:verdana; font-size:10pt;">
					<a href="<?=SITE_INDEX ?>">В начало</a>
				</div>
			</div>
		</td>
		<td style="width:200px; vertical-align:top;">
			<div style=" /* background-color:#ffeeff; */ text-align:right; width:150px; float:right; padding:0; margin:0; padding-top:5pt;  padding-right:25pt; word-spacing:5pt;">
<?php
if(0 < $login_obj->out_stat())
{
?>
				<a href="<?=SITE_INDEX ?>?pid=<?=$mobj->outid() ?> ">read</a>
<?php
	if($freeset[$adressfree[$free_edit]]["is"])
	{
?>
				<a href="<?=SITE_INDEX ?>?pid=<?=$mobj->outid() ?>&edit=edit">edit</a>
<?php
	} else { echo("<span title=\"Нет права редактировать раздел\">edit</span> "); }
	if($freeset[$adressfree[$free_del]]["is"])
	{
?>
				<a href="<?=SITE_INDEX ?>?pid=<?=$mobj->outid() ?>&del=del">del</a>
<?php
	} else { echo("<span title=\"Нет права удалять раздел\">del</span>"); }
}
else
{
	echo("&nbsp;");
}
?>
			</div>
		</td>
	</tr>
</table>
<ul class="every">
	<li></li>
</ul>
</div>
