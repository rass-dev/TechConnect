<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\PostComment;
use App\Rules\MatchOldPassword;
use Hash;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

public function index()
{
    $banners = Banner::where('status','active')->get();
    $product_lists = Product::where('status','active')->get();

    return view('frontend.index', compact('banners', 'product_lists'));
}

    // Profile
    public function profile()
    {
        $profile = auth()->user();
        return view('frontend.pages.userprofile', compact('profile'));
    }

public function profileUpdate(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'contact_number' => 'nullable|string|max:20',
        'postal_code' => 'nullable|string|max:10',
        'address' => 'nullable|string|max:255',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->contact_number = $request->contact_number;
    $user->postal_code = $request->postal_code;
    $user->address = $request->address;

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully!');
}



    // Orders
    public function orderIndex()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('id', 'DESC')->paginate(10);
        return view('frontend.pages.order.index', compact('orders'));
    }

    public function orderShow($id)
    {
        $order = Order::findOrFail($id);
        return view('frontend.pages.order.show', compact('order'));
    }

    public function userOrderDelete($id)
    {
        $order = Order::findOrFail($id);

        if (in_array($order->status, ['process', 'delivered', 'cancel'])) {
            return redirect()->back()->with('error', 'You cannot delete this order now');
        }

        $status = $order->delete();
        if ($status) {
            session()->flash('success', 'Order successfully deleted');
        } else {
            session()->flash('error', 'Order could not be deleted');
        }

        return redirect()->route('user.order.index');
    }

    // Product Reviews
    public function productReviewIndex()
    {
        $reviews = ProductReview::getAllUserReview();
        return view('frontend.pages.review.index', compact('reviews'));
    }

    public function productReviewEdit($id)
    {
        $review = ProductReview::findOrFail($id);
        return view('frontend.pages.review.edit', compact('review'));
    }

    public function productReviewUpdate(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);
        $status = $review->fill($request->all())->save();

        if ($status) {
            session()->flash('success', 'Review successfully updated');
        } else {
            session()->flash('error', 'Something went wrong! Please try again');
        }

        return redirect()->route('user.productreview.index');
    }

    public function productReviewDelete($id)
    {
        $review = ProductReview::findOrFail($id);
        $status = $review->delete();

        if ($status) {
            session()->flash('success', 'Successfully deleted review');
        } else {
            session()->flash('error', 'Something went wrong! Try again');
        }

        return redirect()->route('user.productreview.index');
    }

    public function userCommentEdit($id)
    {
        $comment = PostComment::findOrFail($id);
        return view('frontend.pages.comment.edit', compact('comment'));
    }

    public function userCommentUpdate(Request $request, $id)
    {
        $comment = PostComment::findOrFail($id);
        $status = $comment->fill($request->all())->save();

        if ($status) {
            session()->flash('success', 'Comment successfully updated');
        } else {
            session()->flash('error', 'Something went wrong! Please try again');
        }

        return redirect()->route('user.post-comment.index');
    }

    // Change Password
    public function changePassword()
    {
        return view('frontend.pages.userPasswordChange');
    }

    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        auth()->user()->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('user')->with('success', 'Password successfully changed');
    }
}
