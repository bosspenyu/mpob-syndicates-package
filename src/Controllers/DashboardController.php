<?php

namespace Mpob\Syndicates\Controllers;

use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
	public function index()
	{
		return view('syndicates::dashboard');
	}
}
