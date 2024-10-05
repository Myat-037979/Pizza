<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //direct user list page
    public function userList(){
        $users = User::where('role','user')->paginate('3');
        return view('admin.user.list',compact('users'));
    }

    //change Password Page
    public function changePasswordPage(){
        return view('user.password.change');
    }

    //user change role
    public function userChangeRole(Request $request){
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    //change Password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
        $user = User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue = $user->password;

        if(Hash::check($request->oldPassword, $dbHashValue)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            return back()->with(['changeSuccess'=>'Password Changed Success...']);
        }
        return back()->with(['notMatch' => 'The old password not match. Try again!']);
    }

    //account Change Page
    public function accountChangePage(){
        return view('user.profile.account');
    }
    //filter pizza
    public function filter($categoryId){
        $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

    //user account change
    public function accountChange($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        //for image
        if($request->hasFile('image')){
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return back()->with(['updateSuccess'=>'Admin Account Updated...']);
    }
    public function UserDelete($id){
        User::where('id',$id)->delete();
        return redirect()->route('admin#userList')->with(['deleteSuccess'=>'Poduct Delete Success...']);
    }

    //update user page
    public function UserUpdatePage($id){
        $user = User::where('id',$id)->first();
        return view('admin.user.update',compact('user'));
    }
    //update user
    public function UserUpdate(Request $request){
        $this->userValidationCheck($request);
        $data = $this->requestUserInfo($request);

        if($request->hasfile('image')){
            $oldImageName = User::where('id',$request->userId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$request->userId)->update($data);
        return redirect()->route('admin#userList');
    }

    private function requestUserInfo($request){
        return [
            'id' => $request->userId ,
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' =>$request->phone ,
            'gender' => $request->gender ,
            'address' => $request->address ,
        ];
    }

    //direct pizza drtails
    public function pizzaDetails($pizzaId){
        $pizza  = Product::where('id',$pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details',compact('pizza','pizzaList'));
    }

    //cart List
    public function cartList(){
        $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                    ->leftJoin('products','products.id','carts.product_id')
                    ->where('carts.user_id',Auth::user()->id)
                    ->get();
        $totalPrice = 0;
        foreach($cartList as $c){
            $totalPrice += $c->pizza_price*$c->qty;
        }
        //dd($totalPrice);
        return view('user.main.cart',compact('cartList','totalPrice'));
    }

    private function getUserData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now()
        ];
    }

    //direct history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('4');
        return view('user.main.history',compact('order'));
    }

    private function userValidationCheck($request){
        Validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required',
            'gender' =>'required',
            'phone' =>'required',
            'image' => 'mimes:png,jpg,jpeg|file',
            'address' =>'required'
        ])->validate();
    }


    //account Validation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' =>'required',
            'email' =>'required',
            'gender' =>'required',
            'phone' =>'required',
            'image' => 'mimes:png,jpg,jpeg|file',
            'address' =>'required'
        ])->validate();
    }

    //password Validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'confirmPassword' => 'required|min:6|max:10|same:newPassword'
        ])->validate();
    }


}
