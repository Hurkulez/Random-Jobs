<h3>Job Details</h3>
Job ID: <?php echo $job->id ?><br />
From: <?php echo $job->depname ?> - <?php echo $job->depicao ?><br />
To: <?php echo $job->arrname ?> - <?php echo $job->arricao ?><br />
Expires at: <?php echo $job->expirationtime ?><br />
GC Distance: <?php echo $distance ?>nm<br />
Expected Revenue: <?php echo ($price * $job->paxnum) + ($price * $job->cargonum) ?>v$<br />
<br />
<?php echo $description; ?>


<?php if(Auth::LoggedIn() && RandomJobsData::checkpilotisbooked(Auth::$userinfo->pilotid) != true)
{ ?>
<br /><br />
<h3>Take Job</h3>
<form method="post" action="<?php echo SITE_URL ?>/index.php/RandomJobs/takejob/<?php echo $job->id ?>">

<label for="deptime">Estimated Departure Time (<?php echo $job->depicao ?>) : </label><br />
<select id="deptime" name="deptime">
<?php
$start = "00:00";
$end = "23:50";

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd){
	?>
  <option value="<?php echo date("H:i",$tNow) ?>"><?php echo date("H:i",$tNow) ?> UTC</option>
  <?php
  $tNow = strtotime('+10 minutes',$tNow);
}
?>
</select><br />
<label for="flighttime">Estimated Flighttime to (<?php echo $job->arricao ?>): </label><br />
<select id="flighttime" name="flighttime">
<?php
$start = "00:10";
$end = "10:00";

$tStart = strtotime($start);
$tEnd = strtotime($end);
$tNow = $tStart;

while($tNow <= $tEnd){
	?>
  <option value="<?php echo date("H:i",$tNow) ?>"><?php echo date("H:i",$tNow) ?></option>
  <?php
  $tNow = strtotime('+10 minutes',$tNow);
}
?>
</select><br />

<label for="flightlevel">Planned Cruise Flightlevel: </label><br />
<select id="flightlevel" name="flightlevel">
<?php
$start = "10";
$end = "430";

while($start <= $end){
	
	if($start < '100')
{
$start = '0'.$start;
}
	?>
  <option value="<?php echo $start ?>00">FL<?php echo $start ?></option>
  <?php
  $start = $start+5;
}
?>
</select><br />

<label for="aircraft">Select Aircraft for Flight: </label><br />
<select id="aircraft" name="aircraft">
<?php if($aircraft)
foreach($aircraft as $ac)
{ ?>
<option value="<?php echo $ac->id ?>"><?php echo $ac->name ?> (<?php echo $ac->registration ?>)</option>
<?php } ?>
</select>
<br />
<label for="route">Route: (optional)</label><br />
<textarea id="route" name="route" style="height:100px; width:500px"></textarea>

<br />
<label for="comments">Comments: (optional)</label><br />
<textarea id="comments" name="notes" style="height:100px; width:500px"></textarea>

<br /><br /><br />
<input type="hidden" name="distance" value="<?php echo $distance ?>" />
<input type="hidden" name="price" value="<?php echo $price ?>" />
<input type="submit" value="Take Job" />
</form>



<?php } ?>