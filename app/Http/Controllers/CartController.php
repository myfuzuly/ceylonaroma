<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $this->mergeDbCart();
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
        $this->syncCartToDb($cart);

        if ($request->wantsJson()) {
            return response()->json(['count' => count($cart), 'message' => "'{$product->name}' added to cart"]);
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
        $this->syncCartToDb($cart);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required']);
        $cart = session('cart', []);
        $key  = (string) $request->product_id;
        unset($cart[$key]);
        session(['cart' => $cart]);

        if ($customerId = session('customer_id')) {
            CartItem::where('customer_id', $customerId)->where('product_id', $request->product_id)->delete();
        }

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
        if ($customerId = session('customer_id')) {
            CartItem::where('customer_id', $customerId)->delete();
        }
        return back()->with('success', 'Cart cleared.');
    }

    /* Merge DB cart into session when customer logs in or revisits */
    private function mergeDbCart(): void
    {
        $customerId = session('customer_id');
        if (!$customerId) return;

        $sessionCart = session('cart', []);
        $dbItems     = CartItem::where('customer_id', $customerId)->get();

        foreach ($dbItems as $item) {
            $key = (string) $item->product_id;
            if (!isset($sessionCart[$key])) {
                $sessionCart[$key] = [
                    'id'       => $item->product_id,
                    'name'     => $item->product_name,
                    'slug'     => $item->product_slug,
                    'image'    => $item->product_image,
                    'category' => $item->product_category,
                    'qty'      => $item->qty,
                ];
            }
        }

        if ($sessionCart !== session('cart', [])) {
            session(['cart' => $sessionCart]);
        }
    }

    /* Write current session cart to DB for logged-in customers */
    private function syncCartToDb(array $cart): void
    {
        $customerId = session('customer_id');
        if (!$customerId) return;

        foreach ($cart as $key => $item) {
            CartItem::updateOrCreate(
                ['customer_id' => $customerId, 'product_id' => $item['id']],
                [
                    'product_name'     => $item['name'],
                    'product_slug'     => $item['slug'],
                    'product_image'    => $item['image'] ?? null,
                    'product_category' => $item['category'] ?? null,
                    'qty'              => $item['qty'],
                ]
            );
        }

        /* Remove DB items no longer in session */
        $activeIds = array_column(array_values($cart), 'id');
        CartItem::where('customer_id', $customerId)
                ->whereNotIn('product_id', $activeIds)
                ->delete();
    }
}
