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
        if($user->sole_proprietorships->count() > 0)
        {
            $userDetails['phone_no'] = $user->phone_no;
            $userDetails['email'] = $user->email;
            return Inertia::render(
                'Incorporation/Sole Proprietorship/Register',
                [
                    'sole_proprietorships' => $user->sole_proprietorships,
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
    public function aop(Request $request)
    {
        $user = request()->user();
        if($user->aops->count() > 0)
        {
            $userDetails['phone_no'] = $user->phone_no;
            $userDetails['email'] = $user->email;
            return Inertia::render(
                'Incorporation/Aop/Register',
                [
                    'Aops' => $user->aops,
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
                'Incorporation/Aop/Register',
                [
                    'UserDetails' => $userDetails,
                    'newReg' => true,

                ]
            );
        }
        
    }

}
