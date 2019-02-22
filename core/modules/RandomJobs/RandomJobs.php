<?php
////////////////////////////////////////////////////////////////////////////
//Crazycreatives Random Jobs module for phpVMS virtual airline system. //
//@author Manuel Seiwald                                                  //
//@copyright Copyright (c) 2015, Manuel Seiwald, All Rights Reserved      //
////////////////////////////////////////////////////////////////////////////

class RandomJobs extends CodonModule
	{
			
			public function index()
		{
			$this->show('randomjobs/index.tpl');
		}
		
		
		public function generatejobs()
		{
			$this->expirejobs();
			RandomJobsData::removejobswithdelbid();
			RandomJobsData::deleterandexpired();
			
			$creationprob = rand(1,10);
			
			if($creationprob > 2)
			{
			$setting = RandomJobsData::getsettings();
			$jobcount = count(RandomJobsData::getcurrentjobs());
			$creationtimerandom = rand($setting->creationintmin, $setting->creationintmax);
			$creationtime = gmdate("Y-m-d H:i:s", strtotime('-'.$creationtimerandom.' minute'));
			
			if($setting->enabled == '0')
			{
				return;
			}
			
			if($setting->lastcreation < $creationtime)
			{

			if($setting->maxactivejobs > $jobcount)
			{
				$timerandom = rand($setting->minexpiration, $setting->maxexpiration);
				$expirationtime = gmdate("Y-m-d H:i:s", strtotime('+'.$timerandom.' minute'));
				$jobtemplate = RandomJobsData::getrandomjob();
				$jobid = $jobtemplate->id;
				$getairportrequest = RandomJobsData::getrandomrequest();
				$reqrand = rand(1,10);
				
				if($getairportrequest->remain > 0 && $reqrand > '2')
				{
					$depicao = $getairportrequest->icao;
					RandomJobsData::decreaserequest($getairportrequest->id);
					
					$arricao = RandomJobsData::getrandomarr($depicao, $setting->mindistance, $setting->maxdistance);
					
					if(!$arricao)
					{
						$depicao = RandomJobsData::getrandomdep();
					}
					
				}
				else
				{
				
				if(trim($jobtemplate->depairport))
				{
					$depicao = trim($jobtemplate->depairport);
				}
				else
				{
				$depicao = RandomJobsData::getrandomdep();
				}
				}
				
				if(RandomJobsData::getarrivalrestrictions($depicao))
				{
				$arricao = RandomJobsData::getarrrestrrand($depicao);
				}
				else
				{
				$arricao = RandomJobsData::getrandomarr($depicao, $setting->mindistance, $setting->maxdistance);
				}
				
				if(!$arricao)
				{
				$arricao = RandomJobsData::getrandomarr($depicao, $setting->mindistance, $setting->maxdistance);
				}
				
				if(!$depicao || !$arricao)
				{
				return;
			}
				if($jobtemplate->jobtype == 'P')
				{
					$paxnum = RandomJobsData::getpaxnum();
				}
				elseif($jobtemplate->jobtype == 'C')
				{
					$cargonum = RandomJobsData::getcargonum();
				}
				else
				{
					$paxnum = RandomJobsData::getpaxnum();
					$cargonum = RandomJobsData::getcargonum();
				}
				
				RandomJobsData::createrandjob($jobid, $depicao, $arricao, $paxnum, $cargonum, $expirationtime);
				RandomJobsData::updatelastcreation();
				
				if($getairportrequest->remain > 0 && $reqrand > '2' && $getairportrequest->emailnotify == '1')
					{
						self::sendnotification($getairportrequest->pilotid, $depicao, $arricao);
					}
			}
			
			}
		   }
		}
		
		public function expirejobs()
		  {
			  RandomJobsData::expirejobs();
		  }
		  
		    public function innerwidget()
		  {
			  $this->set('jobs', RandomJobsData::getnobookedjobs());
			  $this->show('randomjobs/widgetinner.tpl');
		  }
		  
		  public function widget()
		  {
			  $this->show('randomjobs/widget.tpl');
		  }
		  
		  public function jobdetail($id)
		  {
			$job = RandomJobsData::getjobdetail($id);
			
			if(!$job)
			{
			$this->set('message', 'This job has already expired!');
			$this->show('core_error.tpl');
			return;
			}
			
			$description = $job->jobdescription;
			
			$search = array('{departurename}', '{departureicao}', '{arrivalname}', '{arrivalicao}', '{passengernum}', '{cargonum}', '{expirationtime}');
            $replace   = array($job->depname, $job->depicao, $job->arrname, $job->arricao, $job->paxnum, $job->cargonum, $job->expirationtime);
            $text    = $description;
            $description  = str_replace($search, $replace, $text);
			$distance = RandomJobsData::getdistance($job->depicao, $job->arricao);
			$price = round(($distance * rand(50,170)) / 100);
			
			if($job->jobtype == 'P')
				{
					$price = round(($distance * rand(50,170)) / 100);
				}
				else
				{
					$price = round(($distance * rand(5,7)) / 100);
				}

			$this->set('distance', $distance);
			$this->set('price', $price);
			$this->set('aircraft', RandomJobsData::getbookaircraft());
		    $this->set('job', $job);
			$this->set('description', $description);
			$this->show('randomjobs/details.tpl');
		  }
		  
		  
		  public function pilotwidget()
		  {
			  if(!Auth::LoggedIn())
			  {
				  return;
			  }
			  
			  $pilotid = Auth::$userinfo->pilotid;
			  $setting = RandomJobsData::getsettings();
			  
			  if(RandomJobsData::checkaptrequestspilot($pilotid))
			  {
				  return;
			  }
			  
			  if($setting->pilrequestmax == '0')
			  {
				  return;
			  }
			  
			  $this->set('airports', RandomJobsData::getallairports());
			  $this->show('randomjobs/prefapts.tpl');
		  }
		  
		  
		  public function requestnewjobs()
		  {
			   if(!Auth::LoggedIn())
			  {
				  return;
			  }
			  
			  
			  $pilotid = Auth::$userinfo->pilotid;
			  $setting = RandomJobsData::getsettings();
			  $airport = DB::escape($this->post->airport);
			  $email = DB::escape($this->post->email);
			  
			   if(RandomJobsData::checkaptrequestsapt($airport))
			  {
				  $this->set('message', 'This airport has already been requested!');
			      $this->show('core_error.tpl');
				  return;
			  }
			  
			  RandomJobsData::createnewpilotrequest($setting->pilrequestmax, $pilotid, $airport, $email);
			  $this->set('message', 'Your request for a new job has been received! We will check with our contractors and add the jobs within the next couple of minutes in case we find any.');
			      $this->show('core_success.tpl');
		  }
		 
		 
		 
		 public function takejob($cid)
	{
		if(!Auth::LoggedIn()) return;
				
		$routeid = $cid;
		
		if($routeid == '')
		{
			echo 'No route passed';
			return;
		}
		
		$job = RandomJobsData::getjobdetail($cid);
			
			if(!$job)
			{
			$this->set('message', 'This job has already expired!');
			$this->show('core_error.tpl');
			return;
			}
			
			
			if($job->booked != '0')
			{
			$this->set('message', 'This job has already been booked!');
			$this->show('core_error.tpl');
			return;
			}
			
			if(RandomJobsData::checkpilotisbooked(Auth::$userinfo->pilotid) == true)
			{
			$this->set('message', 'You have already booked a job! Please finish it first before you come back and book another job!');
			$this->show('core_error.tpl');
			return;
			}
			
			if(!$this->post->aircraft)
			{
			$this->set('message', 'No aircraft was selected!');
			$this->show('core_error.tpl');
			return;
			}

/* Block any other bids if they've already made a bid
		 */
		if(Config::Get('DISABLE_BIDS_ON_BID') == true)
		{
			$bids = SchedulesData::getBids(Auth::$userinfo->pilotid);
			
			# They've got somethin goin on
			if(count($bids) > 0)
			{
				echo 'Bid exists!';
				return;
			}
		}

$depicao = $job->depicao;
$arricao = $job->arricao;
$deptime = DB::escape($this->post->deptime);
$flighttime = DB::escape($this->post->flighttime);
$prodeptime = date('Y-m-d').' '.$deptime.':'.date('s');
$proflighttime = explode(':', $flighttime);
$proflhrminu = $proflighttime[0] * 60;
$proflminu = $proflhrminu + $proflighttime[1];
$proarrtime = date("Y-m-d H:i:s", strtotime($prodeptime." +".$proflminu." minute"));
$arrtime = date("H:i", strtotime($proarrtime));
$distance = DB::escape($this->post->distance);
$aircraft = DB::escape($this->post->aircraft);
$price = DB::escape($this->post->price);
$flightlevel = DB::escape($this->post->flightlevel);
$route = strtoupper(DB::escape($this->post->route));
$notes = DB::escape($this->post->notes);

if($job->jobtype == 'P')
{
	$flighttype = 'P';
}
else
{
	$flighttype = 'C';
}
$setting = RandomJobsData::getsettings();
$routeid = RandomJobsData::processbid($depicao, $arricao, $aircraft, $deptime, $arrtime, $flighttime, $distance, $price, $flightlevel, $route, $notes, $flighttype, $setting->code);

		// See if this is a valid route
		$route = SchedulesData::findSchedules(array('s.id' => $routeid));
		
		if(!is_array($route) && !isset($route[0]))
		{
			echo 'Invalid Route';
			return;
		}
		
		CodonEvent::Dispatch('bid_preadd', 'Schedules', $routeid);
	
		
		$ret = RandomJobsData::AddBid(Auth::$userinfo->pilotid, $routeid);
		RandomJobsData::addbidtojob($job->id, $ret, $routeid);
		CodonEvent::Dispatch('bid_added', 'Schedules', $routeid);
		
		if($ret)
		{
			$this->set('message', 'The Job has been added to your flights!');
			$this->show('core_success.tpl');
		}
		else
		{
			$this->set('message', 'There was an error booking this job!');
			$this->show('core_error.tpl');
		}
	}
	
	
	
	public function __construct()
{
 CodonEvent::addListener('RandomJobs', array('pirep_filed'));
}



public function EventListener($eventinfo)
{
 $eventname = $eventinfo[0]; // Event name
 $eventmodule = $eventinfo[1]; // Class calling it


if($eventinfo[0] == 'pirep_filed')
 { 
$query0 = "SELECT * FROM ".TABLE_PREFIX."pireps ORDER BY submitdate DESC LIMIT 1";
					
					$pirep =	DB::get_row($query0);
					
					$pilotid = $pirep->pilotid;

$query1 = "SELECT * FROM randomjobs_activejobs WHERE pilot = '$pilotid'";
					
					$pilotflight =	DB::get_row($query1);

if($pilotflight)
{
$schedid = $pilotflight->schedid;
$query2 = "DELETE FROM ".TABLE_PREFIX."schedules WHERE id = '$schedid'";
					
						DB::query($query2);

$query3 = "DELETE FROM randomjobs_activejobs WHERE pilot = '$pilotid'";
DB::query($query3);
}
}
}

public function sendnotification($pilotid, $depicao, $arricao)
{
	$pilotdata = RandomJobsData::getpilotdata($pilotid);
	$depdata = RandomJobsData::getairportinfo($depicao);
	$arrdata = RandomJobsData::getairportinfo($arricao);
	
	        $email = $pilotdata->email;
			$subject = "A new Job was found!";
			$message = "Dear ".$pilotdata->firstname."<br /><br />we just received a new job for a flight from ".$depdata->name." (".$depdata->icao.") to ".$arrdata->name." (".$arrdata->icao.")!<br />To pick this job please log in to our website and take the job before it gets booked by another pilot.<br /><br />- The Dispatch Team";
			
			Util::SendEmail($email, $subject, $message);
			
}

	}
	