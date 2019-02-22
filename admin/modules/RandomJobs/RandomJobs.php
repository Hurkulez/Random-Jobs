<?php
////////////////////////////////////////////////////////////////////////////
//Crazycreatives Random Jobs module for phpVMS virtual airline system. //
//@author Manuel Seiwald                                                  //
//@copyright Copyright (c) 2015, Manuel Seiwald, All Rights Reserved      //
////////////////////////////////////////////////////////////////////////////

class RandomJobs extends CodonModule
	{

public function HTMLHead()
    {
        $this->set('sidebar', 'randomjobs/sidebar.php');
    }

    public function NavBar()
    {
        echo '<li><a href="'.SITE_URL.'/admin/index.php/RandomJobs">Random Jobs</a></li>';
    }

		public function index()
		{
			$this->set('jobs', RandomJobsData::getcurrentjobs());
			$this->show('randomjobs/index.tpl');
		}
		
		public function settings()
		{
			$this->set('setting', RandomJobsData::getsettings());
			$this->show('randomjobs/settings.tpl');
		}
		
		public function airports()
		{
			$this->set('setting', RandomJobsData::getsettings());
			$this->set('allairports', RandomJobsData::getallairportsnolim());
			$this->set('airports', RandomJobsData::getjobairports());
			$this->show('randomjobs/airports.tpl');
		}
		
		public function restrictarrivals($icao)
		{
			$this->set('icao', $icao);
			$this->set('setting', RandomJobsData::getsettings());
			$this->set('allairports', RandomJobsData::getallairportsforarrival());
			$this->set('airports', RandomJobsData::getarrivalrestrictions($icao));
			$this->show('randomjobs/restrictarrivals.tpl');
		}
		
		public function addarrival()
		{
			$icao = DB::escape($this->post->airport);
			$micao = DB::escape($this->post->micao);
			RandomJobsData::savearrival($micao, $icao);
			$this->set('message', 'Airport Added!');
			$this->show('core_success.tpl');
			$this->restrictarrivals($micao);
		}
		
			public function deletearrival($arid)
		{
			$micao = DB::escape($this->get->micao);
			RandomJobsData::deletearrival($arid);
			$this->set('message', 'Airport Deleted!');
			$this->show('core_success.tpl');
			$this->restrictarrivals($micao);
		}
		
		
		public function useallairports()
		{
			RandomJobsData::changeuseallapt('1');
			$this->set('message', 'Setting changed!');
			$this->show('core_success.tpl');
			$this->airports();
		}
		
		public function dontuseallairports()
		{
			RandomJobsData::changeuseallapt('0');
			$this->set('message', 'Setting changed!');
			$this->show('core_success.tpl');
			$this->airports();
		}
		
		public function addairport()
		{
			$icao = DB::escape($this->post->airport);
			RandomJobsData::saveairport($icao);
			$this->set('message', 'Airport Added!');
			$this->show('core_success.tpl');
			$this->airports();
		}
		
			public function deleteairport($arid)
		{
			RandomJobsData::deleteairport($arid);
			$this->set('message', 'Airport Deleted!');
			$this->show('core_success.tpl');
			$this->airports();
		}
		
		public function aircraft()
		{
			$this->set('setting', RandomJobsData::getsettings());
			$this->set('allaircraft', RandomJobsData::getallaircraft());
			$this->set('aircraft', RandomJobsData::getjobaircraft());
			$this->show('randomjobs/aircraft.tpl');
		}
		
		public function useallaircraft()
		{
			RandomJobsData::changeuseallacrft('1');
			$this->set('message', 'Setting changed!');
			$this->show('core_success.tpl');
			$this->aircraft();
		}
		
		public function dontuseallaircraft()
		{
			RandomJobsData::changeuseallacrft('0');
			$this->set('message', 'Setting changed!');
			$this->show('core_success.tpl');
			$this->aircraft();
		}
		
		public function addaircraft()
		{
			$id = DB::escape($this->post->aircraftid);
			RandomJobsData::saveaircraft($id);
			$this->set('message', 'Aircraft Added!');
			$this->show('core_success.tpl');
			$this->aircraft();
		}
		
			public function deleteaircraft($id)
		{
			RandomJobsData::deleteaircraft($id);
			$this->set('message', 'Aircraft Deleted!');
			$this->show('core_success.tpl');
			$this->aircraft();
		}
		
		public function savesettings()
		{
			$creationintmin = DB::escape($this->post->creationintmin);
			$creationintmax = DB::escape($this->post->creationintmax);
			$minexpiration = DB::escape($this->post->minexpiration);
			$maxexpiration = DB::escape($this->post->maxexpiration);
			$maxactivejobs = DB::escape($this->post->maxactivejobs);
			$mindistance = DB::escape($this->post->mindistance);
			$maxdistance = DB::escape($this->post->maxdistance);
			$enabled = DB::escape($this->post->enabled);
			$pilrequestmax = DB::escape($this->post->pilrequestmax);
			$code = DB::escape($this->post->code);
			$restrictacrank = DB::escape($this->post->restrictacrank);
			$pilotrequestany = DB::escape($this->post->pilotrequestany);
			
			RandomJobsData::savesettings($creationintmin, $creationintmax, $minexpiration, $maxexpiration, $maxactivejobs, $enabled, $mindistance, $maxdistance, $pilrequestmax, $code, $restrictacrank, $pilotrequestany);
	
	
			$this->set('message', 'Settings Saved!');
			$this->show('core_success.tpl');
			$this->settings();
		}
		
		public function jobs()
		{
			$this->set('jobs', RandomJobsData::getjobs());
			$this->show('randomjobs/jobs.tpl');
		}
		
		public function addjob()
		{
			$this->set('action', 'Add new Job');
			$this->show('randomjobs/jobform.tpl');
		}
		
		public function editjob($id)
		{
			$this->set('job', RandomJobsData::getjob($id));
			$this->set('action', 'Edit Job');
			$this->show('randomjobs/jobform.tpl');
		}
		
		public function submitjob()
		{
			if($this->post->action == 'Add new Job')
			{
				$this->savejob();
			}
			else
			{
				$this->updatejob();
			}
		}
		
		
		public function savejob()
		{
			$jobtype = DB::escape($this->post->jobtype);
			$jobdescription = DB::escape($this->post->jobdescription);
			$depairport = DB::escape($this->post->depairport);
			
			RandomJobsData::savejob($jobtype, $jobdescription, $depairport);
	
	
			$this->set('message', 'Job Saved!');
			$this->show('core_success.tpl');
			$this->jobs();
		}
		
		
		public function updatejob()
		{
			$jobtype = DB::escape($this->post->jobtype);
			$jobdescription = DB::escape($this->post->jobdescription);
			$id = DB::escape($this->post->id);
			$depairport = DB::escape($this->post->depairport);

			
			RandomJobsData::updatejob($id, $jobtype, $jobdescription, $depairport);
	
	
			$this->set('message', 'Job Updated!');
			$this->show('core_success.tpl');
			$this->jobs();
		}
		
		
		public function deletejob($id)
		{
			RandomJobsData::deletejob($id);
			
			$this->set('message', 'Job Deleted!');
			$this->show('core_success.tpl');
			$this->jobs();
		}
			
			
			public function deleteactivejob($id)
		{
			RandomJobsData::deleteactivejob($id);
			
			$this->set('message', 'Job Deleted!');
			$this->show('core_success.tpl');
			$this->index();
		}
		
		public function deleteallactivejobs()
		{
			RandomJobsData::deleteallactivejobs();
			
			$this->set('message', 'All Jobs Deleted!');
			$this->show('core_success.tpl');
			$this->index();
		}
		
	}