<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File; 
class AudioController extends Controller
{
    public function index()
    {
    	if ($handle = opendir(public_path('/uploads/practice/audio'))) {
		    while (false !== ($entry = readdir($handle))) {
		    	if($entry=="." || $entry==".." ) continue;
		    	if(File::exists(public_path('/uploads/practice/audio'))){
					File::delete(public_path('/uploads/practice/audio/'.$entry));
				}
		    }
		    closedir($handle);
		}
    }
    
}
