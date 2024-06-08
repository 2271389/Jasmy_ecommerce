<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function NotificationHistory(){
    	return Notification::latest('id')->take(5)->get();
    }
}
