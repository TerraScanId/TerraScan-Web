<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function profile()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        if($responseChat->successful()) {
            return view('profile', ['chats' => $jsonChat]);
        } else {
            return redirect('/profile');
        }
        
    }

    public function editprofile()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }
        
        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        if($responseChat->successful()) {
            return view('editprofile', ['chats' => $jsonChat]);
        } else {
            return redirect('/editprofile');
        }
        
    }

    public function updateProfile(Request $request)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        $tempUser = Session::get('user');

        $username = $request->input('username');
        $phoneNumber = $request->input('phoneNumber');
        $email = $request->input('email');
        $imageBase64 = null;

        // Jika ada gambar baru diunggah, ubah gambar ke base64
        if ($request->hasFile('profileImage')) {
            $image = $request->file('profileImage');
            $imageBase64 = base64_encode(file_get_contents($image->path()));
        }

        $data = [
            "username" => $username,
            "email" => $email,
            "phoneNumber" => $phoneNumber,
        ];
    
        if ($imageBase64 !== null) {
            $data["imageProfile"] = $imageBase64;
        }

        $response = Http::withOptions(['verify' => false])->put('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/updateUserById?id='.$user['_id'], $data);

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        if($response->successful())  {
            $tempUser['username'] = $username;
            $tempUser['email'] = $email;
            $tempUser['phoneNumber'] = $phoneNumber;

            if ($imageBase64 !== null) {
                $tempUser['imageProfile'] = $imageBase64;
            }

            Session::put('user', $tempUser);
            Session::save();
            
            return redirect("/profile");
        } else {
            return view('editprofile', [
                'error'=> "Gagal menyimpan perubahan",
                'chats' => $jsonChat
            ]);
        }
    }
}
