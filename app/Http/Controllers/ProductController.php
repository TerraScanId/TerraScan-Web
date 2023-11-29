<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    //Load product from database
    public function loadProduct()
    {

        $response = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllProduct');
        $jsonData = $response->json();

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();
        
        if ($response->successful() && $responseChat->successful() && isset($jsonData[0])) {
            // Kirim data produk ke tampilan Blade
            return view('product', [
                'jsonData' => $jsonData,
                'chats' => $jsonChat
            ]);
        } else {
            return redirect ('/product');
        }

    }

    //Show product details
    public function showProduct($productId)
    {
        $response = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getProductById?id='.$productId);
        $jsonData = $response->json();

        $responseChat = Http::withOptions(['verify' => false])->get('https://asia-south1.gcp.data.mongodb-api.com/app/application-0-xighs/endpoint/getAllChat');
        $jsonChat = $responseChat->json();

        if ($response->successful() && $responseChat->successful() && isset($jsonData[0])) {
            return view('productInfo', [
                'jsonData' => $jsonData,
                'chats' => $jsonChat
            ]);
        } else {
            return redirect('/product');
        }

    }
}
