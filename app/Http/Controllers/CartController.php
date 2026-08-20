<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1|max:999',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty     = max(1, (int) $request->get('quantity', 1));
        $cart    = session('cart', []);
        $key     = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = min(999, $cart[$key]['qty'] + $qty);
        } else {
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'slug'     => $product->slug,
                'image'    => $product->image,
                'category' => $product->category?->name,
                'qty'      => $qty,
            ];
        }

        session(['cart' => $cart]);

        if ($request->wantsJson()) {
            return response()->json(['count' => count($cart), 'message' => 'Added to cart']);
        }
        return back()->with('success', "'{$product->name}' added to cart.");
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:0|max:999',
        ]);

        $cart = session('cart', []);
        $key  = (string) $request->product_id;

        if ($request->quantity == 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['qty'] = $request->quantity;
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session('cart', []);
        unset($cart[(string) $request->product_id]);
        session(['cart' => $cart]);

        if ($request->wantsJson()) {
            return response()->json(['count' => count($cart)]);
        }
        return back()->with('success', 'Item removed from cart.');
    }

    public function count()
    {
        return response()->json(['count' => count(session('cart', []))]);
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}
