<h3>Arrival Restrictions for <?php echo $icao ?></h3>
<a href="<?php echo SITE_URL ?>/admin/index.php/randomjobs/airports">back to airports</a><br /><br />
To not use arrival restrictions for <?php echo $icao ?> make sure the table below contains no data! Note that arrival restrictions will also override the min/max distance setting for flight creation. The system will randomly pick one of the airports in the list below ignoring the distance from <?php echo $icao ?>!<br />
<hr />
<br />
<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/RandomJobs/addarrival">
<select id="airport" name="airport">
<?php foreach($allairports as $ap)
{
?>
<option value="<?php echo $ap->icao ?>"><?php echo $ap->icao ?> (<?php echo $ap->name ?>)</option>
<?php } ?>
</select>
<input type="hidden" name="micao" value="<?php echo $icao ?>" />
<input type="submit" value="Add Arrival Airport" />
</form>
<br />
<hr />
<br />
<table width="100%" class="tablesorter">
<thead>
<tr>
<th>ICAO</th>
<th>Name</th>
<th>Country</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php if(!$airports)
{
	echo "<tr><td colspan='10'>No arrival airports added! System will use all available airports for flight creation </td></tr>";
}
else
foreach($airports as $ap)
{
	?>
<tr>
<td valign="top"><?php echo $ap->icao ?></td>
<td valign="top"><?php echo $ap->name ?></td>
<td valign="top"><?php echo $ap->country ?></td>
<td valign="top"><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/deletearrival/'.$ap->arid.'?micao='.$icao); ?>';">Delete</button></td>
</tr>
<?php } ?>
</tbody>

</table>