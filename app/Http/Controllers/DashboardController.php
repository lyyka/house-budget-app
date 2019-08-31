<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $households = $user->households;
        $data = [
            'households' => $households,
        ];
        if(count($households) > 0){
            $data['paginated_households'] = $user->households()->paginate(5);
        }

        return view('dashboard')->with($data);
    }
}
