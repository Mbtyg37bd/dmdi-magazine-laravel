@extends('admin.layouts.admin')

@section('title', 'Buat Ad - Admin')
@section('page-title', 'Buat Ad')

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('ads.index') }}" class="btn btn-light mb-3">← Kembali ke list</a>

        <div class="card">
            <div class="card-body">
                @include('admin.ads._form', ['action' => route('ads.store'), 'method' => 'POST', 'ad' => null])
            </div>
        </div>
    </div>
</div>
@endsection