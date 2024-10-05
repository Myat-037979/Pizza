<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get all product list
    public function productList(){
        $products = Product::get();
        return response()->json($products, 200);
    }

    //get all category lsit
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();
        return response()->json($category, 200);

    }

    public function cartList(){
        $cart = Cart::get();
        return response()->json($cart, 200);
    }

    public function contactList(){
        $contact = Contact::get();
        return response()->json($contact, 200);
    }

    public function orderList(){
        $order = Order::get();
        return response()->json($order, 200);
    }

    public function orderlistList(){
        $orderlist = OrderList::get();
        return response()->json($orderlist, 200);
    }

    public function userList(){
        $user = User::get();
        return response()->json($user, 200);
    }

    public function categoryDetails(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            return response()->json(['status' => true,'category'=> $data], 200);
        }
        return response()->json(['status' => false,'category'=>"there is no  category..."], 200);
    }


    //updaete category
    public function categoryUpdate(Request $request){
        $categorId = $request->category_id;

        $dbSource = Category::where('id',$categorId)->first();
        if(isset($dbSource)){
           $data = $this->getCategoryData($request);
           $response = Category::where('id',$categorId)->update($data);
           return response()->json(['status' => true,'message' => 'category update success...','category'=> $response], 200);
        }
          return response()->json(['status' => false,'message'=>"there is no category update..."], 500);
    }

    //delete data
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();

        if(isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => true,'message'=>"delete success"], 200);
        }
        return response()->json(['status' => false,'message'=>"there is no  category..."], 200);
    }

    //get contact data
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name ,
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now()
        ];

        $response = Category::create($data);
        return response()->json($response, 200);
    }

    public function categoryContact(Request $request){
        $data = $this->getContactData($request);
        Contact::create($data);

        $contact = Contact::get();
        return response()->json($contact, 200);
    }
    private function getContactData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'message' => $request->message ,
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now()
        ];
    }


    //get Category Data
    private function getCategoryData($request){
        return [
            'name' => $request->category_name ,
            'created_at' => Carbon::now() ,
            'updated_at' => Carbon::now()
        ];
    }
}
