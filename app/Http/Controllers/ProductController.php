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

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json([
            'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        $product = Product::find($id);        
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->image != $product->image)     
        {
            $strpos = strpos($request->image,';');
            $sub = substr($request->image,0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time().".".$ex;
            $img = Image::read($request->image)->resize(200,200);
            $upload_path = public_path()."/upload/";
            $image = $upload_path . $product->image;
            if (file_exists($image)) {
                @unlink($image);
            }
            $img->save($upload_path . $name);
            $product->image = $name;

        }else
        {
            $product->image = $product->image;
        }
        $product->type = $request->type;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $image_path = public_path() . "/upload/";
        $image = $image_path . $product->image;

        if (file_exists($image)) {
            @unlink($image);
        }
        $product->delete();


    }
}
