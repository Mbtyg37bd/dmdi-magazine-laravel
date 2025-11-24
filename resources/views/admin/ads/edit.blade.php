@extends('admin.layouts.admin')

@section('title', 'Edit Ad - Admin')
@section('page-title', 'Edit Ad')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('ads.index') }}" class="btn btn-light mb-3">← Kembali ke list</a>

        <div class="card">
            <div class="card-body">
                @include('admin.ads._form', ['action' => route('ads.update', $ad->id), 'method' => 'PUT', 'ad' => $ad])
            </div>
        </div>
    </div>
</div>
@endsection