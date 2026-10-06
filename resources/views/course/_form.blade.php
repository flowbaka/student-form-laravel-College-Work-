@include('partials.errors')

<label for="name">Name *</label>
<input id="name" name="name" type="text" value="{{ old('name', $course->name) }}" required maxlength="255">
@error('name') <p class="error">{{ $message }}</p> @enderror

<label for="description">Description (optional)</label>
<textarea id="description" name="description" rows="4" maxlength="10000">{{ old('description', $course->description) }}</textarea>
@error('description') <p class="error">{{ $message }}</p> @enderror

<label for="duration">Duration in weeks *</label>
<input id="duration" name="duration" type="number" value="{{ old('duration', $course->duration) }}" min="1" max="65535" step="1" required>
@error('duration') <p class="error">{{ $message }}</p> @enderror

<label for="fee">Fee *</label>
<input id="fee" name="fee" type="number" value="{{ old('fee', $course->fee) }}" min="0" max="99999999.99" step="0.01" required>
@error('fee') <p class="error">{{ $message }}</p> @enderror

<label for="difficulty">Difficulty *</label>
<select id="difficulty" name="difficulty" required>
    <option value="">Select difficulty</option>
    @foreach (\App\Models\Course::DIFFICULTIES as $difficulty)
        <option value="{{ $difficulty }}" @selected(old('difficulty', $course->difficulty) === $difficulty)>{{ $difficulty }}</option>
    @endforeach
</select>
@error('difficulty') <p class="error">{{ $message }}</p> @enderror

<input type="hidden" name="is_active" value="0">
<label for="is_active">
    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $course->is_active))>
    Active
</label>
@error('is_active') <p class="error">{{ $message }}</p> @enderror

<p>
    <button type="submit">{{ $submitLabel }}</button>
    <a href="{{ $course->exists ? route('courses.show', $course) : route('courses.index') }}">Cancel</a>
</p>
