<div class="admmenu">
<table cellspacing="0" cellpadding="0">
	<tr>
		<td class="tdleft"></td>
		<td class="tdcenter">
			<div class="left">
				<div><?=$toptext ?></div>
				<br style="clear:both; line-height:0;" />
				<div>
					<ul>
						<li><a href="<?=SITE_INDEX ?>">� ������</a></li>
<?php
if(0 < $userstat)
{
?>
						<li><a href="<?=NEWPART_INDEX ?>">������� ������</a></li>
						<li><a href="<?=NEWUSER_INDEX ?>">������� ������������</a></li>
						<!-- <li><a href="<?=adm_pub_hr ?>">�����</a></li> -->
<?php
}
?>
					</ul>
				</div>
			</div>
		</td>
		<td class="tdright">
			<div style=" /* background-color:#ffeeff; */ text-align:right; width:150px; float:right; padding:0; margin:0; padding-top:5pt;  padding-right:25pt; word-spacing:5pt;">edit <a href="#">read</a></div>
		</td>
	</tr>
</table>
</div>
