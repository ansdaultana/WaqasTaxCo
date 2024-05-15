<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class IncorporationController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Incorporation/Index');
    }

    public function sole_proprietorship(Request $request)
    {
        $user = request()->user();
        if($user->sole_proprietorship->count() > 0)
        {
            $userDetails['phone_no'] = $user->phone_no;
            $userDetails['email'] = $user->email;
            return Inertia::render(
                'Incorporation/Sole Proprietorship/Register',
                [
                    'sole_proprietorships' => $user->sole_proprietorship,
                    'UserDetails' => $userDetails,
                    'newReg' => false,

                ]
            );
        }
        else
        {
            $userDetails['phone_no'] = $user->phone_no;
            $userDetails['email'] = $user->email;
            return Inertia::render(
                'Incorporation/Sole Proprietorship/Register',
                [
                    'UserDetails' => $userDetails,
                    'newReg' => true,

                ]
            );
        }
        
    }

}
