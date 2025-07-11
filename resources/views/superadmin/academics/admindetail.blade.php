@extends('layouts.superadmin.layout')
@section('content')
    <div class="relative">
        <livewire:superadmin.academics.admin-detail :id="$id" />
    </div>
@endsection