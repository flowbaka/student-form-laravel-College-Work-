<form method="POST" action="{{ $action }}" class="delete-form" data-confirm="{{ $confirmation }}">
    @csrf
    @method('DELETE')
    <button type="submit" aria-label="{{ $label }}">Delete</button>
</form>
