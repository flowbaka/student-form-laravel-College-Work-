@include('partials.validation-errors')

<div class="grid gap-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="name" class="field-label">Course name <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $course->name) }}" required maxlength="255" class="field" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @error('name') aria-describedby="name-error" @enderror>
        @error('name') <p id="name-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label for="description" class="field-label">Description <span aria-hidden="true" class="text-red-500">*</span></label>
        <textarea id="description" name="description" rows="4" required maxlength="10000" class="field" aria-invalid="{{ $errors->has('description') ? 'true' : 'false' }}" @error('description') aria-describedby="description-error" @enderror>{{ old('description', $course->description) }}</textarea>
        @error('description') <p id="description-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="duration" class="field-label">Duration in weeks <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="duration" name="duration" type="number" min="1" max="65535" step="1" value="{{ old('duration', $course->duration) }}" required class="field" aria-invalid="{{ $errors->has('duration') ? 'true' : 'false' }}" @error('duration') aria-describedby="duration-error" @enderror>
        @error('duration') <p id="duration-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="fee" class="field-label">Fee <span aria-hidden="true" class="text-red-500">*</span></label>
        <input id="fee" name="fee" type="number" min="0" max="99999999.99" step="0.01" value="{{ old('fee', $course->fee) }}" required class="field" aria-invalid="{{ $errors->has('fee') ? 'true' : 'false' }}" @error('fee') aria-describedby="fee-error" @enderror>
        @error('fee') <p id="fee-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="difficulty" class="field-label">Difficulty <span aria-hidden="true" class="text-red-500">*</span></label>
        <select id="difficulty" name="difficulty" required class="field" aria-invalid="{{ $errors->has('difficulty') ? 'true' : 'false' }}" @error('difficulty') aria-describedby="difficulty-error" @enderror>
            <option value="">Choose a difficulty</option>
            @foreach (\App\Models\Course::DIFFICULTIES as $difficulty)
                <option value="{{ $difficulty }}" @selected(old('difficulty', $course->difficulty) === $difficulty)>{{ $difficulty }}</option>
            @endforeach
        </select>
        @error('difficulty') <p id="difficulty-error" class="field-error">{{ $message }}</p> @enderror
    </div>
    <div class="flex flex-col justify-center">
        <input type="hidden" name="is_active" value="0">
        <label for="is_active" class="flex items-center gap-3 text-sm font-medium">
            <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', $course->is_active)) class="size-4 accent-blue-600" aria-invalid="{{ $errors->has('is_active') ? 'true' : 'false' }}" @error('is_active') aria-describedby="is-active-error" @enderror>
            Active course
        </label>
        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Uncheck to keep this course inactive.</p>
        @error('is_active') <p id="is-active-error" class="field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3 border-t border-slate-200 pt-6 dark:border-slate-800">
    <button type="submit" class="button-primary">{{ $submitLabel }}</button>
    <a href="{{ $course->exists ? route('courses.show', $course) : route('courses.index') }}" class="button-secondary">Cancel</a>
</div>
