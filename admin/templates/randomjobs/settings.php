<h3>Random Job Creator Settings</h3>

<form method="post" action="<?php echo SITE_URL ?>/admin/index.php/RandomJobs/savesettings">

<label for="code">Airline 3 Letter Code to use for job schedules (The airline MUST exist in your phpvms airlines!)</label><br />
<input id="code" name="code" type="text" value="<?php echo $setting->code ?>" /><br /><br />

<label for="creationintmin">Interval for Job Creation (Minimum in Minutes)</label><br />
<input id="creationintmin" name="creationintmin" type="number" value="<?php echo $setting->creationintmin ?>" /><br /><br />

<label for="creationintmax">Interval for Job Creation (Maximum in Minutes)</label><br />
<input id="creationintmax" name="creationintmax" type="number" value="<?php echo $setting->creationintmax ?>" /><br /><br />

<label for="minexpiration">Minimum in Minutes a Job stays active for booking before it gets automatically deleted!</label><br />
<input id="minexpiration" name="minexpiration" type="number" value="<?php echo $setting->minexpiration ?>" /><br /><br />

<label for="maxexpiration">Maximum in Minutes a Job stays active for booking before it gets automatically deleted!</label><br />
<input id="maxexpiration" name="maxexpiration" type="number" value="<?php echo $setting->maxexpiration ?>" /><br /><br />

<label for="maxactivejobs">Maximum Active Jobs at any given time</label><br />
<input id="maxactivejobs" name="maxactivejobs" type="number" value="<?php echo $setting->maxactivejobs ?>" /><br /><br />

<label for="mindistance">Minimum Flight distance in NM</label><br />
<input id="mindistance" name="mindistance" type="number" value="<?php echo $setting->mindistance ?>" /><br /><br />

<label for="maxdistance">Maximum Flight distance in NM</label><br />
<input id="maxdistance" name="maxdistance" type="number" value="<?php echo $setting->maxdistance ?>" /><br /><br />

<label for="pilrequestmax">How many jobs shall be created from a pilot requested departure airport? (2 or 3 seems to be a reasonable value! Set to 0 to disable that feature entirely!)</label><br />
<input id="pilrequestmax" name="pilrequestmax" type="number" value="<?php echo $setting->pilrequestmax ?>" /><br /><br />

<label for="pilotrequestany">Allow pilots to request jobs from any location (If you have set the module to only create flights from/to specific airports setting this box to Yes will allow pilots to request jobs from any airport in your phpvms airports table. Not only the airports you have chosen for job creation! For the pilot request box to be active the value in the field above must be greater than 0) - This will still have the arrival airports restricted! Only the departure airport restriction will be lifted!</label><br />
<select id="pilotrequestany" name="pilotrequestany">
<?php if($setting->pilotrequestany == '1')
{
$sel7 = "selected";	
}
else
{
$sel8 = "selected";
}
?>
<option value="1" <?php echo $sel7 ?>>Yes</option>
<option value="0" <?php echo $sel8 ?>>No</option>
</select><br /><br />

<label for="restrictacrank">Aircraft rank restriction active (If set to no pilots can select any aircraft from your fleet when booking a flight created by this module regardless of his rank)</label><br />
<select id="restrictacrank" name="restrictacrank">
<?php if($setting->restrictacrank == '1')
{
$sel4 = "selected";	
}
else
{
$sel5 = "selected";
}
?>
<option value="1" <?php echo $sel4 ?>>Yes</option>
<option value="0" <?php echo $sel5 ?>>No</option>
</select><br /><br />

<label for="enabled">Enabled? (This can be used to disable new job creation)!</label><br />
<select id="enabled" name="enabled">
<?php if($setting->enabled == '1')
{
$sel1 = "selected";	
}
else
{
$sel2 = "selected";
}
?>
<option value="1" <?php echo $sel1 ?>>True</option>
<option value="0" <?php echo $sel2 ?>>False</option>
</select><br /><br /><br />

<input type="submit" value="Save Settings" />
</form>