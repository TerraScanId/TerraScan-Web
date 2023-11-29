<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class RequestController extends Controller
{
    public function showRequestForm()
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'sellerAccount') {
            return redirect("/");
        }

        $sellerId = $user['sellerId'];

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        $responseProduct = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getProductBySellerId?sellerId='.$sellerId);
        $jsonProduct = $responseProduct->json();

        if($responseChat->successful() && $responseProduct->successful()) {
            return view('requestform', [
                'chats' => $jsonChat,
                'products' => $jsonProduct
            ]);
        } else {
            return redirect('/requestform');
        }
        
    }

    public function makerequest(Request $request)
    {
        if(empty(Session::get('user'))) {
            return redirect("/login");
        }

        $user = Session::get('user');
        if($user['accountType'] != 'sellerAccount') {
            return redirect("/");
        }

        $sellerId = $request->input('sellerId');
        $requestType = $request->input('requestType');
        $productId = $request->input('productId');
        $detail = $request->input('detail');


        $data = [
            "sellerId" => $sellerId,
            "request" => $requestType,
            "productId" => $productId,
            "detail" => $detail,
            "status" => "Menunggu"
        ];


        $response = Http::withOptions(['verify' => false])->post('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/insertRequest', $data);

        $idSeller = $user['sellerId'];

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        $responseProduct = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getProductBySellerId?sellerId='.$idSeller);
        $jsonProduct = $responseProduct->json();

        if($response->successful() && $responseChat->successful() && $responseProduct->successful())  {
            return view('requestform', [
                'chats' => $jsonChat,
                'products' => $jsonProduct,
                'success'=> "Berhasil melakukan permintaan"
            ]);
        } else {
            return view('requestform', [
                'chats' => $jsonChat,
                'products' => $jsonProduct,
                'error'=> "Gagal melakukan permintaan"
            ]);
        }
        
    }
}
