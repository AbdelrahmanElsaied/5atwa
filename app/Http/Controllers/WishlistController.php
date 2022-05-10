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
    public function index()
    {
        return Wishlist::all();
    }
    public function store(Request $request)
    {
        $request->validate([
            "quantity",
            "amount",
            "price",
            "product_id",
            "order_id",
            "user_id"

       ]);
       return wishlist::create($request->all());

    }

    public function show($id)
    {
        return wishlist::find($id);
    }



    public function update(Request $request,$id)
    {
        $request->validate([
            "quantity",
            "amount",
            "price",
            "product_id",
            "order_id",
            "user_id"

       ]);
       $wish= wishlist::find($id);
       $wish->update($request->all());
       return $wish;

    }


    public function destroy($id)
    {
         return wishlist::destroy($id);
    }





    public function wishlist(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $product->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','You already placed in wishlist');
            return back();
        }else{

            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $product->id;
            $wishlist->price = ($product->price-($product->price*$product->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($wishlist->product->stock < $wishlist->quantity || $wishlist->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $wishlist->save();
        }
        request()->session()->flash('success','Product successfully added to wishlist');
        return back();
    }

    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','Wishlist successfully removed');
            return back();
        }
        request()->session()->flash('error','Error please try again');
        return back();
    }
}
