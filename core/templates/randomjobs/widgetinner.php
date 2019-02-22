<?php if($jobs)
foreach($jobs as $job) { 

$to_time = strtotime($job->expirationtime);
$from_time = strtotime(gmdate('Y-m-d H:i:s'));
$minutesleft = round(abs($to_time - $from_time) / 60);

?>

<?php if($job->jobtype == 'P') { echo "Passenger"; } elseif($job->jobtype == 'C') { echo "Cargo"; } else { echo "Pax & Cargo"; } ?>
<br />
<?php echo $job->depicao ?> - <?php echo $job->arricao ?>
<br />
<div><?php echo $minutesleft ?> minutes left</div>
<a href="<?php echo url('/randomjobs/jobdetail/'); echo $job->id; ?>">Job Details</a>
<br />
<br />
<?php } ?>