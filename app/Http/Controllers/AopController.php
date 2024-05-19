<?php

namespace App\Http\Controllers;

use App\Models\Aop;
use App\Models\Cart;
use App\Models\Image;
use App\Models\Pdf;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AopController extends Controller
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
        $Aop = Aop::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_no' => $validatedData['phone_no'],
            'user_id' => $user->id,
        ]);
        $Aop->save();
        return redirect()->route('Aop.upload_docs_page', ['id' => $Aop->id]);
    }
    public function upload_docs_page($id)
    {
        $Aop = Aop::findOrFail($id);
        if (!$Aop) {
            return; // Handle the case where Aop is not found
        }

        // Fetch and map images
        $images = Image::where('aop_id', $Aop->id)->get()->map(function ($image) {
            $image['type'] = 'image';
            return $image;
        });

        // Fetch and map PDFs
        $pdfs = Pdf::where('aop_id', $Aop->id)->get()->map(function ($pdf) {
            $pdf['type'] = 'pdf';
            return $pdf;
        });

        // Combine images and PDFs
        $documents = $images->merge($pdfs);
        return Inertia::render('Incorporation/Aop/UploadDocs', [
            'Aop' => $Aop,
            'documents' => $documents
        ]);
    }
    public function upload_docs(Request $request, $id)
    {

        // Validate only when the update flag is false
        if ($request->has('update') && $request->input('update') === false) {
            $rules = [
                'cnic*' => 'required|file|mimes:jpeg,png,pdf|max:5120', // Max size in kilobytes (5MB)
                'letterhead' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'electricity_bill' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'partnership_registration_certificate' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'partnership_deed' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'rental_agreement*' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'authority_letter*' => 'required|file|mimes:jpeg,png,pdf|max:5120',
            ];

            $request->validate($rules);
        }

        $user = auth()->user();
        if (!$user) {
            return;
        }

        $imageFiles = [];
        $pdfFiles = [];
        $deleted = [];

        if ($request->has('deleted')) {
            $deleted = $request->input('deleted');
            foreach ($deleted as $item) {
                // Check if $item is an array

                if (is_array($item)) {
                    // it means that item is an array containg data of a single item

                    // If $item is an array, check if 'type' and 'id' keys are present
                    if (isset($item['type']) && isset($item['id'])) {

                        // Determine the type of file and delete accordingly
                        if ($item['type'] == 'pdf') {
                            $pdf = Pdf::find($item['id']);
                            if ($pdf) {
                                $pdf->delete();
                            }
                        } elseif ($item['type'] == 'image') {
                            $image = Image::find($item['id']);
                            if ($image) {
                                $image->delete();
                            }
                        }
                    } else {
                        // it means that item is an array where each element contains data about the item
                        foreach ($item as $singleitem) {
                            if (isset($singleitem['type']) && isset($singleitem['id'])) {

                                if ($singleitem['type'] == 'pdf') {
                                    $pdf = Pdf::find($singleitem['id']);
                                    if ($pdf) {
                                        $pdf->delete();
                                    }
                                } elseif ($singleitem['type'] == 'image') {
                                    $image = Image::find($singleitem['id']);
                                    if ($image) {
                                        $image->delete();
                                    }
                                }
                            }
                        }


                    }
                }
            }
        }




        foreach ($request->allFiles() as $key => $files) {
            if (is_array($files)) {
                foreach ($files as $file) {
                    if (in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                        $imageFiles[$key][] = $file;
                    } elseif ($file->getClientOriginalExtension() == 'pdf') {
                        $pdfFiles[$key][] = $file;
                    }
                }
            } else {
                if (in_array($files->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                    $imageFiles[$key][] = $files;
                } elseif ($files->getClientOriginalExtension() == 'pdf') {
                    $pdfFiles[$key][] = $files;
                }
            }
        }

        // Store image files
        foreach ($imageFiles as $key => $files) {
            foreach ($files as $file) {
                $path = $file->store('aop_data', 'local');
                Image::create([
                    'aop_id' => $id,
                    'path' => $path,
                    'what_for' => $key,
                    'name' => $file->getClientOriginalName()
                ]);
            }
        }

        // Store pdf files
        foreach ($pdfFiles as $key => $files) {
            foreach ($files as $file) {
                $path = $file->store('aop_data', 'local');
                Pdf::create([
                    'aop_id' => $id,
                    'path' => $path,
                    'what_for' => $key,
                    'name' => $file->getClientOriginalName()
                ]);
            }
        }

        $Aop = Aop::findOrFail($id);
        if (!$Aop) {
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
        if (!$cart->aops()->where('aop_id', $Aop->id)->exists()) {
            $cart->aops()->attach($Aop->id);
        }

        return redirect()->route('user.cart');
    }



    public function delete(Request $request, $id)
    {
        // Find the sole proprietorship record or fail
        $Aop = Aop::findOrFail($id);

        // Get associated images and PDFs
        $images = Image::where('aop_id', $Aop->id)->get();
        $pdfs = Pdf::where('aop_id', $Aop->id)->get();

        // Delete associated images
        foreach ($images as $image) {
            $image->delete();
        }

        // Delete associated PDFs
        foreach ($pdfs as $pdf) {
            $pdf->delete();
        }

        // Find and detach the Aop from any cart
        $carts = Cart::whereHas('aops', function ($query) use ($Aop) {
            $query->where('aop_id', $Aop->id);
        })->get();

        foreach ($carts as $cart) {
            $cart->aops()->detach($Aop->id);
        }

        // Delete the sole proprietorship
        $Aop->delete();

        // Redirect to the sole proprietorship index page
        return redirect()->route('aop.index');
    }
}
