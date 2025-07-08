<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Well;
use App\Models\Request;
use App\Models\SurveyRequest;
use App\Models\TestRequest;
use App\Models\TroubleshootRequest;
use Illuminate\Http\Request as HttpRequest;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $usersCount = User::where('type', 'USER')->count();
        $adminsCount = User::where('type', 'ADMIN')->count();
        $superAdminsCount = User::where('type', 'SUPER_ADMIN')->count();
        $totalUsers = $usersCount + $adminsCount + $superAdminsCount;

        // Well statistics
        $wellsCount = Well::count();

        // Request statistics
        $pendingRequests = Request::where('status', 'pending')->count();
        $surveyRequests = SurveyRequest::where('status', 'pending')->count();
        $testRequests = TestRequest::where('status', 'pending')->count();
        $troubleshootRequests = TroubleshootRequest::where('status', 'pending')->count();
        $totalPendingRequests = $pendingRequests + $surveyRequests + $testRequests + $troubleshootRequests;

        // Recent activity (last 7 days)
        $recentUsers = User::where('created_at', '>=', now()->subDays(7))->count();
        $recentWells = Well::where('created_at', '>=', now()->subDays(7))->count();

        return view('dashboard.dashboard.index', compact(
            'usersCount',
            'adminsCount',
            'superAdminsCount',
            'totalUsers',
            'wellsCount',
            'pendingRequests',
            'surveyRequests',
            'testRequests',
            'troubleshootRequests',
            'totalPendingRequests',
            'recentUsers',
            'recentWells'
        ));
    }
}
