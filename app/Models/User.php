<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'mobile_verified_at',
        'image', // این فیلد رو هم اضافه کن
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function CreateUser($request)
    {
        // --- آپلود و پردازش تصویر ---
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = self::uploadImage($request->file('image'));
        }
        // --- پایان آپلود تصویر ---

        $password = bcrypt($request->password); // رمز را هش کن

        // داده‌ها را برای ساخت کاربر آماده کن
        $userData = $request->except('password', 'image'); // فیلدهای password و image را جدا کن
        $userData['password'] = $password;
        if ($imagePath) {
            $userData['image'] = $imagePath;
        }

        // از متد create مدل استفاده کن
        $user = self::create($userData);

        return $user;
    }

    public static function UpdateUser($request, $user)
    {
        // --- آپلود و پردازش تصویر جدید ---
        $newImagePath = $user->image;

        if ($request->hasFile('image')) {
            // حذف تصویر قبلی اگر وجود داشت
            if ($user->image && Storage::disk('public')->exists('users/' . $user->image)) {
                Storage::disk('public')->delete('users/' . $user->image);
            }
            if ($user->image && Storage::disk('public')->exists('users/thumb/' . $user->image)) {
                Storage::disk('public')->delete('users/thumb/' . $user->image);
            }
            // آپلود تصویر جدید
            $newImagePath = self::uploadImage($request->file('image'));
        }
        // --- بقیه کد به همان صورت می ماند ---

        // داده‌های آپدیت
        $updateData = $request->except(['_token', '_method', 'image']);

        if ($request->filled('password')) {
            $updateData['password'] = bcrypt($request->password);
        } else {
            unset($updateData['password']);
        }

        $updateData['image'] = $newImagePath;

        $user->update($updateData);

        return $user;
    }

    private static function uploadImage($file)
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file->getRealPath());

            $filename = Str::random(30) . '_' . time() . '.webp';
            $image->toWebp(90);

            $imageLarge = clone $image;
            $imageLarge->scale(800);
            Storage::disk('public')->put('users/' . $filename, $imageLarge->toWebp());


            return $filename;

        } catch (\Exception $e) {
            \Log::error("Image upload error: " . $e->getMessage());
            return null;
        }
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::disk('public')->url('users/' . $this->image);
        }
        return asset('path/to/default/image.png');
    }

    /**
     * رابطه با سفارشات
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * رابطه با نظرات
     */
    public function reviews()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * آمار سفارشات تکمیل شده
     */
    public function getCompletedOrdersCountAttribute()
    {
        return $this->orders()->where('status', 'completed')->count();
    }

    /**
     * آمار نظرات
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * آمار سفارشات مرجوعی
     */
    public function getReturnedOrdersCountAttribute()
    {
        return $this->orders()->where('status', 'returned')->count();
    }

    /**
     * دریافت تعداد کل سفارشات کاربر
     */
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    /**
     * دریافت تعداد سفارشات در وضعیت‌های مختلف
     */
    public function getPendingOrdersCountAttribute()
    {
        return $this->orders()->where('status', 'pending')->count();
    }

    /**
     * رابطه با آدرس‌ها
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getProcessingOrdersCountAttribute()
    {
        return $this->orders()->where('status', 'processing')->count();
    }


    /**
     * دریافت 5 سفارش اخیر
     */
    public function getLatestOrdersAttribute()
    {
        return $this->orders()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }



}
