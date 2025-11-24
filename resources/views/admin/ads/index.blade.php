@extends('admin.layouts.admin')

@section('title', 'Ads - Admin')
@section('page-title', 'Ads')

@section('content')
<div class="row">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Ads</h4>
        <a href="{{ route('ads.create') }}" class="btn btn-primary">Buat Ad Baru</a>
    </div>

    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Position</th>
                            <th>Image</th>
                            <th>URL</th>
                            <th>Active</th>
                            <th>Priority</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ads as $ad)
                            <tr>
                                <td>{{ $loop->iteration + (($ads->currentPage() - 1) * $ads->perPage()) }}</td>
                                <td>{{ $ad->name }}</td>
                                <td>{{ $ad->position }}</td>
                                <td style="width:160px;">
                                    @if($ad->image_path)
                                        <img src="{{ asset(ltrim($ad->image_path, '/')) }}" alt="{{ $ad->name }}" style="max-width:150px; height:auto;">
                                    @else
                                        <span class="text-muted small">No image</span>
                                    @endif
                                </td>
                                <td style="max-width:220px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    <a href="{{ $ad->url }}" target="_blank" rel="noopener noreferrer">{{ $ad->url }}</a>
                                </td>
                                <td>{{ $ad->is_active ? 'Yes' : 'No' }}</td>
                                <td>{{ $ad->priority }}</td>
                                <td>
                                    <a href="{{ route('ads.edit', $ad->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                    <form action="{{ route('ads.destroy', $ad->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus ad ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">Belum ada iklan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $ads->links() }}
        </div>
    </div>
</div>
@endsection