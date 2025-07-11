@extends('layouts.superadmin.layout')
@section('content')
    <div class="relative">
        <livewire:superadmin.setting.city-detail  :id="$id" />
    </div>
@endsection