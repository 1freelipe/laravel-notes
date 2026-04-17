@extends('layout.main_layout')

@section('content')
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">

            @include('top_bar')

            <!-- notes are available -->
            <div class="d-flex justify-content-end mb-3 gap-3">
                <a href="{{ route('deletedNotes') }}" class="btn btn-secondary px-3">
                    <i class="fa-regular fa-pen-to-square me-2"></i>Deleted Notes
                </a>
                <a href="{{ route('new') }}" class="btn btn-secondary px-3">
                    <i class="fa-regular fa-pen-to-square me-2"></i>New Note
                </a>
            </div>

            @foreach($notes as $note)

            @include('note')

            @endforeach

        </div>
    </div>
</div>

@endsection
