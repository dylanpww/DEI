@extends('layouts.app')

@section('title', 'Pesan - Crave')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Pesan Saya</h1>
    </div>

    <livewire:chat-list />
</div>
@endsection
