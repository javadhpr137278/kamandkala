<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

// اضافه کن
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// اضافه کن (برای update)
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // این قسمت درست بود
        $users = User::query()->paginate(12);
        $user = User::all();
        return view('admin.users.list', compact('users', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // این قسمت هم درست بود
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        // متد CreateUser در مدل User را صدا می‌زند
        User::CreateUser($request);

        // پیام موفقیت و بازگشت به لیست
        return redirect()->route('users.index')->with('success', 'کاربر جدید با موفقیت اضافه شد'); // Use 'success' for green alert
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user) // از Route Model Binding استفاده کن
    {
        // $user = User::findOrFail($id); // این کار را Route Model Binding انجام می‌دهد
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'mobile' => ['required', 'string', 'regex:/^09[0-9]{9}$/', Rule::unique('users')->ignore($user->id)],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // فقط $request و $user را پاس بده، نه $validated را
        $updatedUser = User::UpdateUser($request, $user);  // ← حذف $validated

        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت به‌روزرسانی شد.');
    }    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image && Storage::disk('public')->exists('users/' . $user->image)) {
            Storage::disk('public')->delete('users/' . $user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'کاربر با موفقیت حذف شد.');
    }

    public function createUserRole($id)  // تغییر: به جای User $user
    {
        $user = User::findOrFail($id);  // اضافه کنید
        $roles = Role::all();
        return view('admin.users.user_roles', compact('user', 'roles'));
    }

    public function storeUserRole(Request $request, $id)  // تغییر: به جای User $user
    {
        $user = User::findOrFail($id);  // اضافه کنید

        $request->validate([
            'roles' => ['required', 'array'],
            'roles.*' => ['exists:roles,name']
        ]);

        $user->syncRoles($request->roles);
        return redirect()->route('users.index')->with('message', 'کاربر به نقش متصل شد.');
    }
}
