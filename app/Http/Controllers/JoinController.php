<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
class JoinController extends Controller
{
    public function create()
    {   
        $organization=User::findOrFail(request('organization_id'));

        return view('join',compact('organization'));
    }
    public function store(Request $request)
    {   
       auth()->user()->organizations()->attach($request->input('organization_id'),['role_id'=>$request->input('role_id')]);
       //b * Above attach means data attache the organization function which include belongsTo at app\Models\User.php

       return redirect()->route('home');
    }

    public function organizations()
    {   
        $organization=User::findOrFail(request('organization_id'));
        $role=DB::table('organization_user')
           ->where('organization_id',$organization->id)
           ->where('user_id',auth()->id())
           ->first();
        session([
            'organization_id'=>$organization->id,
            'organization_name'=>$organization->name,
            'organization_role_id'=>$role->role_id,
            ]);
        return back();
    }
}
