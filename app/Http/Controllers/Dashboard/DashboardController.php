<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount=User::where('type','USER')->count();
        $adminsCount=User::where('type','ADMIN')->count();
        $superAdminsCount=User::where('type','SUPER_ADMIN')->count();
        $wellsCount=Well::count();
        return view('dashboard.dashboard.index',compact('usersCount','adminsCount','superAdminsCount','wellsCount'));
    }
}
