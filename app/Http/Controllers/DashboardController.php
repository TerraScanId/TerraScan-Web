<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use App\Events\PusherBroadcast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function loadDashboard()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }
        
        $responseUser = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllUserOnlyId');
        $jsonUser = $responseUser->json();
        $pengguna = count($jsonUser);

        $responseProduk = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllProduct');
        $jsonProduk = $responseProduk->json();
        $produk = count($jsonProduk);

        $responseSeller = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllSeller');
        $jsonSeller = $responseSeller->json();
        $mitra = count($jsonSeller);

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        if($responseUser->successful() && $responseProduk->successful() && $responseSeller->successful() && $responsePermintaan->successful() && $responseChat->successful()) {
            return view('dashboard', [
                'pengguna' => $pengguna,
                'produk' => $produk,
                'mitra' => $mitra,
                'permintaan' => $permintaan,
                'chats' => $jsonChat
                ]);
        } else {
            return redirect ('/dashboard');
        }

        
    }

    public function loadProductDashboard()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $responseProduk = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllProduct');
        $jsonProduk = $responseProduk->json();

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        if($responseProduk->successful() && $responsePermintaan->successful()) {
            return view('productdashboard', [
                'products' => $jsonProduk,
                'permintaan' => $permintaan
            ]);
        } else {
            return redirect('/productdashboard');
        }

    }


    //INSERT PRODUCT
    public function loadAddProductDashboard()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $responseSeller = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllSeller');
        $jsonSeller = $responseSeller->json();

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        if ($responseSeller->successful()) {
            return view('addproduct', [
                'sellers' => $jsonSeller,
                'permintaan' => $permintaan
        ]);
        } else {
            return redirect('/productdashboard/add/');
        }
    }

    public function addProduct(Request $request)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $productName = $request->input('productName');
        $productDesc = $request->input('productDesc');
        $productPrice = $request->input('productPrice');
        $sellerId = $request->input('sellerId');
        $imageBase64 = null;


        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageBase64 = base64_encode(file_get_contents($image->path()));
        } elseif ($request->input('previewImageBase64')) {
            $imageBase64 = $request->input('previewImageBase64');
        }

        $data = [
            "productName" => $productName,
            "productDesc" => $productDesc,
            "productPrice" => $productPrice,
            "sellerId" => $sellerId,
        ];
    
        if ($imageBase64 !== null) {
            $data["encodeProductImage"] = $imageBase64;
        }

        $responseSeller = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllSeller');
        $jsonSeller = $responseSeller->json();

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        $response = Http::withOptions(['verify' => false])->post('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/insertProduct', $data);

        if($response->successful())  {
            return redirect("/productdashboard");
        } else {
            return view('addproduct', [
                'sellers' => $jsonSeller,
                'permintaan' => $permintaan,
                'error'=> "Gagal menyimpan perubahan"
        ]);
        }
    }


    //EDIT PRODUCT
    public function loadEditProductDashboard($productId)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $responseProduk = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getProductById?id='.$productId);
        $jsonProduk = $responseProduk->json();

        $responseSeller = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllSeller');
        $jsonSeller = $responseSeller->json();

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        if ($responseProduk->successful() && isset($jsonProduk[0])) {
            return view('editproduct', [
                'product' => $jsonProduk,
                'sellers' => $jsonSeller,
                'permintaan' => $permintaan
        ]);
        } else {
            return view('productdashboard');
        }
    }

    public function updateProduct(Request $request)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $productId = $request->input('productId');
        $productName = $request->input('productName');
        $productDesc = $request->input('productDesc');
        $productPrice = $request->input('productPrice');
        $sellerId = $request->input('sellerId');
        $imageBase64 = null;

        $responseProduk = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getProductById?id='.$productId);
        $jsonProduk = $responseProduk->json();

        if ($request->hasFile('productImage')) {
            $image = $request->file('productImage');
            $imageBase64 = base64_encode(file_get_contents($image->path()));
        } elseif ($request->input('previewImageBase64')) {
            $imageBase64 = $request->input('previewImageBase64');
        }

        $data = [
            "productName" => $productName,
            "productDesc" => $productDesc,
            "productPrice" => $productPrice,
            "sellerId" => $sellerId,
        ];
    
        if ($imageBase64 !== null) {
            $data["encodeProductImage"] = $imageBase64;
        }

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        $response = Http::withOptions(['verify' => false])->put('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/updateProductById?id='.$productId, $data);

        if($response->successful())  {
            return redirect("/productdashboard");
        } else {
            return view('editproduct', [
                'product' => $jsonProduk,
                'permintaan' => $permintaan,
                'error'=> "Gagal menyimpan perubahan"
        ]);
        }
    }


    //DELETE PRODUCT
    public function deleteproduct($productId)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $response = Http::withOptions(['verify' => false])->delete('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/deleteProductById?id='.$productId);

        if ($response->successful()) {
            return redirect("/productdashboard");
        } else {
            return redirect("/productdashboard");
        }
    }




    //Request Dashbord
    public function loadRequestDashboard()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        $responseRequest = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllRequest');
        $jsonRequest = $responseRequest->json();

        $responsePermintaan = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getPendingRequest');
        $jsonPermintaan = $responsePermintaan->json();
        $permintaan = count($jsonPermintaan);

        if($responseRequest->successful() && $responsePermintaan->successful()) {
            return view('requestdashboard', [
                'requests' => $jsonRequest,
                'permintaan' => $permintaan
            ]);
        } else {
            return redirect('/productrequest');
        }

    }

    public function setNotification($requestId, $sellerId, $productId, $action)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

        if($action == 'approve') {
            $setNotification = Http::withOptions(['verify' => false])->post('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/setNotification?requestId='.$requestId.'&sellerId='.$sellerId.'&action='.$action);
            if($setNotification->successful()) {
                return redirect("/productdashboard/edit/".$productId);
            }
        } else {
            $setNotification = Http::withOptions(['verify' => false])->post('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/setNotification?requestId='.$requestId.'&sellerId='.$sellerId.'&action='.$action);
            if($setNotification->successful()) {
                return redirect("/productrequest");
            }
        }
    }

    //Chatting
    public function deleteAllChat()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'adminAccount') {
            return redirect("/");
        }

       $response = Http::withOptions(['verify' => false])->delete('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/deleteAllChat');
        if($response->successful()) {
            return redirect("/dashboard");
        }
    }
}
