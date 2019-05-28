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
use Illuminate\Support\Facades\Storage;
use JD\Cloudder\Facades\Cloudder;

class CRUDController extends Controller
{
  public function uploadData(Request $request) {

    $file = $request->file('file')->getRealPath();
    $url = $request->input('url');
    //array("resource_type" => "auto"
     //Cloudder::unsignedUpload($file, array("resource_type" => "video", "upload_preset" => "zbvi7a6n"));

     //return redirect()->back()->with('status', 'File Uploaded Successfully');
     $filecontent = file_get_contents($url);
     $result = explode(",",$filecontent);
     print_r($filecontent);
  }

  public function upload_json() {
    return view('uploadPolyline');
  }

  public function testing_files() {
    $filecontent = file_get_contents('../data/'.'7'.'.json');
    $json1 = json_decode($filecontent, true);
    $busroutecoords = $json1['1']['route'];

    print_r($busroutecoords);
  }
}
