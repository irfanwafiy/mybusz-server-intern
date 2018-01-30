<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseController
{
	public function getTime()
	{
		date_default_timezone_set('Asia/Singapore');
		return date('Y-m-d H:i:s', time());
	}
	
	//tested
	public function insertLocationData($bus_id, $route_id, $imei, $newlocation, $newlocation1, $speedkmhr)
	//public function insertLocationData(Request $request)
	{
		
		/* $bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$imei = $request->input('imei');
		$newlocation = $request->input('newlocation');
		$newlocation1 = $request->input('newlocation1');
		$speedkmhr = $request->input('speedkmhr'); */
		
		$time = self::getTime();
		
		$insertLocationData_Query = DB::table('location_data')
								->insert([
								'bus_id'=>$bus_id,
								'route_id'=>$route_id,
								'imei'=>$imei,
								'latitude'=>$newlocation,
								'longitude'=>$newlocation1,
								'speed'=>$speedkmhr,
								'time'=>$time]);
	
	}
	
	
	
	public function uploadETA($bus_id,$route_id,$bus_stop_id,$eta,$time,$avgspeed)
	//tested
	//public function uploadETA(Request $request)
	{
			
		/* $bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$bus_stop_id = $request->input('bus_stop_id');
		$eta = $request->input('eta');
		$time = $request->input('time');
		$avgspeed = $request->input('avgSpeed');
		 */
		$uploadETA_Query = DB::table('eta')
						->insert([
						'bus_id'=>$bus_id,
						'route_id'=>$route_id,
						'bus_stop_id'=>$bus_stop_id,
						'eta'=>$eta,
						'time'=>$time,
						'avgspeed'=>$avgspeed
						]);
		
	}	
	public function updateFlag($flag,$bus_id,$route_id,$time)
	//tested
	//public function updateFlag(Request $request)
	{
		/* $flag = $request->input('flag');
		$bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$time = $request->input('time'); */
		
		$updateFlag_Query = DB::table('location_data')
								->where('bus_id',$bus_id)
								->where('route_id',$route_id)
								->where('time',$time)
								->update(['flag'=>$flag]);
	}
	
	public function getLastRecord($bus_id,$routeno,$time)
	//tested
	//public function getLastRecord()
	{
		
		/* $bus_id = 1;
		$routeno = 1;
		$time = '2015-09-06 15:33:53'; */
		
		$currTime = self::getTime();
		$speed = 0;
		
		$getLastRecord_subQuery = DB::table('bus_route as br')
										->select('l.bus_id', 'l.latitude', 'l.longitude', 'l.speed', 'br.bus_service_no', 'l.flag', 'l.route_id', 'l.time', 'l.imei')
										->join('location_data as l', 'br.bus_id', '=', 'l.bus_id')
										->join('route as r', 'r.route_id', '=', 'br.route_id')
										->where('l.bus_id',$bus_id)
										->where('l.route_id',$routeno)
										->where('l.time', '>',$time)
										->where('l.time', '<',$currTime)
										->where('l.speed', '>', $speed)
										->orderBy('l.time', 'desc');
		
		$getLastRecord_Query = DB::table(DB::raw("({$getLastRecord_subQuery->toSql()}) as location") );
		$getLastRecord_Query->mergeBindings( $getLastRecord_subQuery );
		$getLastRecord_Query->groupBy('imei');
		$getLastRecord_Query = $getLastRecord_Query->get();
		
		$data = array();
		
		foreach($getLastRecord_Query as $singleset)
		{
			
			array_push($data,$singleset);
		}
		
		return $data;
	}

	
	public function getLastRecordV2($bus_id,$routeno,$time)
	//tested
	//public function getLastRecordV2()
	{
		
		/* $bus_id = 1;
		$routeno = 1; 
		$time = '2015-09-06 15:33:53'; */
		
		$currTime = self::getTime();
		$speed = 0;
		
		$getLastRecordV2_subQuery = DB::table('bus_route as br')
										->select('l.bus_id', 'l.latitude', 'l.longitude', 'l.speed', 'br.bus_service_no', 'l.flag', 'l.route_id', 'l.time', 'l.imei')
										->join('location_datav2 as l', 'br.bus_id', '=', 'l.bus_id')
										->join('route as r', 'r.route_id', '=', 'br.route_id')
										->where('l.bus_id',$bus_id)
										->where('l.route_id',$routeno)
										->where('l.time', '>',$time)
										->where('l.time', '<',$currTime)
										->where('l.speed', '>=', $speed)
										->orderBy('l.time', 'desc');
		
		$getLastRecordV2_Query = DB::table(DB::raw("({$getLastRecordV2_subQuery->toSql()}) as location") );
		$getLastRecordV2_Query->mergeBindings( $getLastRecordV2_subQuery);
		$getLastRecordV2_Query->groupBy('imei');
		$getLastRecordV2_Query = $getLastRecordV2_Query->get();
		
		
		$data = array();
		
		foreach($getLastRecordV2_Query as $singleset)
		{
			array_push($data,$singleset);
		}
		
		return $data;
	}
	
	public function avgSpeed($routeno,$bus_id,$timehigh,$timelow)
	//tested
	//public function avgSpeed(Request $request)
	{
		
		/* $routeno = $request->input('routeno');
		$bus_id = $request->input('bus_id');
		$timehigh = $request->input('timehigh');
		$timelow = $request->input('timelow'); */
		
		$speed = 0.0;
		
		$avgSpeed_Query = DB::table('location_data')
						->where('route_id',$routeno)
						->where('bus_id',$bus_id)
						->where('time','<=', $timehigh)
						->where('time', '>=', $timelow)
						->where('speed','>', $speed)
						->avg('speed');
		
		
		/* $data = array();
		foreach($avgSpeed_Query as $singleset)
		{
			$data = $singleset;
		} */
		return $avgSpeed_Query;
		//return $data[0];
	}
	
	public function checkHistoryExist($routeno,$bus_id)
	//tested
	//public function checkHistoryExist(Request $request)
	{
		/* $routeno = $request->input('routeno');
		$bus_id = $request->input('bus_id'); */
		$avgSpeed = -1;
		
		$checkHistoryExist_Query = DB::table('eta')
										->select(DB::raw('count(*),time'))
										->where('bus_id',$bus_id)
										->where('route_id',$routeno)
										->where('avgSpeed',$avgSpeed)
										->groupBy('time')
										->orderBy('time', 'desc')
										->limit(1)
										->get();
		/* 								
		$data = array();
		
		foreach($checkHistoryExist_Query as $singleset)
		{
			$data = $singleset;
		} */
		
		return $checkHistoryExist_Query;
		//return $data;
	}
	public function getHistoryETAV1($bus_id,$route_id,$bus_service_no,$busstop_id,$keepTime)
	//tested
	//public function getHistoryETAV1()
	{
		/* $bus_id = 1;
		$route_id =1;
		$bus_service_no = 7;
		$busstop_id = 1002;
		$keepTime = 900; */
		$getHistoryETAV1_Query = DB::table('avg_speed_calculated')
									->select('avg_time','bus_stop_id_next')
									->where('route_id',$route_id)
									->where('bus_service_no',$bus_service_no)
									->where('bus_stop_id_next','>',$busstop_id)
									->get();
									
		if($keepTime != 0)
		{
			$time = $keepTime;
		}
		else
		{
			$time = 0;
		}
		
		foreach($getHistoryETAV1_Query as $singleset)
		{
			
			$time = $singleset->avg_time + $time;
			$avgspeed = -1;
			$calcTime = date("Y/m/d h:i:s", $time +strtotime("+0 seconds"));
			$get_Time = date('Y/m/d h:i:s', time());
			self::uploadETA($bus_id,$route_id,$singleset->bus_stop_id_next,$calcTime,$get_Time,$avgspeed);
			
		}
	}
	
	
	
	public function retrieveLocationData($routeno,$bus_id,$timehigh,$timelow)
	//tested
	//public function retrieveLocationData()
	{
		/* $routeno = 1;
		$bus_id = 1;
		$timehigh ='2016-09-07 15:17:58';
		$timelow ='2016-09-02 11:05:40'; */
		$retrieveLocationData_Query = DB::table('location_datav2')
											->select('latitude', 'longitude', 'time', 'speed' )
											->where('route_id',$routeno)
											->where('bus_id',$bus_id)
											->where('time','<=',$timehigh)
											->where('time','>=',$timelow)
											->orderBY('time', 'asc')
											->get();
		
		$data = array();	
		$i = 0;
		
		foreach($retrieveLocationData_Query as $singleset)
		{
			
			$data[$i] = $singleset;
			$i++;
		}
		
		return $data;
	}
	
	public function checkHistoryExistV2($routeno,$bus_id)
	//tested
	//public function checkHistoryExistV2()
	{
		
		/* $routeno = 1;
		$bus_id = 1; */
		$avgSpeed = -1;
		
		$checkHistoryExistV2_Query = DB::table('etav2')
										->select(DB::raw('count(*),time'))
										->where('bus_id',$bus_id)
										->where('route_id',$routeno)
										->where('avgSpeed',$avgSpeed)
										->groupBy('time')
										->orderBy('time', 'desc')
										->limit(1)
										->get();
		
		/* $data = array();
		$i=0;
		foreach($checkHistoryExistV2_Query as $singleset)
		{
			var_dump($singleset);
			die();
			$data[$i] = $singleset;
			$i++;
		} */
		
		return $checkHistoryExistV2_Query;
		//return $data;
	}
	
	public function uploadETAV2($bus_id,$route_id,$bus_stop_id,$eta,$time,$avgspeed)
	//tested
	//public function uploadETAV2()
	{
		/* $bus_id = 1;
		$route_id = 1;
		$bus_stop_id = 1002;
		$eta ='2018-01-12 10:37:32';
		$time = '2018-01-12 10:33:08';
		$avgspeed = -1; */
		
		$uploadETAV2_Query = DB::table('etaV2')
						->insert([
						'bus_id'=>$bus_id,
						'route_id'=>$route_id,
						'bus_stop_id'=>$bus_stop_id,
						'eta'=>$eta,
						'time'=>$time,
						'avgspeed'=>$avgspeed
						]);
	}
	
	public function insertLocationDataV2($bus_id, $route_id, $imei, $newlocation, $newlocation1, $speedkmhr)
	//tested
	//public function insertLocationDataV2()
	{
		/* $bus_id = 1; 
		$route_id = 1; 
		$imei = 358672054574474; 
		$newlocation = 1.448880; 
		$newlocation1 =103.820102; 
		$speedkmhr = 20.0; */
		
		$time = self::getTime();
	
		$insertLocationDataV2_Query = DB::table('location_datav2')
							->insert([
							'bus_id'=>$bus_id,
							'route_id'=>$route_id,
							'imei'=>$imei,
							'latitude'=>$newlocation,
							'longitude'=>$newlocation1,
							'speed'=>$speedkmhr,
							'time'=>$time]);
	}
	public function updateFlagV2($flag,$bus_id,$route_id,$time)
	//tested
	//public function updateFlagV2()
	{
		/* $flag = 1;
		$bus_id = 1;
		$route_id = 1;
		$time = '2016-09-06 15:33:53'; */
		
		$updateFlag_Query = DB::table('location_datav2')
								->where('bus_id',$bus_id)
								->where('route_id',$route_id)
								->where('time',$time)
								->update(['flag' => $flag]);
	}
	public function getHistoryETA($bus_id,$route_id,$bus_service_no,$busstop_id,$keepTime)
	//tested
	//public function getHistoryETA()
	{
		/* $bus_id =1;
		$route_id =1;
		$bus_service_no =7;
		$busstop_id = 1002;
		$keepTime = 600; */
	
		$getHistoryETA_Query = DB::table('avg_speed_calculated')
									->select('avg_time','bus_stop_id_next')
									->where('route_id',$route_id)
									->where('bus_service_no',$bus_service_no)
									->where('bus_stop_id_next','>',$busstop_id)
									->get();
									
		if($keepTime != 0)
		{
			$time = $keepTime;
		}
		else
		{
			$time = 0;
		}
		
		foreach($getHistoryETA_Query as $singleset)
		{
			$time = $singleset->avg_time + $time;
			$avgspeed = -1;
			$calcTime = date("Y/m/d h:i:s", $time +strtotime("+0 seconds"));
			$get_Time = date('Y/m/d h:i:s', time());
			self::uploadETAV2($bus_id,$route_id,$singleset->bus_stop_id_next,$calcTime,$get_Time,$avgspeed);
			
		}
	}
	
	public function getFirstBusstopIDFromRoute($bus_id,$route_id)
	//tested
	//public function getFirstBusstopIDFromRoute()
	{
		/* $bus_id = 1;
		$route_id =1; */
		$getFirstBusstopIDFromRoute_Query = DB::table('route')
												->join('bus_route', 'bus_route.route_id', '=', 'route.route_id')
												->join('route_bus_stop', 'route.route_id', '=', 'route_bus_stop.route_id')
												->where('bus_route.bus_id',$bus_id)
												->where('bus_route.route_id',$route_id)
												->min('route_bus_stop.bus_stop_id');
		/* var_dump($getFirstBusstopIDFromRoute_Query);
		die();
		$totalbus = array();
		
		foreach($getFirstBusstopIDFromRoute_Query as $singleset)
		{
			$totalbus = $singleset;
		} */
		
		//return $totalbus[0];
		return $getFirstBusstopIDFromRoute_Query;
	}
	//tested
	public function getTotalBus()
	{
		$totalbus = array();
		
		$getTotalBus_Query = DB::table('bus')
								->select('bus_id')
								->get();
								
		foreach($getTotalBus_Query as $singleset)
		{
			array_push($totalbus,$singleset->bus_id);
		}
		
		return $totalbus;
	}
	
	
	
	public function getBusIDByBeacon($beacon_mac)
	{
		$getBusIDByBeacon_Query = DB::table('bus')
										->select('bus_id')
										->where('beacon_mac',$beacon_mac)
										->limit(1)
										->get();
		
		print($getBusIDByBeacon_Query->bus_id);
		return $getBusIDByBeacon_Query->bus_id;
	}
	
	public function getBusServiceNo($route_id,$bus_id)
	//tested
	//public function getBusServiceNo()
	{
		/* $route_id = 1;
		$bus_id = 1; */
		$getBusServiceNo_Query = DB::table('bus_route')
										->select('bus_route.bus_service_no')
										->join('bus','bus.bus_id','=','bus_route.bus_id')
										->join('route','route.route_id','=','bus_route.route_id')
										->where('route.route_id',$route_id)
										->where('bus_route.bus_id',$bus_id)
										->get();
		
		$data = array();
		
		foreach($getBusServiceNo_Query as $singleset)
		{
			$data= $singleset->bus_service_no;
		}
		
		if($data == null)
		{
			return null;
		}
		
		return $data;
	}
	
	public function getlatlongByPi($pi_id)
	{
		$getlatlongByPi_Query = DB::table('pi_info')
										->where('pi_id',$pi_id)
										->limit(1)
										->get();
		
		return $getlatlongByPi_Query;
	}
	
	public function getRouteID($bus_id)
	//tested
	//public function getRouteID()
	{
		/* $bus_id =2; */
		$getRouteID_Query = DB::table('bus_route')
								->select('route_id')
								->where('bus_id',$bus_id)
								->get();
								
		$route_id = array();
		
		foreach($getRouteID_Query as $singleset)
		{
			array_push($route_id,$singleset->route_id);
		}
		
		return $route_id;
	}
	
}
