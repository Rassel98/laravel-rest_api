<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;

class ProductController extends BaseController
{
    public function index(){
        $product=Product::all();
        // return $this->sentResponse($product->toArray(),'Data successfully return');

        return $this->sentResponse(ProductResource::collection($product),'Data successfully return');
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required'
        ]);
        if($validator->fails()){
            return $this->sentError('erroe',$validator->errors());
        }
        $product=Product::create($request->all());
        return $this->sentResponse(new ProductResource($product),'product insert successfully');
    }

    public function show($id){       
        $product=Product::where('product_id',$id)->first();
        if(is_null($product)){
            return $this->sentError('product not found');
        }
        return $this->sentResponse(new ProductResource($product),'success');
        // return response()->json($product,200);
    }

    public function update(Request $request, Product $product)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'price'=>'required'
        ]);
        if($validator->fails()){
            return $this->sentError('erroe',$validator->errors());
        }
        
        $product=Product::update($request->all());
        return $this->sentResponse(new ProductResource($product),'product update successfully');

    }
}
