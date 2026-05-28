@extends('layouts.app')

@section('title', 'Chat - Crave')

@section('content')
    <livewire:chat-room :conversation="$conversation" />
@endsection
