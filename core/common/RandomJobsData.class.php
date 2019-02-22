<?php
class RandomJobsData extends CodonModule
	{
		public static function getsettings()
		{
			$sql="SELECT * FROM randomjobs_settings WHERE id = '1'";
			return DB::get_row($sql);
		}
		
		public static function getjobs()
		{
			$sql="SELECT * FROM randomjobs_jobtemplates";
			return DB::get_results($sql);
		}
		
		public static function getcurrentjobs()
		{
			$sql="SELECT j.*, t.jobtype, t.jobdescription, d.name as depname, a.name as arrname, d.icao as depicao, a.icao as arricao FROM randomjobs_activejobs j LEFT JOIN ".TABLE_PREFIX."airports d ON d.icao = j.depicao LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.arricao LEFT JOIN randomjobs_jobtemplates t ON j.jobid = t.id";
			return DB::get_results($sql);
		}
		
		public static function getnobookedjobs()
		{
			$sql="SELECT j.*, t.jobtype, t.jobdescription, d.name as depname, a.name as arrname, d.icao as depicao, a.icao as arricao FROM randomjobs_activejobs j LEFT JOIN ".TABLE_PREFIX."airports d ON d.icao = j.depicao LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.arricao LEFT JOIN randomjobs_jobtemplates t ON j.jobid = t.id WHERE booked = '0' ORDER BY expirationtime ASC";
			return DB::get_results($sql);
		}
		
		public static function getjobdetail($id)
		{
			$sql="SELECT j.*, t.jobtype, t.jobdescription, d.name as depname, a.name as arrname, d.icao as depicao, a.icao as arricao FROM randomjobs_activejobs j LEFT JOIN ".TABLE_PREFIX."airports d ON d.icao = j.depicao LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.arricao LEFT JOIN randomjobs_jobtemplates t ON j.jobid = t.id WHERE j.id = '$id'";
			return DB::get_row($sql);
		}
		
		public static function getbookaircraft()
		{
			
		$setting = self::getsettings();
		
		if($setting->allaircraft == '1')
		{
		return self::getbookaircraftall();
		}
			
		if($setting->restrictacrank == '1')
		{
		    $userranklvl = Auth::$userinfo->ranklevel;
		}
		else
		{
			$userranklvl = '99999999';
		}
		
			$sql="SELECT j.aircraft, a.* FROM randomjobs_aircraft j LEFT JOIN ".TABLE_PREFIX."aircraft a ON a.id = j.aircraft WHERE a.enabled != '0' AND (a.ranklevel <= '$userranklvl' OR a.ranklevel = '0') ORDER BY a.icao ASC";
			return DB::get_results($sql);
			
		}
		
		public static function getbookaircraftall()
		{
			
		$setting = self::getsettings();
			
		if($setting->restrictacrank == '1')
		{
		    $userranklvl = Auth::$userinfo->ranklevel;
		}
		else
		{
			$userranklvl = '99999999';
		}
		
			$sql="SELECT * FROM ".TABLE_PREFIX."aircraft WHERE enabled != '0' AND (ranklevel <= '$userranklvl' OR ranklevel = '0') ORDER BY icao ASC";
			return DB::get_results($sql);
			
		}
		
		public static function getjobaircraft()
		{
			$sql="SELECT j.aircraft, j.id as acid, a.* FROM randomjobs_aircraft j LEFT JOIN ".TABLE_PREFIX."aircraft a ON a.id = j.aircraft WHERE a.enabled != '0' ORDER BY a.icao ASC";
			return DB::get_results($sql);
			
		}
		
		public static function getallaircraft()
		{
			$sql="SELECT * FROM ".TABLE_PREFIX."aircraft WHERE enabled != '0' ORDER BY icao ASC";
			return DB::get_results($sql);
			
		}
		
		public static function getjob($id)
		{
			$sql="SELECT * FROM randomjobs_jobtemplates WHERE id = '$id'";
			return DB::get_row($sql);
		}
		
		public static function savesettings($creationintmin, $creationintmax, $minexpiration, $maxexpiration, $maxactivejobs, $enabled, $mindistance, $maxdistance, $pilrequestmax, $code, $restrictacrank, $pilotrequestany)
		{
			$sql="UPDATE randomjobs_settings SET creationintmin = '$creationintmin', creationintmax = '$creationintmax', minexpiration = '$minexpiration', maxexpiration = '$maxexpiration', maxactivejobs = '$maxactivejobs', enabled = '$enabled', mindistance = '$mindistance', maxdistance = '$maxdistance', pilrequestmax = '$pilrequestmax', code = '$code', restrictacrank = '$restrictacrank', pilotrequestany = '$pilotrequestany' WHERE id = '1'";
			DB::query($sql);
		}
		
		public static function getjobairports()
		{
		
			$sql="SELECT j.airport, j.id as arid, a.* FROM randomjobs_airports j LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.airport ORDER BY j.airport ASC";
			return DB::get_results($sql);
		}
		
			public static function getarrivalrestrictions($departure)
		{
		
			$sql="SELECT j.arrival, j.id as arid, a.* FROM randomjobs_arrival_airports j LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.arrival WHERE j.departure = '$departure' ORDER BY j.arrival ASC";
			return DB::get_results($sql);
		}
		
		public static function changeuseallapt($aptvalue)
		{
			$sql="UPDATE randomjobs_settings SET allairports = '$aptvalue' WHERE id = '1'";
			DB::query($sql);
		}
		
		public static function changeuseallacrft($acftvalue)
		{
			$sql="UPDATE randomjobs_settings SET allaircraft = '$acftvalue' WHERE id = '1'";
			DB::query($sql);
		}
		
		public static function createnewpilotrequest($pilrequestmax, $pilotid, $airport, $email)
		{
			$sql="INSERT INTO randomjobs_prefairports (icao, remain, pilotid, emailnotify) VALUES('$airport','$pilrequestmax', '$pilotid', '$email')";
			DB::query($sql);
		}
		
		public static function getallairports()
		{
			$setting = self::getsettings();
		
		if($setting->allairports == '1' || $setting->pilotrequestany == '1')
		{
		return self::getallairportsnolim();
		}
		
			$sql="SELECT j.airport, a.* FROM randomjobs_airports j LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.airport ORDER BY a.icao ASC";
			return DB::get_results($sql);
		}
		
			public static function getallairportsforarrival()
		{
			$setting = self::getsettings();
		
		if($setting->allairports == '1')
		{
		return self::getallairportsnolim();
		}
		
			$sql="SELECT j.airport, a.* FROM randomjobs_airports j LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.airport ORDER BY a.icao ASC";
			return DB::get_results($sql);
		}
		
		
		public static function getallairportsnolim()
		{
			$sql="SELECT * FROM ".TABLE_PREFIX."airports ORDER BY icao ASC";
			return DB::get_results($sql);
		}
		
		public static function checkaptrequestspilot($pilotid)
		{
			$sql="SELECT * FROM randomjobs_prefairports WHERE pilotid = '$pilotid'";
			return DB::get_results($sql);
		}
		
		public static function getrandomrequest()
		{
			$sql="SELECT * FROM randomjobs_prefairports ORDER BY RAND() LIMIT 1";
			return DB::get_row($sql);
		}
		
		public static function decreaserequest($id)
		{
			$sql="UPDATE randomjobs_prefairports SET remain = remain - 1 WHERE id = '$id'";
			DB::query($sql);
		}
		
		public static function deleterandexpired()
		{
			$sql="DELETE FROM randomjobs_prefairports WHERE remain < '1'";
			DB::query($sql);
		}
		
			public static function checkaptrequestsapt($airport)
		{
			$sql="SELECT * FROM randomjobs_prefairports WHERE airport = '$airport'";
			return DB::get_results($sql);
		}
		
			public static function updatelastcreation()
		{
			$gmttime = gmdate('Y-m-d H:i:s');
			$sql="UPDATE randomjobs_settings SET lastcreation = '$gmttime' WHERE id = '1'";
			DB::query($sql);
		}
		
			public static function expirejobs()
		{
			$gmttime = gmdate('Y-m-d H:i:s');
			$sql="DELETE FROM randomjobs_activejobs WHERE expirationtime < '$gmttime' AND booked = '0'";
			DB::query($sql);
		}
		
		public static function deleteactivejob($id)
		{
			$sql="DELETE FROM randomjobs_activejobs WHERE id = '$id'";
			DB::query($sql);
		}
		
		public static function deleteallactivejobs()
		{
			$sql="TRUNCATE TABLE randomjobs_activejobs";
			DB::query($sql);
		}
		
		public static function savejob($jobtype, $jobdescription, $depairport)
		{
			$sql="INSERT INTO randomjobs_jobtemplates (jobtype, jobdescription, depairport) VALUES('$jobtype','$jobdescription', '$depairport')";
			DB::query($sql);
		}
		
		
		public static function saveaircraft($id)
		{
			$sql="INSERT INTO randomjobs_aircraft (aircraft) VALUES('$id')";
			DB::query($sql);
		}
		
		public static function deleteaircraft($id)
		{
			$sql="DELETE FROM randomjobs_aircraft WHERE id = '$id'";
			DB::query($sql);
		}
		
		public static function saveairport($icao)
		{
			$sql="INSERT INTO randomjobs_airports (airport) VALUES('$icao')";
			DB::query($sql);
		}
		
		public static function deleteairport($arid)
		{
			$sql="DELETE FROM randomjobs_airports WHERE id = '$arid'";
			DB::query($sql);
		}
		
		public static function savearrival($micao, $icao)
		{
			$sql="INSERT INTO randomjobs_arrival_airports (departure, arrival) VALUES('$micao', '$icao')";
			DB::query($sql);
		}
		
		public static function deletearrival($arid)
		{
			$sql="DELETE FROM randomjobs_arrival_airports WHERE id = '$arid'";
			DB::query($sql);
		}
		
		
		public static function updatejob($id, $jobtype, $jobdescription, $depairport)
		{
			$sql="UPDATE randomjobs_jobtemplates SET jobtype = '$jobtype', jobdescription = '$jobdescription', depairport='$depairport' WHERE id = '$id'";
			DB::query($sql);
		}
		
		public static function deletejob($id)
		{
			$sql="DELETE FROM randomjobs_jobtemplates WHERE id = '$id'";
			DB::query($sql);
		}
		
		public static function getrandomjob()
		{
			$sql="SELECT * FROM randomjobs_jobtemplates ORDER BY RAND() LIMIT 1";
			return DB::get_row($sql);
		}
		
		public static function getrandomdep()
		{
		$setting = self::getsettings();
		
		if($setting->allairports == '1')
		{
		return self::getrandomdepall();
		}
		
			$sql="SELECT airport FROM randomjobs_airports ORDER BY RAND() LIMIT 1";
			$depapt = DB::get_row($sql);

            return $depapt->airport;
		}
		
			public static function getrandomdepall()
		{
		
			$sql="SELECT icao FROM ".TABLE_PREFIX."airports ORDER BY RAND() LIMIT 1";
			$depapt = DB::get_row($sql);

            return $depapt->icao;
		}
		
		public static function getairportinfo($icao) {
        $query = "SELECT * FROM ".TABLE_PREFIX."airports
		WHERE icao ='$icao'";
        return DB::get_row($query);
    }
	
		public static function createrandjob($jobid, $depicao, $arricao, $paxnum, $cargonum, $expirationtime)
		{
			$sql="INSERT INTO randomjobs_activejobs (jobid, depicao, arricao, paxnum, cargonum, expirationtime) VALUES('$jobid', '$depicao', '$arricao', '$paxnum', '$cargonum', '$expirationtime')";
			DB::query($sql);
		}
		
		public static function getrandomarr($depicao, $mindistance, $maxdistance)
		{
		$setting = self::getsettings();
		
		if($setting->allairports == '1')
		{
		return self::getrandomarrall($depicao, $mindistance, $maxdistance);
		}
		
$depapt = self::getairportinfo($depicao);
$lat = $depapt->lat;
$lng =$depapt->lng;

$sql="SELECT j.airport, a.icao, ( 3443.92 * acos( cos( radians( '$lat' ) ) * 
cos( radians( a.lat ) ) * 
cos( radians( a.lng ) - 
radians( '$lng' ) ) + 
sin( radians( '$lat' ) ) * 
sin( radians( a.lat ) ) ) ) 
AS distance FROM randomjobs_airports j LEFT JOIN ".TABLE_PREFIX."airports a ON a.icao = j.airport
WHERE a.icao != '$depapt->icao'
HAVING distance < '$maxdistance' AND distance > '$mindistance' ORDER BY RAND() LIMIT 1";

