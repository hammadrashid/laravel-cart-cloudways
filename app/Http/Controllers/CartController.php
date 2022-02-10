<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart()
    {
        // Session::flush('cartItems');
        // var_dump(session('cartItems'));
        // Session::flush('cartItems');
        return view('cart.cart');
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);
        $cartItems = session()->get('cartItems', []);

        if (isset($cartItems[$id])) {
            $cartItems[$id]['quantity']++;
        } 
        else {
            $cartItems[$id] = [
                "Image_path"=> $product->image_path,
                "name"      => $product->name,
                "details"   => $product->details,
                "price"     => $product->price,
                "quantity"  => 1
            ];
        }
        session()->put('cartItems', $cartItems);
        return redirect()->back()->with('success', 'Product addedd to cart');
    }

    public function delete(Request $request){
        if($request->id){
            $cartItems = session()->get('cartItems', []);
            if(isset($cartItems[$request->id])){
                unset($cartItems[$request->id]);
                session()->put('cartItems', $cartItems);
            }
            return redirect()->back()->with('success', 'Product Deleted Successfully');
        }
    }
}
