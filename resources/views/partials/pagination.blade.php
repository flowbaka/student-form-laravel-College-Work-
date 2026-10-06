@if ($records->hasPages())
    <p>
        @if ($records->previousPageUrl())
            <a href="{{ $records->previousPageUrl() }}">Previous</a>
        @endif

        Page {{ $records->currentPage() }} of {{ $records->lastPage() }}

        @if ($records->nextPageUrl())
            <a href="{{ $records->nextPageUrl() }}">Next</a>
        @endif
    </p>
@endif
