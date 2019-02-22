<h3>Aircraft</h3>
<?php if($setting->allaircraft == '1') { ?>The System is set to allow all aircraft in your fleet to be chosen for booking! <a href="<?php echo SITE_URL ?>/admin/index.php/randomjobs/dontuseallaircraft">Click to switch to allow only aircraft from list below for selection!</a><?php } else { ?>The system is set to allow only aircraft from the list below to be chosen for booking! <a href="<?php echo SITE_URL ?>/admin/index.php/randomjobs/useallaircraft">Click to switch to allow all aircraft in your fleet for selection!</a><?php } ?>
<br />
<hr />
<br />
<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/RandomJobs/addaircraft">
<select id="aircraftid" name="aircraftid">
<?php foreach($allaircraft as $ac)
{
?>
<option value="<?php echo $ac->id ?>"><?php echo $ac->name ?> (<?php echo $ac->registration ?>)</option>
<?php } ?>
</select>
<input type="submit" value="Add Aircraft" />
</form>
<br />
<hr />
<br />
<table width="100%" class="tablesorter">
<thead>
<tr>
<th>ICAO</th>
<th>Name</th>
<th>Registration</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php if(!$aircraft)
{
	echo "<tr><td colspan='10'>No aircraft added!</td></tr>";
}
else
foreach($aircraft as $ac)
{
	?>
<tr>
<td valign="top"><?php echo $ac->icao ?></td>
<td valign="top"><?php echo $ac->name ?></td>
<td valign="top"><?php echo $ac->registration ?></td>
<td valign="top"><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/deleteaircraft/'.$ac->acid); ?>';">Delete</button></td>
</tr>
<?php } ?>
</tbody>

</table>
