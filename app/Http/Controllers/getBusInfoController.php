<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class getBusInfoController extends Controller
{
	public function getBusInfo()
	{
	
	$getBus = DB::table('bus')->get();
	//$getBus = "HEllo My World";
	return view('welcometest');
	}
	
	public function getTime()
	{
		date_default_timezone_set('Asia/Singapore');
		return date('Y-m-d H:i:s', time());
	}
	
	public function getBusRoute($route_id)
	{
	$getBusRoute_Query = DB::table('route')
	->where('route_id', $route_id)
	->get();
	$dataset_busRoute = new Collection;
	
	foreach($getBusRoute_Query as $singleset)
	{
	$getBusRoute_singleset = [
				'route_id' => $singleset->route_id,
				'polyline' => $singleset->polyline
				];

	$dataset_busRoute->push($getBusRoute_singleset);
	}
	
	print(json_encode($dataset_busRoute));
	/* return response()->json([
		'dataset_busRoute'=>$dataset_busRoute
		])->setStatusCode(200); */
	}
	
	public function getBusRouteInfo(Request $request)
	{
		$dataset_busRouteInfo = new Collection;
		$bus_id = $request->input('bus_id');
		$bus_no = $request->input('bus_no');
		
		$bus_route_info_route_id = DB::table('bus_route')
							->select('bus_route.route_id')
							->join('bus', 'bus_route.bus_id', '=', 'bus.bus_id')
							->join('route', 'bus_route.route_id', '=', 'route.route_id')
							->where('bus.bus_id',$bus_id)
							->where('bus_service_no',$bus_no)
							->get();
							
		foreach($bus_route_info_route_id as $r_id)
		{
			
			$bus_route_info = DB::table('route_bus_stop')
							->select('route.route_id', 'bus_stop.name')
							->join('route', 'route_bus_stop.route_id', '=', 'route.route_id')
							->join('bus_stop', 'route_bus_stop.bus_stop_id', '=', 'bus_stop.bus_stop_id')
							->where('route.route_id', $r_id->route_id)
							->orderBy('bus_stop.bus_stop_id', 'desc')
							->limit(1)
							->get();
							
			foreach($bus_route_info as $singleset)
			{
				$getBusRouteInfo_singleset = [
							'route_id' => $singleset->route_id,
							'bus_stop' => $singleset->name
							];

				$dataset_busRouteInfo->push($getBusRouteInfo_singleset);
			}
			
		}
		
		print(json_encode($dataset_busRouteInfo));
		/* return response()->json([
		'dataset_busRouteInfo'=>$dataset_busRouteInfo
		])->setStatusCode(200); */
		//return view('welcometest',compact('bus_route_info'));
	}
	
	
	public function getBusStop(Request $request)
	{
		$dataset_busStop = new Collection;
		$route_id = $request->input('route_id');
		
		$getBusStop_Query = DB::table('bus_stop')
							->select(	'bus_stop.bus_stop_id',
										'bus_stop.name',
										'bus_stop.latitude',
										'bus_stop.longitude'
									)
							->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
							->join('route', 'route.route_id', '=', 'route_bus_stop.route_id')
							->where('route.route_id', $route_id)
							->get();
		foreach($getBusStop_Query as $singleset)
		{
			$getBusStop_singleset = [
						'bus_stop_id' => $singleset->bus_stop_id,
						'name' => $singleset->name,
						'latitude' => $singleset->latitude,
						'longitude' => $singleset->longitude
						];

			$dataset_busStop->push($getBusStop_singleset);
		}
		
		print(json_encode($dataset_busStop));
	/* return response()->json([
		'dataset_busStop'=>$dataset_busStop
		])->setStatusCode(200); */					
		
	}
	
	public function getBusstopRoute(Request $request)
	{
		$route = $request->input('route');
		
		$getBusstopRoute_Query = DB::table('bus_stop')
									->select('bus_stop.bus_stop_id', 'bus_stop.name', 'bus_stop.latitude', 'bus_stop.longitude')
									->addselect(DB::raw('0 AS Distance'))
									->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
									->where('route_bus_stop.route_id', $route)
									->get();
		
		
		print(json_encode($getBusstopRoute_Query));
		
	}

	public function getLocationData()
	{
		$getLocationData_Query = DB::table('location_data')
									->where('time', '>', '2015-09-11')
									->where('time', '<', '2015-09-13')
									->get();
		
	
		
		print(json_encode($getLocationData_Query));
		/* return response()->json([
			'dataset_locationdata'=>$getLocationData_Query
			])->setStatusCode(200); */
	}
	
	public function getNearbyBusStop(Request $request)
	{
		$lat = $request->input('lat');
		$lng = $request->input('lng');
		
		
		$getNearbyBusStop_Query = DB::table('bus_stop')
										->select('*')
										->selectraw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',[$lat,$lng,$lat])
										->having('distance', '<', 1)
										->orderBy('distance')
										->get();
		
		
		print(json_encode($getNearbyBusStop_Query));
		/* return response()->json([
			'dataset_NearbyBusStop'=>$getNearbyBusStop_Query
			])->setStatusCode(200); */
	}

	public function getBusstopList(Request $request)
	{
		$route = $request->input('route');
		$bus_id = $request->input('bus_id');
		$time = self::getTime();
		//$time = date('Y/m/d H:i:s', time());
		//$time = '2014/12/29 10:19:48';
		$getBusstopList_Query = DB::table('location_datav2')
									->select('location_datav2.latitude','location_datav2.longitude')
									->where('location_datav2.route_id','=',$route)
									->where('location_datav2.bus_id','=',$bus_id)
									->whereraw('location_datav2.time > (? - INTERVAL 3600 SECOND)',[$time])
									->whereraw('location_datav2.time = ( SELECT MAX( v.time ) FROM location_datav2 v WHERE v.route_id =? AND v.bus_id =? )',[$route,$bus_id])
									->get();
		
		if(($getBusstopList_Query->count()) > 0)
		{
			foreach($getBusstopList_Query as $result)
			{
				$lat = $result->latitude;
				$lng = $result->longitude;
			}
			
			$getBusstopList_Query2 = DB::table('bus_stop')
										->select('bus_stop.bus_stop_id')
										->selectraw('(6371 * acos(cos(radians(?)) * cos(radians(bus_stop.latitude)) * cos(radians(bus_stop.longitude) - radians(?)) + sin(radians(?)) * sin(radians(bus_stop.latitude)))) AS distance',[$lat,$lng,$lat])
										->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
										->where('route_bus_stop.route_id', $route)
										->having('distance', '<', 0.5)
										->orderBy('distance')
										->limit(1)
										->get();
			
			
			if (($getBusstopList_Query2->count()) > 0) 
			{			
				foreach($getBusstopList_Query2 as $result2)
				{
					$bus_stop_id = $result2->bus_stop_id;
				}		
			}
			else	
			{
				$bus_stop_id = 0;
			}
		}
		else
		{
			$bus_stop_id = 0;
		}
		
		$getBusstopList_Query_Final = DB::table('bus_stop')
									->select('bus_stop.bus_stop_id', 'bus_stop.name', 'bus_stop.latitude', 'bus_stop.longitude')
									->addselect(DB::raw('0 AS Distance'))
									->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
									->where('route_bus_stop.route_id', $route)
									->where('bus_stop.bus_stop_id', '>', $bus_stop_id)
									->get();
		
		print(json_encode($getBusstopList_Query_Final));
		/* return response()->json([
			'dataset_BusstopList'=>$getBusstopList_Query_Final
			])->setStatusCode(200); */
	}
	
	public function getETA(Request $request)
	{
		$bus_stop_id = $request->input('bus_stop_id');
		$bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$dataset_ETA = new Collection;
		$time = self::getTime();
		//$time = date('Y/m/d H:i:s', time());
		//$time = '2014/10/29 10:19:48';
		
		$getETA_Query = DB::table('bus_route')
						->select('bus_route.route_id', 'bus_route.bus_service_no', 'eta')
						->join('etav2 AS e', function ($join) 
							{
								$join->on('bus_route.bus_id', '=', 'e.bus_id')
									->on('bus_route.route_id','=', 'e.route_id');
							})
						->where('e.bus_id', $bus_id)
						->where('e.route_id', $route_id)
						->where('bus_stop_id', $bus_stop_id)
						->where('e.eta', '>', $time)
						->whereraw('e.time = ( SELECT MAX( t.time ) FROM etav2 t WHERE t.bus_id = ? AND t.route_id = ?) ',[$bus_id,$route_id])
						->orderBy('e.time','desc')
						->get();
		
		$dataset_ETA = self::calculateEta($getETA_Query);
		
		print(json_encode($dataset_ETA));
		
		/* print(response()->json([
			'dataset_ETA'=>$dataset_ETA
			])->setStatusCode(200)); */
		 
	}
	
	public function getBusService(Request $request)
	{
		$bus_stop_id = $request->input('bus_stop_id');
		$dataset_BusService = new Collection;
		$time = self::getTime();
		//$time = date('Y/m/d H:i:s', time());
		//$currentTime = round(microtime(true));
		//$currentTime = '2015-12-28 15:41:00';
		
		$bus_service_Query = DB::table('etav2 AS e')
							->select('e.route_id','bus_route.bus_service_no')
							->selectraw('GROUP_CONCAT(DISTINCT eta) AS eta')
							->join('bus_route', function ($join) 
							{
								$join->on('bus_route.bus_id', '=', 'e.bus_id')
									->on('bus_route.route_id','=', 'e.route_id');
							})
							->where('e.bus_stop_id',$bus_stop_id)
							->where('e.eta', '>', $time)
							->where('e.time', '>',function($query)
											{
												$query->selectraw('MAX( time ) - INTERVAL 30 SECOND 
												FROM etav2 v 
												WHERE v.bus_id = e.bus_id 
												AND v.route_id = e.route_id');
											}
									)
							->groupBy('e.route_id', 'bus_route.bus_service_no')
							->orderBy('eta', 'desc')
							->get();
		
		$dataset_BusService = self::calculateEta($bus_service_Query);
		
		print(json_encode($dataset_BusService));
		/* return response()->json([
			'dataset_BusService'=>$dataset_BusService
			])->setStatusCode(200); */
	}
	
	public function updateLocation(Request $request)
	{
		$bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$imei = $request->input('imei');
		$latitude = $request->input('latitude');
		$longitude = $request->input('longitude');
		$speed = $request->input('speed');
		
		$updateLocation_Query = DB::table('location_data')
								->insert(
								['bus_id' => $bus_id,
								'route_id' => $route_id,
								'imei' => $imei,
								'latitude' => $latitude,
								'longitude' => $longitude,
								'speed' => $speed,
								'time' => $currentTime
								]);
		
		return response('Location data updated')->setStatusCode(200);
	}
	
	function calculateEta($calcETA_Result)
	{
		$dataset_calcETA = new Collection;
		date_default_timezone_set('Asia/Singapore');
		$currentTime = round(microtime(true));
		//$currentTime = round(94727184073);
		//echo $currentTime;
		//dd(json_encode($getETA_Query));
		foreach($calcETA_Result as $result)
		{
			$result->eta = self::processEta($currentTime, $result->eta);
			
			$dataset_calcETA->push($result);
		}	
		return $dataset_calcETA;
	}
	
	
	function processEta($t1, $etas)
	{
		$etaList = explode(",", $etas);
	
		for ($i = 0; $i < count($etaList); $i++) {
			$etaList[$i] = array(
			    "time" => $etaList[$i],
			    "relative_time" => self::getRelativeTime($t1, strtotime($etaList[$i]))
			);
		}

		return $etaList;
	}
	
	function getRelativeTime($t1, $t2) {
		$timediff = round(($t2-$t1)/60);

		return $timediff."m";
	}
}
