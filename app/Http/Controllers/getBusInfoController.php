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

	public function getBusRoute(Request $request)
	{

		$route_id = $request->input('route_id');
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

	if($dataset_busRoute!=NULL)
		print(json_encode($dataset_busRoute));
	else
		return response( "No bus route found")->setStatusCode(400);

	/* return response()->json([
		'dataset_busRoute'=>$dataset_busRoute
		])->setStatusCode(200); */
	}

	public function getBusRouteInfo_method($bus_id, $bus_no)
	{
		$array_busRouteInfo = array();
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
				 /* $getBusRouteInfo_singleset = [
							'route_id' => $singleset->route_id,
							'name' => $singleset->name
							];  */
				array_push($array_busRouteInfo, $singleset);
				//$dataset_busRouteInfo->push($getBusRouteInfo_singleset);
			}


		}

		return $array_busRouteInfo;


	}

	public function getBusRouteInfo(Request $request)
	{

		$array_busRouteInfo_result = array();
		//$dataset_busRouteInfo = new Collection;
		$bus_id = $request->input('bus_id');
		$bus_no = $request->input('bus_service_no');

		$array_busRouteInfo_result = self::getBusRouteInfo_method($bus_id, $bus_no);


		if($array_busRouteInfo_result!=NULL)
			print(json_encode($array_busRouteInfo_result));
		else
			return response( "No bus route found")->setStatusCode(400);


		//print(json_encode($dataset_busRouteInfo));
		/* return response()->json([
		'dataset_busRouteInfo'=>$dataset_busRouteInfo
		])->setStatusCode(200); */
		//return view('welcometest',compact('bus_route_info'));
	}



	public function getBusStop_method($route_id)
	{

		$array_busstop = array();

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
			/* $getBusStop_singleset = [
						'bus_stop_id' => $singleset->bus_stop_id,
						'name' => $singleset->name,
						'latitude' => $singleset->latitude,
						'longitude' => $singleset->longitude
						];

			$dataset_busStop->push($getBusStop_singleset); */

			array_push($array_busstop, $singleset);
		}

		return $array_busstop;
	}

	public function getBusStop(Request $request)
	{
		//$dataset_busStop = new Collection;
		$array_busstop_result = array();
		$route_id = $request->input('route_id');

		$array_busstop_result = self::getBusStop_method($route_id);

		if($array_busstop_result!=NULL)
			print(json_encode($array_busstop_result));
		else
			return response( "No bus stop found")->setStatusCode(400);

	/* return response()->json([
		'dataset_busStop'=>$dataset_busStop
		])->setStatusCode(200); */

	}

	public function getBusstopRoute_method($route)
	{
		$getBusstopRoute_Query = DB::table('bus_stop')
									->select('bus_stop.bus_stop_id', 'bus_stop.name', 'bus_stop.latitude', 'bus_stop.longitude')
									->addselect(DB::raw('0 AS Distance'))
									->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
									->where('route_bus_stop.route_id', $route)
									->orderBy('route_bus_stop.route_order')
									->get();

		return $getBusstopRoute_Query;
	}

	public function getBusstopRoute(Request $request)
	{
		$route = $request->input('route');


		$getBusstopRoute_result = self::getBusstopRoute_method($route);



		if($getBusstopRoute_result!=NULL)
			print(json_encode($getBusstopRoute_result));
		else
			return response( "No nearby bus stop found")->setStatusCode(400);

	}

	public function getBusstopRoute_Test(Request $request)
	{
		$route = $request->input('route_id');
		$array_busstopRoute = array();


		$getBusstopRoute_Query = DB::table('bus_stop')
									->select('bus_stop.bus_stop_id', 'bus_stop.name', 'bus_stop.latitude', 'bus_stop.longitude')
									->addselect(DB::raw('0 AS Distance'))
									->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
									->where('route_bus_stop.route_id', $route)
									->orderBy('route_bus_stop.route_order')
									->get();

		//print(json_encode($getBusstopRoute_Query));
		foreach($getBusstopRoute_Query as $singleset)
		{
			array_push($array_busstopRoute, $singleset);
		}

		if($getBusstopRoute_Query!=NULL)
			print(json_encode($array_busstopRoute));
			// print(json_encode($getBusstopRoute_Query));
		else
			return response( "No nearby bus stop found")->setStatusCode(400);

	}

	public function getLocationData()
	{
		$getLocationData_Query = DB::table('location_data')
									->where('time', '>', '2015-09-11')
									->where('time', '<', '2015-09-13')
									->get();






		if($getLocationData_Query!=NULL)
			print(json_encode($getLocationData_Query));
		else
			return response( "No location data found")->setStatusCode(400);
		/* return response()->json([
			'dataset_locationdata'=>$getLocationData_Query
			])->setStatusCode(200); */
	}

	public function getNearbyBusStop_method($lat, $lng)
	{
		$getNearbyBusStop_Query = DB::table('bus_stop')
										->select('*')
										->selectraw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',[$lat,$lng,$lat])
										->having('distance', '<', 1)
										->orderBy('distance')
										->get();

		return $getNearbyBusStop_Query;
	}

	public function getNearbyBusStop(Request $request)
	{
		$lat = $request->input('lat');
		$lng = $request->input('lng');

		$getNearbyBusStop_Query = self::getNearbyBusStop_method($lat, $lng);

		if($getNearbyBusStop_Query!=NULL)
			print(json_encode($getNearbyBusStop_Query));
		else
			return response( "No nearby bus stop found")->setStatusCode(400);

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
		$route_order = 0;

		if ($bus_stop_id > 0)
		{
			$getBusStopID = DB::table('route_bus_stop')
											->select('route_order')
											->where('route_id', $route)
											->where('bus_stop_id', $bus_stop_id)
											->first();


			$route_order = $getBusStopID->route_order;
		}


		$getBusstopList_Query_Final = DB::table('bus_stop')
									->select('bus_stop.bus_stop_id', 'bus_stop.name', 'bus_stop.latitude', 'bus_stop.longitude')
									->addselect(DB::raw('0 AS Distance'))
									->join('route_bus_stop', 'bus_stop.bus_stop_id', '=', 'route_bus_stop.bus_stop_id')
									->where('route_bus_stop.route_id', $route)
									->where('route_bus_stop.route_order', '>', $route_order)
									->get();


		if($getBusstopList_Query_Final!=NULL)
			print(json_encode($getBusstopList_Query_Final));
		else
			return response( "No Bus stop list found")->setStatusCode(400);

		/* return response()->json([
			'dataset_BusstopList'=>$getBusstopList_Query_Final
			])->setStatusCode(200); */
	}



	public function getETA_method($bus_stop_id, $bus_id, $route_id,$status)
	{
		$array_ETA = array();
		$time = self::getTime();
		//$time = date('Y/m/d H:i:s', time());
		//$time = '2014-10-29 10:19:48';

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

		$array_ETA = self::calculateEta($getETA_Query);
		$getETA_response = "".json_encode($array_ETA);

		if($status)
		{
			if($array_ETA!=NULL)
				return response($getETA_response)->setStatusCode(200);
			else
				return response("No bus service found")->setStatusCode(400);
		}
		else {
			if($array_ETA!=NULL)
				return $getETA_response;
			else
				return "No bus service found";
		}

	}

	public function getETA(Request $request)
	{
		$bus_stop_id = $request->input('bus_stop_id');
		$bus_id = $request->input('bus_id');
		$route_id = $request->input('route_id');
		$status = true;

		return self::getETA_method($bus_stop_id, $bus_id, $route_id, $status);
			//return response( "No bus service found")->setStatusCode(400);


		/* print(response()->json([
			'dataset_ETA'=>$dataset_ETA
			])->setStatusCode(200)); */

	}

	public function getBusService_method($bus_stop_id)
	{
		$array_BusService = array();
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

		$array_BusService = self::calculateEta($bus_service_Query);

		return $array_BusService;

	}

	public function getBusService(Request $request)
	{
		$bus_stop_id = $request->input('bus_stop_id');

		$array_BusService = self::getBusService_method($bus_stop_id);

		if($array_BusService!=NULL)
			print(json_encode($array_BusService));
		else
			return response("No bus service found")->setStatusCode(400);
			//response("400", "No bus service found");
			//print("No bus service found");
			//

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
		if($updateLocation_Query)
			return response('Location data updated')->setStatusCode(200);
		else
			return response('Unable to update location data')->setStatusCode(400);
	}

	function calculateEta($calcETA_Result)
	{
		//$dataset_calcETA = new Collection;
		$arr = array();
		date_default_timezone_set('Asia/Singapore');
		$currentTime = round(microtime(true));
		//$currentTime = round(94727184073);
		//echo $currentTime;
		//dd(json_encode($getETA_Query));
		foreach($calcETA_Result as $result)
		{
			//print($result->eta);
			$result->eta = self::processEta($currentTime, $result->eta);

			//print($result);

			array_push($arr,$result);
		}
		return $arr;
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

		return $timediff;
	}


	public function getBusStop_BusServices_method($bus_stop_id)
	{
		$busServices_array = array();
		$getRoute_id = DB::table('route_bus_stop')
							->select('route_bus_stop.route_id')
							->where('bus_stop_id',$bus_stop_id)
							->get();

		foreach ($getRoute_id as $singleset) {
			$getBusServiceList = DB::table('bus_route')
													->select('bus_route.bus_service_no')
													->where('route_id', $singleset->route_id)
													->distinct()
													->get();
			array_push($busServices_array, $getBusServiceList);
		}

		return $busServices_array;

	}

	public function getAllBusStop()
	{
		$array_allBusStop = array();
		$getAllBusStop_Query = DB:: table('bus_stop')
														->get();

		foreach($getAllBusStop_Query as $singleset)
		{

			$getBusService = self::getBusStop_BusServices_method($singleset->bus_stop_id);
			$busServices_array = array();
			foreach ($getBusService as $busService) {
				foreach ($busService as $bs) {
					array_push($busServices_array, $bs->bus_service_no);
				}

			}
			$dataset = [
				'bus_stop_id' => $singleset->bus_stop_id,
				'name' => $singleset->name,
				'latitude' => $singleset->latitude,
				'longitude' => $singleset->longitude,
				'bus_services' => $busServices_array
			];
			array_push($array_allBusStop, $dataset);
		}

		if($array_allBusStop != NULL)
			print(json_encode($array_allBusStop));
		else
			return response( "No bus stop registered")->setStatusCode(400);


	}

	public function getBusStopInfo(Request $request)
	{

		$bus_stop_id = $request->input('bus_stop_id');
		$bus_service_list = self::getBusStop_BusServices_method($bus_stop_id);
		$bus_service_available = self::getBusService_method($bus_stop_id);
		$getBusStopInfo_array = array();
		$getBusStopName = DB::table('bus_stop')
											->select('name')
											->where('bus_stop_id', $bus_stop_id)
											->first();
		foreach ($bus_service_list as $singleset)
		{
			$getDestination_route_id = DB::table('bus_route')
												->select('bus_route.route_id')
												->join('route_bus_stop','route_bus_stop.route_id', '=', 'bus_route.route_id')
												->where('route_bus_stop.bus_stop_id', $bus_stop_id)
												->where('bus_route.bus_service_no', $singleset[0]->bus_service_no)
												->first();
			$getDestination_name = DB::table('bus_stop')
														->select('bus_stop.name')
														->join('route_bus_stop','route_bus_stop.bus_stop_id', '=', 'bus_stop.bus_stop_id')
														->where('route_bus_stop.route_id', $getDestination_route_id->route_id)
														->orderBy('route_bus_stop.route_order', 'desc')
														->first();
			$eta = NULL;
			foreach ($bus_service_available as $singleset2)
			{
				if($singleset[0]->bus_service_no == $singleset2->bus_service_no)
				{
					$eta = $singleset2->eta;
				}
			}

			if($eta != NULL)
			{
				$dataset_busList = [
					'bus_service_no' => $singleset[0]->bus_service_no,
					'stop_eta' => $eta,
					'Destination' => $getDestination_name->name
				];
			}
			else
			{
				$dataset_busList = [
					'bus_service_no' => $singleset[0]->bus_service_no,
					'stop_eta' => "NA",
					'Destination' => $getDestination_name->name
				];
			}

			array_push($getBusStopInfo_array, $dataset_busList);
		}
			// $stop_name = $getBusStopName->name;

		$data = [
		'bus_data' => $getBusStopInfo_array,
		'stop_name' => $getBusStopName->name
	];
		return view('bus_stop_info')->with('data',json_decode($data,true));
	}

	//mobile APP

	public function getbus_stop_bus_services(Request $request)
	{
		$bus_stop_id = $request->input('bus_stop_id');

		return self::getBusStop_BusServices_method($bus_stop_id);
	}

	public function getbus_stops_eta(Request $request)
	{

		$bus_service_no = $request->input('bus_service');
		$route_id = $request->input('route_id');

		return self::bus_stops_eta_method($route_id,$bus_service_no);

	}

	public function bus_stops_eta_method($route_id,$bus_service_no)
	{

			$route_busstops = self::getBusstopRoute_method($route_id);
			$route_busstops_array = array();
			foreach ($route_busstops as $singleset2)
			{
				$BusService = self::getBusService_method($singleset2->bus_stop_id);
				$eta = NULL;

				foreach ($BusService as $singleset3)
				{
					if($singleset3->bus_service_no == $bus_service_no)
					{
						$eta = $singleset3->eta;
					}

				}

				if($eta != NULL)
				{
					$dataset_busList = [
						'stop_id' => $singleset2->bus_stop_id,
						'stop_name' => $singleset2->name,
						'stop_eta' => $eta
					];
				}
				else
				{
					$dataset_busList = [
						'stop_id' => $singleset2->bus_stop_id,
						'stop_name' => $singleset2->name,
						'stop_eta' => "NA"
					];
				}

			 array_push($route_busstops_array, $dataset_busList);

			}


			return $route_busstops_array;


	}

	public function getListBus(Request $request)
	{
		$listBus_array = array();
		$bus_service_no = $request->input('bus_service');

		$bus_route_info_route_id = DB::table('bus_route')
							->select('bus_route.bus_id')
							->where('bus_service_no',$bus_service_no)
							->first();

		$bus_id = $bus_route_info_route_id->bus_id;

		$getBusRouteInfo = self::getBusRouteInfo_method($bus_id, $bus_service_no);

		foreach ($getBusRouteInfo as $singleset)
		{
			$route_busstops_array = self::bus_stops_eta_method($singleset->route_id,$bus_service_no);

			$dataset_busList = [
				'routeInfo' => $singleset,
				'route_busstops' => $route_busstops_array
			];

			array_push($listBus_array, $dataset_busList);

		}


			return $listBus_array;



	}

	public function getmobile_nearbyStop(Request $request)
	{
		$lat = $request->input('lat');
		$lng = $request->input('lng');

		$nearbyBusStop = self::getNearbyBusStop_method($lat,$lng);
		$array_getmobile_nearbyStop = array();
		$array_getmobile_nearbyStop_return = array();

		foreach($nearbyBusStop as $singleset)
		{
			if(count($array_getmobile_nearbyStop) > 2)
			{
				break;
			}
			else {
				array_push($array_getmobile_nearbyStop, $singleset);

			}

		}


		foreach ($array_getmobile_nearbyStop as $singleset2) {
				$array_mobileBusService = self::getBusService_method($singleset2->bus_stop_id);

				$dataset_getmobile_nearbyStop = [
					'stop_id' => $singleset2->bus_stop_id,
					'bus_stop_name' => $singleset2->name,
					'busService' => $array_mobileBusService
				];
				array_push($array_getmobile_nearbyStop_return, $dataset_getmobile_nearbyStop);
		}

		return $array_getmobile_nearbyStop_return;

	}

}
