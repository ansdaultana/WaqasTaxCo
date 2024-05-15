<?php

namespace App\Http\Controllers;

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
        $images=Image::where('sole_proprietorship_id',$SP->id)->get();
        $pdfs=Pdf::where('sole_proprietorship_id',$SP->id)->get();
        // dd($images,$pdfs);
        return Inertia::render(
            'Incorporation/Sole Proprietorship/UploadDocs',
            [
                'SP' => $SP,
                'images'=>$images,
                'pdf'=>$pdfs
            ]
        );
    }
  
    public function upload_docs(Request $request, $id)
    {
        $request->validate([
            'cnic' => 'required|file|mimes:jpeg,png,pdf|max:5120', // Max size in kilobytes (5MB)
            'letterhead' => 'required|file|mimes:jpeg,png,pdf|max:5120',
            'utility_bill' => 'required|file|mimes:jpeg,png,pdf|max:5120',
            'rental_agreement' => 'required|file|mimes:jpeg,png,pdf|max:5120',
        ]);

        $imageFiles = [];
        $pdfFiles = [];

        foreach ($request->allFiles() as $key => $file) {
            if (in_array($key, ['cnic', 'letterhead', 'utility_bill', 'rental_agreement']) && in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png'])) {
                $imageFiles[$key] = $file;
            } elseif (in_array($key, ['cnic', 'letterhead', 'utility_bill', 'rental_agreement']) && $file->getClientOriginalExtension() == 'pdf') {
                $pdfFiles[$key] = $file;
            }
        }
        foreach ($imageFiles as $key => $file) {
            $path = $file->store('sole_proprietorship_data', 'local');
            Image::create([
                'sole_proprietorship_id' => $id,
                'path' => $path,
                'what_for' => $key
            ]);
        }
        foreach ($pdfFiles as $key => $file) {
            $path = $file->store('sole_proprietorship_data', 'local');
            Pdf::create([
                'sole_proprietorship_id' => $id,
                'path' => $path,
                'what_for' => $key
            ]);
        }
        return redirect(route('user.dashboard'));
    }
}
