<?php

namespace App\Http\Controllers;

use App\Models\Aop;
use App\Models\Cart;
use App\Models\NTN;
use App\Models\Price;
use App\Models\SoleProprietorship;
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
            if ($cart->ntn_id) {
                $cartItem = NTN::find($cart->ntn_id);
                if ($cartItem) {
                    $ntnPrice = Price::where('service_name', 'NTN')->value('price');
                    $cartItem['name'] = 'NTN';
                    $cartItem['type'] = 'NTN';
                    $cartItem['price'] = $ntnPrice ?? 0;
                    $cartItems[] = $cartItem;
                }
            }

            // Handle Sole Proprietorship item
            foreach ($cart->sole_proprietorships as $soleProprietorship) {
                $spPrice = Price::where('service_name', 'sole_proprietorship')->value('price');
                $soleProprietorship['name'] =  $soleProprietorship['name'].' Sole Prop';
                $soleProprietorship['type'] = 'Sole Proprietorship';
                $soleProprietorship['price'] = $spPrice ?? 0;
                $cartItems[] = $soleProprietorship;
            }
            foreach ($cart->aops as $aop) {
                $aopPrice = Price::where('service_name', 'aop')->value('price');
                $aop['name'] =  $aop['name'].' AOP';
                $aop['type'] = 'AOP';
                $aop['price'] = $aopPrice ?? 0;
                $cartItems[] = $aop;
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
        $type = $request->input('type');
        $user = auth()->user();
        $cart = Cart::findOrFail($id);
        if ($type === 'NTN') {
            if ($cart->ntn_id) {
                $ntn = NTN::findOrFail($cart->ntn_id);
                $ntn->delete();
                $cart->ntn_id = null;
                $cart->save();
            }
        }
        elseif ($type === 'Sole Proprietorship') {
            $soleProprietorshipId = $request->input('deleteItemId');
            // If the cart item exists and has a Sole Proprietorship ID
            if ($cart->sole_proprietorships()->where('sole_proprietorship_id', $soleProprietorshipId)->exists()) {
                // Remove the Sole Proprietorship from the pivot table
                $cart->sole_proprietorships()->detach($soleProprietorshipId);
                // Optionally delete the Sole Proprietorship record itself
                $sp=SoleProprietorship::findOrFail($soleProprietorshipId);
                $sp->delete();
            }
        }
        elseif ($type === 'AOP') {
            $aopId = $request->input('deleteItemId');
            // If the cart item exists and has a Sole Proprietorship ID
            if ($cart->aops()->where('aop_id', $aopId)->exists()) {
                // Remove the Sole Proprietorship from the pivot table
                $cart->aops()->detach($aopId);
                // Optionally delete the Sole Proprietorship record itself
                $aop=Aop::findOrFail($aopId);
                $aop->delete();
            }
        }
        return redirect(route('user.cart'));
    }
}
