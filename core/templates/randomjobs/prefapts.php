<h3>Request a job</h3>

<form method="post" action="<?php echo SITE_URL ?>/index.php/RandomJobs/requestnewjobs">

<label for="airport">Select your prefered departure airport!</label><br />
<select id="airport" name="airport">
<?php if($airports)
foreach($airports as $airport)
{
?>
<option value="<?php echo $airport->icao ?>"><?php echo $airport->icao ?> - <?php echo $airport->name ?></option>
<?php } ?>
</select><br /><br />

<label for="email">Want to be notified via email?</label><br />
<select id="email" name="email">
<option value="0">No</option>
<option value="1">Yes</option>
</select><br /><br /><br />

<input type="submit" value="Send Request" />
</form>