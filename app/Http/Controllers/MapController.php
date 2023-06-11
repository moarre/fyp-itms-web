<?php

namespace App\Http\Controllers;

use App\Mail\SendInternApplication;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class MapController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'review' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'nameCompany' => 'nullable|string',
            'emailCompany' => 'nullable|string',
        ]);

        Location::create([
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
            'review' => $validatedData['review'],
            'rating' => $validatedData['rating'],
            'nameCompany' => $validatedData['nameCompany'],
            'emailCompany' => $validatedData['emailCompany'],
        ]);

        return redirect()->route('coordinator.dashboard');
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('coordinator.dashboard');
    }

    public function sendEmail(Request $request)
    {
        $emailCompany = $request->input('email');
        $userEmail = Auth::user()->email;

        $subject = 'Application for Intern'; // Modify this with your desired subject
        $body = 'Saya nak apply intern please.'; // Modify this with your desired email body

        $receiverEmail = urlencode($emailCompany);
        $subject = urlencode($subject);
        $body = urlencode($body);

        $redirectUrl = "mailto:$receiverEmail?subject=$subject&body=$body";

        return Redirect::to($redirectUrl);
    }
}
