<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Image;
use App\Models\NTN;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NTNController extends Controller
{
    //

    public function index()
    {
        return Inertia::render('NTN/Register');
    }

    public function register(Request $request)
    {
        $user = auth()->user();

        if (!$user->ntn) {
            $ntn = NTN::create([
                'user_id' => $user->id,
            ]);
        } else {

            return redirect()->route('user.cart');

        }
        if (!$user->cart) {
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);
        } else {
            $cart = $user->cart;
        }

        if (!$cart->ntn_id) {
            $cart->ntn_id = $ntn->id;
            $cart->save();
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $path = $image->store('images', 'local');
                Image::create([
                    'ntn_id' => $ntn->id,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('user.cart');

    }
}
