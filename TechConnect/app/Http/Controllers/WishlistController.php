<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    private function jsonOrBack($success, $message)
    {
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'success' => $success,
                'message' => $message,
                'cart_count' => \Helper::cartCount(),
                'wishlist_count' => \Helper::wishlistCount(),
            ]);
        }
        request()->session()->flash($success ? 'success' : 'error', $message);
        return back();
    }

    public function wishlist(Request $request){
        if (empty($request->slug)) {
            return $this->jsonOrBack(false, 'Invalid product.');
        }
        $product = Product::where('slug', $request->slug)->first();
        if (empty($product)) {
            return $this->jsonOrBack(false, 'Invalid product.');
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        if($already_wishlist) {
            return $this->jsonOrBack(false, 'Product is already in your wishlist.');
        }

        $wishlist = new Wishlist;
        $wishlist->user_id = auth()->user()->id;
        $wishlist->product_id = $product->id;
        $wishlist->price = ($product->price-($product->price*$product->discount)/100);
        $wishlist->quantity = 1;
        $wishlist->amount = $wishlist->price * $wishlist->quantity;
        if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) {
            return $this->jsonOrBack(false, 'Stock not sufficient.');
        }
        $wishlist->save();
        return $this->jsonOrBack(true, 'Product added to wishlist.');
    }

    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            return $this->jsonOrBack(true, 'Removed from wishlist.');
        }
        return $this->jsonOrBack(false, 'Could not remove item. Please try again.');
    }
}