$arrapt = DB::get_row($sql);
return $arrapt->icao;
		}
		
		public static function getrandomarrall($depicao, $mindistance, $maxdistance)
		{
		
$depapt = self::getairportinfo($depicao);
$lat = $depapt->lat;
$lng =$depapt->lng;

$sql="SELECT icao, ( 3443.92 * acos( cos( radians( '$lat' ) ) * 
cos( radians( lat ) ) * 
cos( radians( lng ) - 
radians( '$lng' ) ) + 
sin( radians( '$lat' ) ) * 
sin( radians( lat ) ) ) ) 
AS distance FROM ".TABLE_PREFIX."airports
WHERE icao != '$depapt->icao'
HAVING distance < '$maxdistance' AND distance > '$mindistance' ORDER BY RAND() LIMIT 1";

$arrapt = DB::get_row($sql);
return $arrapt->icao;
		}
		
		public static function getpaxnum()
		{
			$sql="SELECT maxpax FROM ".TABLE_PREFIX."aircraft WHERE enabled != '0' ORDER BY RAND() LIMIT 1";
			$aircraft = DB::get_row($sql);
			
			$paxnum = round(($aircraft->maxpax * rand(30,90)) / 100);
            return $paxnum;
		}
		
		public static function getcargonum()
		{
			$sql="SELECT maxcargo FROM ".TABLE_PREFIX."aircraft WHERE enabled != '0' ORDER BY RAND() LIMIT 1";
			$aircraft = DB::get_row($sql);
			
			$cargonum = round(($aircraft->maxcargo * rand(30,90)) / 100);
            return $cargonum;
		}
		
		
		public static function getdistance($depicao, $arricao)
		{
		$depapt = self::getairportinfo($depicao);
		$arrapt = self::getairportinfo($arricao);
		
		$lat1 = $depapt->lat;
		$lng1 = $depapt->lng;
		
		$lat2 = $arrapt->lat;
		$lng2 = $arrapt->lng;
		
		$radius = 3443.92;
		
       $lat1 = deg2rad(floatval($lat1));
		$lat2 = deg2rad(floatval($lat2));
		$lng1 = deg2rad(floatval($lng1));
		$lng2 = deg2rad(floatval($lng2));
		
		$a = sin(($lat2 - $lat1)/2.0);
		$b = sin(($lng2 - $lng1)/2.0);
		$h = ($a*$a) + cos($lat1) * cos($lat2) * ($b*$b);
		$theta = 2 * asin(sqrt($h)); # distance in radians
		
		$distance = $theta * $radius;
		
		return round($distance);
		}
		
		
