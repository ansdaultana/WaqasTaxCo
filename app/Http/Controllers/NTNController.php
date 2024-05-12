<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Image;
use App\Models\NTN;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Storage;

class NTNController extends Controller
{
    //

    public function index()
    {
        $user = auth()->user();
        $ntn = Ntn::with('images')->where('user_id', $user->id)->first();

        if ($ntn) {
            $images = [];
            foreach ($ntn->images as $image) {
                // Encode each image to base64 and store them in an array
                $imageData = base64_encode(Storage::get($image->path));
                $images[] =
                [
                    'id' => $image->id,
                    'link' => 'data:image/jpeg;base64,' . $imageData
                ];
            }
            $ntn['encoded_images'] = $images;
            if (count($ntn['encoded_images']) > 0) {
                $ntn['hasImages'] = true;
            } else {
                $ntn['hasImages'] = false;

            }
            return Inertia::render(
                'NTN/Register',
                [
                    'ntn' => $ntn,
                    'mode'=>'Edit'
                ]
            );
        } else {

            return Inertia::render(
                'NTN/Register'
            );
        }


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

    public function edit(Request $request, $id)
    {
        $ntn = Ntn::with('images')->find($id);
    
        if (!$ntn) {
            return response()->json(['error' => 'NTN not found'], 404);
        }
        if ($request->has('deletedImages')) {
            foreach ($request->deletedImages as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    Storage::delete($image->path);
                    $image->delete();
                }
            }
        }
        $ntn = Ntn::with('images')->find($id);

        // Count the existing images
        $existingImageCount = $ntn->images->count();
    
        // Check if the total number of images exceeds 2
        if ($existingImageCount + count($request->file('images', [])) > 2) {
            return response()->json(['error' => 'Cannot exceed 2 images'], 422);
        }
    
        // Process uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'local');
                Image::create([
                    'ntn_id' => $ntn->id,
                    'path' => $path,
                ]);
            }
        }
    
        // Process deleted images
        
        return redirect()->route('user.cart');
    }

    public function finder_index()
    {

        return Inertia::render('NTN/Finder');
    }

    public function Ntn_find(Request $request)
    {
        // $cnic = $request->input('cnic');
        $data = [
            'Name' => 'Ans',
            'Registration_No' => '6433213123',
            'Reference_No' => '6233321-8',
            'STRN' => 'No',
            'Category' => 'Pakistani Male',
            'Registered_On' => '07-FEB-2020',
            'Tax_Office' => 'RTO BAHAWALNAGAR',
            'Registration_Status' => 'Income Tax: Active',
            'Address' => '16, Street # 1, Bahawalpur Road, Hasilpur (Old), Bahawalpur, Hasilpur.16, Street # 1, Bahawalpur Road, Hasilpur (Old), Bahawalpur, Hasilpur.'
        ];
    
        return response()->json(['Data' => $data]);
    }
    
}
