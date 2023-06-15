<?php

namespace App\Http\Controllers;

use App\Mail\SendInternApplication;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class MapController extends Controller
{
    private function geocodeAddress($address)
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;

        $response = Http::get($url);

        if ($response->ok()) {
            $data = $response->json();

            if ($data['status'] === 'OK' && isset($data['results'][0]['geometry']['location'])) {
                $location = $data['results'][0]['geometry']['location'];

                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng']
                ];
            }
        }

        return null;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string',
            'review' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'nameCompany' => 'nullable|string',
            'emailCompany' => 'nullable|string',
        ]);

        $geocodedLocation = $this->geocodeAddress($validatedData['address']);

        if (!$geocodedLocation) {
            // Handle geocoding error
        }

        $locationData = array_merge($validatedData, $geocodedLocation);

        Location::create($locationData);

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
