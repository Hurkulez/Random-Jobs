<h3>Airports</h3>
<?php if($setting->allairports == '1') { ?>The System is set to use all airports for flight creation! <a href="<?php echo SITE_URL ?>/admin/index.php/randomjobs/dontuseallairports">Click to switch to use only airports from list below!</a><?php } else { ?>The system is set to use only airports from the list below! <a href="<?php echo SITE_URL ?>/admin/index.php/randomjobs/useallairports">Click to switch to use all airports in your database for flightcreation!</a><?php } ?>
<br />
<hr />
<br />
<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/RandomJobs/addairport">
<select id="airport" name="airport">
<?php foreach($allairports as $ap)
{
?>
<option value="<?php echo $ap->icao ?>"><?php echo $ap->icao ?> (<?php echo $ap->name ?>)</option>
<?php } ?>
</select>
<input type="submit" value="Add Airport" />
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
<th>Restrict Arrivals*</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php if(!$airports)
{
	echo "<tr><td colspan='10'>No airports added!</td></tr>";
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
			onclick="window.location='<?php echo adminurl('/RandomJobs/restrictarrivals/'.$ap->icao); ?>';">Add Arrival Airports (<?php echo count(RandomJobsData::getarrivalrestrictions($ap->icao)) ?>)</button></td>
<td valign="top"><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/deleteairport/'.$ap->arid); ?>';">Delete</button></td>
</tr>
<?php } ?>
</tbody>

</table>
<br />
<hr />
* OPTIONAL: You can restrict arrival airports for each created flight. This will force the module to create flights to the selected arrival airports ONLY! The arrival restrictions will only be active for the departure airport they have been added to! To not use arrival restrictions simply dont add any arrival airports to the departure airport in the list above.