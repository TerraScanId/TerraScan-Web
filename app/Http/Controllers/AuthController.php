<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //Login Function
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $response = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getUserByEmailPassword?email=' . $email . '&password=' . md5($password));

        $jsonData = $response->json();

        if (isset($jsonData['_id']) && !empty($jsonData['_id'])) {
            Session::put('user', $jsonData);

            return redirect('/');
        } else {
            return view('login', ['error' => 'Akun tidak valid']);
        }

    }


    //Signup Function
    public function showSignupForm()
    {
        return view('signup');
    }

    public function signup(Request $request)
    {

        $username = $request->input('username');
        $phoneNumber = $request->input('phoneNumber');
        $email = $request->input('email');
        $password = $request->input('password');

        $errorMessage = ''; // Inisialisasi pesan error

        if (!$this->isValidSignupForm($username, $email, $phoneNumber, $password, $errorMessage)) {
            return view('signup', ['error' => $errorMessage]);
        }   

        if(!$this->isEmailAvailable($email, $errorMessage)) {
            return view('signup', ['error'=> $errorMessage]);
        }

        $response = Http::withOptions(['verify' => false])->post('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/insertUser', [
            "accountType" => "normalAccount",
            "username"=> $username,
            "email"=> $email,
            "phoneNumber" => $phoneNumber,
            "password"=> md5($password),
            "imageProfile" => $this->getEncodedImage(),
        ]);

        if($response->getStatusCode() == 200)  {
            return redirect("/login");
        } else {
            return view('signup', ['error'=> "Gagal mendaftarkan akun"]);
        }

    }

    public function isValidSignupForm(string $username, string $email, string $phoneNumber, string $password, &$errorMessage) {
        if (empty($username) || empty($email) || empty($phoneNumber) || empty($password)) {
            $errorMessage = 'Semua kolom harus diisi.';
            return false;
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = 'Format email tidak valid.';
            return false;
        }
    
        if (!ctype_digit($phoneNumber)) {
            $errorMessage = 'Nomor handphone harus berupa angka.';
            return false;
        }
    
        return true;
    }

    public function isEmailAvailable(string $email, &$errorMessage) {
        $response = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getEmailAvailability?email=' . $email);

        $jsonData = $response->json();

        if (!isset($jsonData) || empty($jsonData)) {
            return true;
        }
        
        if (isset($jsonData['_id']) && !empty($jsonData['_id'])) {
            $errorMessage = 'Email ini sudah digunakan';
            return false;
        } 
    }
    

    //Logout Function
    public function logout()
    {
        Session::forget('user');

        return redirect('/');
    }

    
    //Forget Function
    public function showForgetForm()
    {
        return view('forget');
    }

    public function showResetForm($id)
    {
        return view('reset', ['id' => $id]);
    }

    public function changePassword(Request $request)
    {
        $id = $request->get('id');
        $password = $request->get('password');
        $confirmPassword  = $request->get('confirmPassword');
        $md5Password = md5($password);

        if($password == $confirmPassword) {
            $response = Http::withOptions(['verify' => false])->put('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/updatePasswordById?id='.$id.'&password='.$md5Password);
            if($response->successful()){
                session()->flash('success', 'Kata sandi berhasil diubah.');
                return view('success_redirect');
            }
        } else {
            return view('reset', ['id' => $id, 'error'=> "Kata sandi tidak sama"]);
        }
    }


    //Encoded Image for Image Profile
    public function getEncodedImage() 
    {
        $imagePath = asset('assets/images/defaultProfile.png');
        $image = file_get_contents($imagePath);
        $base64 = base64_encode($image);
        
        return $base64;
    }

}
