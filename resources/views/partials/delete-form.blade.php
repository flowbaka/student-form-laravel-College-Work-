<form method="POST" action="{{ $action }}" data-confirm="{{ $confirmation }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="button-danger" aria-label="{{ $label }}">Delete</button>
</form>