public static function processbid($depicao, $arricao, $aircraft, $deptime, $arrtime, $flighttime, $distance, $price, $flightlevel, $route, $notes, $flighttype, $code)
{

$flighttime = str_replace(':', '.', $flighttime);

 $sqlcheck = "SELECT * FROM ".TABLE_PREFIX."schedules WHERE code = '$code' ORDER BY CAST(flightnum AS SIGNED) DESC LIMIT 1";
		$lastsched = DB::get_row($sqlcheck);
		
		if($lastsched)
		{
		$flightnum = $lastsched->flightnum + 1;
		}
		if(!$flightnum)
		{
		 $flightnum = '100';
		}

$sql="INSERT INTO ".TABLE_PREFIX."schedules (code, flightnum, depicao, arricao, route, aircraft, flightlevel, distance, deptime, arrtime, flighttime, daysofweek, price, flighttype, notes, enabled)
                        VALUES('$code', '$flightnum', '$depicao', '$arricao', '$route', '$aircraft', '$flightlevel', '$distance', '$deptime', '$arrtime', '$flighttime', '0123456', '$price', '$flighttype', '$notes', '1')";
		DB::query($sql);
return DB::$insert_id;
}

public static function addbidtojob($id, $bidid, $schedid)
{   
    $pilot = Auth::$userinfo->pilotid;
	$sql="UPDATE randomjobs_activejobs SET booked = '$bidid', pilot = '$pilot', schedid = '$schedid' WHERE id = '$id'";
			DB::query($sql);
}


 public static function addBid($pilotid, $routeid) {
        $pilotid = DB::escape($pilotid);
        $routeid = DB::escape($routeid);

        if (DB::get_row('SELECT bidid FROM ' . TABLE_PREFIX . 'bids
						WHERE pilotid=' . $pilotid . ' AND routeid=' . $routeid)) {
            return false;
        }

        $pilotid = DB::escape($pilotid);
        $routeid = DB::escape($routeid);

        $sql = 'INSERT INTO ' . TABLE_PREFIX . 'bids (pilotid, routeid, dateadded)
				VALUES (' . $pilotid . ', ' . $routeid . ', NOW())';

        DB::query($sql);

        SchedulesData::setBidOnSchedule($routeid, DB::$insert_id);

        if (DB::errno() != 0) return false;

        return DB::$insert_id;
    }


public static function checkpilotisbooked($pilot)
	{
		$sql = "SELECT * FROM randomjobs_activejobs WHERE pilot = '$pilot'";
		$retcheck = DB::get_results($sql);
		
		if($retcheck)
		{
		return true;
		}
		else
		{
		return false;
		}
		
	}
		
		public static function removejobswithdelbid()
		{
			$sql = "SELECT * FROM randomjobs_activejobs WHERE booked != '0'";
			$jobs = DB::get_results($sql);
			
			if($jobs)
			foreach($jobs as $job)
			{
				$bidid = $job->booked;
				$jobid = $job->id;
				$schedid = $job->schedid;
				
				$sql2 = "SELECT * FROM ".TABLE_PREFIX."bids WHERE bidid = '$bidid'";
				$bidcheck = DB::get_row($sql2);
				
				if(!$bidcheck)
				{
					$sql3 = "DELETE FROM randomjobs_activejobs WHERE id = '$jobid'";
			        DB::query($sql3);
					
					$sql3 = "DELETE FROM ".TABLE_PREFIX."schedules WHERE id = '$schedid'";
			        DB::query($sql3);
				}
			}
		}
		
		public static function getpilotdata($pilotid)
		{
			$sql="SELECT * FROM ".TABLE_PREFIX."pilots WHERE pilotid = '$pilotid'";
			return DB::get_row($sql);
		}
		
		public static function getarrrestrrand($depicao)
		{
			$sql="SELECT arrival FROM randomjobs_arrival_airports WHERE departure = '$depicao' ORDER BY RAND() LIMIT 1";
			$arrapt = DB::get_row($sql);

            return $arrapt->arrival;
		}
	}