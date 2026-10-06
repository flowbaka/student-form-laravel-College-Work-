@include('partials.validation-errors')

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="name" class="field-label">Name <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required maxlength="255" autocomplete="name" class="field" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @error('name') aria-describedby="name-error" @enderror>
        @error('name') <p id="name-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="email" class="field-label">Email <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required maxlength="255" autocomplete="email" class="field" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="email-error" @enderror>
        @error('email') <p id="email-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="phone" class="field-label">Phone <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="phone" name="phone" type="tel" value="{{ old('phone', $student->phone) }}" required maxlength="30" autocomplete="tel" class="field" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}" @error('phone') aria-describedby="phone-error" @enderror>
        @error('phone') <p id="phone-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="date_of_birth" class="field-label">Date of birth <span class="font-normal text-slate-400">(optional)</span></label>
        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" max="{{ now()->toDateString() }}" autocomplete="bday" class="field" aria-invalid="{{ $errors->has('date_of_birth') ? 'true' : 'false' }}" @error('date_of_birth') aria-describedby="date-of-birth-error" @enderror>
        @error('date_of_birth') <p id="date-of-birth-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label for="address" class="field-label">Address <span class="font-normal text-slate-400">(optional)</span></label>
        <textarea id="address" name="address" rows="3" maxlength="2000" autocomplete="street-address" class="field" aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}" @error('address') aria-describedby="address-error" @enderror>{{ old('address', $student->address) }}</textarea>
        @error('address') <p id="address-error" class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-800">
    <button type="submit" class="button-primary">{{ $submitLabel }}</button>
    <a href="{{ $student->exists ? route('students.show', $student) : route('students.index') }}" class="button-secondary">Cancel</a>
</div>
