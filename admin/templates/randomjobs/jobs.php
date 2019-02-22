<h3>Job Templates</h3>
<table width="100%" class="tablesorter">
<thead>
<tr>
<th>ID</th>
<th>Type</th>
<th>Job</th>
<th>Edit</th>
<th>Delete</th>
</tr>
</thead>
<tbody>
<?php if(!$jobs)
{
	echo "<tr><td colspan='10'>No Jobs added</td></tr>";
}
else
foreach($jobs as $job)
{
	?>
<tr>
<td valign="top"><?php echo $job->id ?></td>
<td valign="top"><?php echo $job->jobtype ?></td>
<td valign="top"><?php echo $job->jobdescription ?></td>
<td valign="top"><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/editjob/'.$job->id); ?>';">Edit</button></td>
<td valign="top"><button class="{button:{icons:{primary:'ui-icon-grip-dotted-vertical'}}}" 
			onclick="window.location='<?php echo adminurl('/RandomJobs/deletejob/'.$job->id); ?>';">Delete</button></td>
</tr>
<?php } ?>
</tbody>

</table>