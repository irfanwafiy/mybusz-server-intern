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

class CRUDController extends Controller
{
  public function uploadData(Request $request) {
      $file = $request->file('text');
      $serviceno = $request->input('serviceno');
      print('File Real Path: '.$file->getRealPath());
      // //Display File Name
      // echo 'File Name: '.$file->getClientOriginalName();
      // echo '<br>';
      //
      // //Display File Extension
      // echo 'File Extension: '.$file->getClientOriginalExtension();
      // echo '<br>';
      //
      // //Display File Real Path
      // echo 'File Real Path: '.$file->getRealPath();
      // echo '<br>';
      //
      // //Display File Size
      // echo 'File Size: '.$file->getSize();
      // echo '<br>';
      //
      // //Display File Mime Type
      // echo 'File Mime Type: '.$file->getMimeType();

      //Move Uploaded File
       $destinationPath = "../data/busstopPolylinePositions/".$serviceno.'/';
       $file->move($destinationPath,$file->getClientOriginalName());

       $myfile = fopen("../data/busstopPolylinePositions/".$serviceno.'/'."TestMinDistProximityFeatureDSM.txt", "r");

  }
}
