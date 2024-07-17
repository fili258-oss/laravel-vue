<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{    
    public function index()
    {
        $products = DB::table('products')->get();
        return response()->json([
            'products' => $products
        ],200);
        


    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->image !="") 
        {
            $strpos = strpos($request->image,';');
            $sub = substr($request->image,0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time().".".$ex;
            $img = Image::read($request->image)->resize(200,200);
            $upload_path = public_path()."/upload/";
            $img->save($upload_path . $name);
            $product->image = $name;

        }else
        {
            $product->image = "no-picture.png";
        }
        $product->type = $request->type;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

    }
}
