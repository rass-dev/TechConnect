<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $data = User::select(
                \DB::raw("COUNT(*) as count"),
                \DB::raw("DAYNAME(created_at) as day_name"),
                \DB::raw("DAY(created_at) as day")
            )
            ->where('created_at', '>', Carbon::today()->subDays(6))
            ->groupBy('day_name','day')
            ->orderBy('day')
            ->get();

        $array[] = ['Name', 'Number'];
        foreach ($data as $key => $value) {
            $array[++$key] = [$value->day_name, $value->count];
        }

        return view('backend.index')->with('users', json_encode($array));
    }

    public function profile()
    {
        $profile = Auth::user();
        return view('backend.users.profile')->with('profile', $profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name','email','phone']));

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

public function profileUpdatePhoto(Request $request, $id)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = User::findOrFail($id);

    if ($request->hasFile('photo')) {
        // delete old photo if exists
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        $file = $request->file('photo');
        $filename = time().'_'.$file->getClientOriginalName();
        $path = 'uploads/profile/';
        $file->move(public_path($path), $filename);

        $user->photo = $path.$filename;
        $user->save();
    }

    // must return JSON, para mahuli ng fetch
    return response()->json([
        'success'   => true,
        'photo_url' => asset($user->photo),
    ]);
}



    public function settings()
    {
        $data = Settings::first();
        return view('backend.setting')->with('data', $data);
    }

    public function settingsUpdate(Request $request)
    {
        $this->validate($request, [
            'short_des'   => 'required|string',
            'description' => 'required|string',
            'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address'     => 'required|string',
            'email'       => 'required|email',
            'phone'       => 'required|string',
        ]);

        $settings = Settings::first();
        $data = $request->all();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = 'uploads/settings/';
            $file->move(public_path($path), $filename);
            $data['photo'] = $path.$filename;
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $path = 'uploads/settings/';
            $file->move(public_path($path), $filename);
            $data['logo'] = $path.$filename;
        }

        $status = $settings->fill($data)->save();

        if ($status) {
            $request->session()->flash('success','Setting successfully updated');
        } else {
            $request->session()->flash('error','Please try again');
        }

        return redirect()->route('admin');
    }

    public function changePassword()
    {
        return view('backend.layouts.changePassword');
    }

    public function changePasswordStore(Request $request)
    {
        $request->validate([
            'current_password'     => ['required', new MatchOldPassword],
            'new_password'         => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('admin')->with('success','Password successfully changed');
    }
}
