<h3><?php echo $action ?></h3>

<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/RandomJobs/submitjob">
<blockquote>
Use the folowing placeholders in your text. The placeholders will be automatically replaced by the system when a job is created:<br /><br />
<strong>{departurename}</strong> = Departure Airport Name<br />
<strong>{departureicao}</strong> = Departure Airport ICAO<br />
<strong>{arrivalname}</strong> = Arrival Airport Name<br />
<strong>{arrivalicao}</strong> = Arrival Airport ICAO<br />
<strong>{passengernum}</strong> = Number of Passengers for flight<br />
<strong>{cargonum}</strong> = Cargo Weight for flight<br />
<strong>{expirationtime}</strong> = Date/Time when the job expires and will automatically get deleted if not booked<br />
</blockquote><br /><br />

<label for="jobtype">Job Category</label><br />
<select id="jobtype" name="jobtype">
<?php if($job->jobtype == 'PC')
{
$sel3 = "selected";	
}
elseif($job->jobtype == 'C')
{
$sel2 = "selected";
}
else
{
$sel1 = "selected";	
}
?>
<option value="P" <?php echo $sel1 ?>>Passenger</option>
<option value="C" <?php echo $sel2 ?>>Cargo</option>
<option value="PC" <?php echo $sel3 ?>>Passenger & Cargo</option>
</select><br /><br />

<label for="depairport">OPTIONAL: If you want to use this only for flights from a specific departure airport then enter it's ICAO code here! to use the template for all airports leave this field blank!</label><br />
<input id="depairport" name="depairport" type="text" value="<?php echo $job->depairport ?>" />
<br /><br />

<label for="jobdescription">Job Description</label><br />
<textarea style="height:250px; width:800px;" id="jobdescription" name="jobdescription"><?php echo $job->jobdescription ?></textarea>
<br /><br /><br />

<input type="hidden" name="id" value="<?php echo $job->id ?>" />
<input type="hidden" name="action" value="<?php echo $action ?>" />
<input type="submit" value="<?php echo $action ?>" />
<br /><br />
</form>