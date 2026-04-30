<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">عنوان آدرس <span class="text-danger">*</span></label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title', $address->title ?? '') }}" required placeholder="مثال: خانه، محل کار">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">نام گیرنده <span class="text-danger">*</span></label>
        <input type="text" name="recipient_name" class="form-control @error('recipient_name') is-invalid @enderror"
               value="{{ old('recipient_name', $address->recipient_name ?? '') }}" required>
        @error('recipient_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">شماره تماس <span class="text-danger">*</span></label>
        <input type="tel" name="recipient_phone" class="form-control @error('recipient_phone') is-invalid @enderror"
               value="{{ old('recipient_phone', $address->recipient_phone ?? '') }}" required>
        @error('recipient_phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">کد پستی</label>
        <input type="text" name="postcode" class="form-control @error('postcode') is-invalid @enderror"
               value="{{ old('postcode', $address->postcode ?? '') }}">
        @error('postcode')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">استان</label>
        <input type="text" name="state" class="form-control @error('state') is-invalid @enderror"
               value="{{ old('state', $address->state ?? '') }}">
        @error('state')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">شهر <span class="text-danger">*</span></label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
               value="{{ old('city', $address->city ?? '') }}" required>
        @error('city')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">پلاک</label>
        <input type="text" name="plaque" class="form-control @error('plaque') is-invalid @enderror"
               value="{{ old('plaque', $address->plaque ?? '') }}">
        @error('plaque')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">واحد</label>
        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
               value="{{ old('unit', $address->unit ?? '') }}">
        @error('unit')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <div class="form-check mt-4">
            <input type="checkbox" name="is_default" class="form-check-input" id="is_default"
                   value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_default">
                آدرس پیش‌فرض باشد
            </label>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label">آدرس کامل <span class="text-danger">*</span></label>
        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror" required
                  placeholder="خیابان اصلی، کوچه، پلاک...">{{ old('address', $address->address ?? '') }}</textarea>
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
