@include('partials.errors')

<label for="name">Name *</label>
<input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required maxlength="255" autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @error('name') aria-describedby="name-error" @enderror>
@error('name') <p id="name-error" class="error">{{ $message }}</p> @enderror

<label for="email">Email *</label>
<input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required maxlength="255" autocomplete="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="email-error" @enderror>
@error('email') <p id="email-error" class="error">{{ $message }}</p> @enderror

<label for="phone">Phone *</label>
<input id="phone" name="phone" type="tel" value="{{ old('phone', $student->phone) }}" required maxlength="20" autocomplete="tel" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}" @error('phone') aria-describedby="phone-error" @enderror>
@error('phone') <p id="phone-error" class="error">{{ $message }}</p> @enderror

<label for="date_of_birth">Date of birth (optional)</label>
<input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" autocomplete="bday" aria-invalid="{{ $errors->has('date_of_birth') ? 'true' : 'false' }}" @error('date_of_birth') aria-describedby="date_of_birth-error" @enderror>
@error('date_of_birth') <p id="date_of_birth-error" class="error">{{ $message }}</p> @enderror

<label for="address">Address (optional)</label>
<textarea id="address" name="address" rows="3" maxlength="500" autocomplete="street-address" aria-invalid="{{ $errors->has('address') ? 'true' : 'false' }}" @error('address') aria-describedby="address-error" @enderror>{{ old('address', $student->address) }}</textarea>
@error('address') <p id="address-error" class="error">{{ $message }}</p> @enderror

<p>
    <button type="submit">{{ $submitLabel }}</button>
    <a href="{{ $student->exists ? route('students.show', $student) : route('students.index') }}">Cancel</a>
</p>
