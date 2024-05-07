<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\NTN;
use App\Models\Price;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    //

    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->first();
        if ($cart) {
            $cartItem = NTN::find($cart->ntn_id);
            if ($cartItem) {
                $ntnPrice = Price::where('service_name', 'NTN')->value('price');
                $cartItem['name'] = 'NTN';
                $cartItem['price'] = $ntnPrice ?? 0;
                $cartItems[] = $cartItem;
            }
        }

        return Inertia::render(
            'User/Cart',
            [
                'cart' => $cart,
                'cartItems' => $cartItems ?? [], // Provide an empty array if $cartItems is null
                'isEmpty' => empty($cartItems) 
            ]
        );
    }

    public function delete(Request $request, $id)
    {
        $name = $request->input('name');
        $user = auth()->user();
        if ($name === 'NTN') {
            // Find the cart item
            $cart = Cart::findOrFail($id);
            // If the cart item exists and has an NTN ID
            if ($cart->ntn_id) {
                // Retrieve the NTN associated with the cart item
                $ntn = NTN::findOrFail($cart->ntn_id);

                // Delete the NTN
                $ntn->delete();
                $cart->ntn_id = null;
                $cart->save();
            }
        }
        return redirect(route('user.cart'));
    }
}
