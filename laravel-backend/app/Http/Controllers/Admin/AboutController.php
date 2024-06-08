<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteInfo;

class AboutController extends Controller
{
    public function getSiteInfo(){
    	$result = SiteInfo::get();
    	return $result;
    }
}
