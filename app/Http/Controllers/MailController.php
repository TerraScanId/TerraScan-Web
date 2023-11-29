<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $email = $request->get('email');

        $response = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getEmailAvailability?email=' . $email);
        $jsonData = $response->json();

        if (isset($jsonData['_id']) && !empty($jsonData['_id'])) {
            $id = $jsonData['_id'];

            $mailData = [
                'title' => 'TerraScan - tautan untuk mengubah password',
                'email' => $email,
                'url' => route('reset.show', ['id' => $id]),
            ];
    
            Mail::to($email)->send(new sendMail($mailData));

            return view('forget', ['success' => 'Tautan berhasil dikirim, mohon cek email anda']);
        } else {
            return view('forget', ['error' => 'Email tidak terdaftar']);
        }        

    }
}
