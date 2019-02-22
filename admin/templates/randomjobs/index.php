<h3>Currently active Jobs</h3>

<table width="100%" class="tablesorter">
<thead>
<tr>
<th>Dep ICAO</th>
<th>Arr ICAO</th>
<th>Type</th>
<th>Job</th>
<th>Expiration</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php if(!$jobs)
{
	echo "<tr><td colspan='10'>No active Jobs</td></tr>";
}
else
foreach($jobs as $job)
{
	?>
<tr>
<td valign="top"><?php echo $job->depicao ?></td>
<td valign="top"><?php echo $job->arricao ?></td>
<td valign="top"><?php echo $job->jobtype ?></td>
<td valign="top"><?php echo $job->jobdescription ?></td>
<td valign="top"><?php echo $job->expirationtime ?></td>
<td valign="top"><?php if($job->booked == '0') { ?><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/deleteactivejob/'.$job->id); ?>';">Delete</button><?php } else { echo "Is Booked!"; } ?></td>
</tr>
<?php } ?>
</tbody>

</table>