<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Image;
use App\Models\Pdf;
use App\Models\SoleProprietorship;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SoleProprietorshipController extends Controller
{
    //
    public function register(Request $request)
    {
        $user = request()->user();
        if (!$user) {
            return;
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_no' => 'required|string|max:20',
        ]);
        $SoleProprietorship = SoleProprietorship::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_no' => $validatedData['phone_no'],
            'user_id' => $user->id,
        ]);
        $SoleProprietorship->save();
        return redirect()->route('sole_proprietorship.upload_docs_page', ['id' => $SoleProprietorship->id]);
    }

    public function upload_docs_page($id)
    {
        $SP = SoleProprietorship::findOrFail($id);
        if (!$SP) {
            return;
        }
        $images = Image::where('sole_proprietorship_id', $SP->id)->get()->map(function ($image) {
            $image['type'] = 'image';
            return $image;
        });
        
        $pdfs = Pdf::where('sole_proprietorship_id', $SP->id)->get()->map(function ($pdf) {
            $pdf['type'] = 'pdf';
            return $pdf;
        });
        return Inertia::render(
            'Incorporation/Sole Proprietorship/UploadDocs',
            [
                'SP' => $SP,
                'images' => $images,
                'pdfs' => $pdfs
            ]
        );
    }

    public function upload_docs(Request $request, $id)
{
    // Validate only when the update flag is false
    if ($request->has('update') && $request->input('update') === false) {
        $rules = [
            'cnic' => 'required|file|mimes:jpeg,png,pdf|max:5120', // Max size in kilobytes (5MB)
            'letterhead' => 'required|file|mimes:jpeg,png,pdf|max:5120',
            'utility_bill' => 'required|file|mimes:jpeg,png,pdf|max:5120',
            'rental_agreement' => 'required|file|mimes:jpeg,png,pdf|max:5120',
        ];

        $request->validate($rules);
    }

    $user = auth()->user();
    if (!$user) {
        return; // or handle unauthorized access
    }

    $imageFiles = [];
    $pdfFiles = [];
    $deleted = [];

    // Handle deleted files
    if ($request->has('deleted')) {
        $deleted = $request->input('deleted');
        
    foreach ($deleted as $file) {
        if ($file['type'] == 'pdf') {
            $pdf = Pdf::findOrFail($file['id']);
            $pdf->delete();
        } else {
            $image = Image::findOrFail($file['id']);
            $image->delete();
        }
    }
    }


    // Separate image and pdf files
    foreach ($request->allFiles() as $key => $file) {
        if (in_array($key, ['cnic', 'letterhead', 'utility_bill', 'rental_agreement'])) {
            if (in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                $imageFiles[$key] = $file;
            } elseif ($file->getClientOriginalExtension() == 'pdf') {
                $pdfFiles[$key] = $file;
            }
        }
    }

    // Store image files
    foreach ($imageFiles as $key => $file) {
        $path = $file->store('sole_proprietorship_data', 'local');
        Image::create([
            'sole_proprietorship_id' => $id,
            'path' => $path,
            'what_for' => $key,
            'name' => $file->getClientOriginalName()
        ]);
    }

    // Store pdf files
    foreach ($pdfFiles as $key => $file) {
        $path = $file->store('sole_proprietorship_data', 'local');
        Pdf::create([
            'sole_proprietorship_id' => $id,
            'path' => $path,
            'what_for' => $key,
            'name' => $file->getClientOriginalName()
        ]);
    }

    $SP = SoleProprietorship::findOrFail($id);
    if (!$SP) {
        return; // or handle not found
    }

    // Handle cart associations
    if (!$user->cart) {
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);
    } else {
        $cart = $user->cart;
    }

    // Add sole proprietorship to the cart
    if (!$cart->sole_proprietorships()->where('sole_proprietorship_id', $SP->id)->exists()) {
        $cart->sole_proprietorships()->attach($SP->id);
    }

    return redirect()->route('user.cart');
}

    

public function delete(Request $request, $id)
{
    // Find the sole proprietorship record or fail
    $SP = SoleProprietorship::findOrFail($id);

    // Get associated images and PDFs
    $images = Image::where('sole_proprietorship_id', $SP->id)->get();
    $pdfs = Pdf::where('sole_proprietorship_id', $SP->id)->get();

    // Delete associated images
    foreach ($images as $image) {
        $image->delete();
    }

    // Delete associated PDFs
    foreach ($pdfs as $pdf) {
        $pdf->delete();
    }

    // Find and detach the SP from any cart
    $carts = Cart::whereHas('soleProprietorships', function ($query) use ($SP) {
        $query->where('sole_proprietorship_id', $SP->id);
    })->get();

    foreach ($carts as $cart) {
        $cart->sole_proprietorships()->detach($SP->id);
    }

    // Delete the sole proprietorship
    $SP->delete();

    // Redirect to the sole proprietorship index page
    return redirect()->route('sole_proprietorship.index');
}

}
