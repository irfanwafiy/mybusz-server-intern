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

     Cloudder::unsignedUpload($file, 'zbvi7a6n',array("resource_type" => "auto"));

     return redirect()->back()->with('status', 'File Uploaded Successfully');


  }
}
