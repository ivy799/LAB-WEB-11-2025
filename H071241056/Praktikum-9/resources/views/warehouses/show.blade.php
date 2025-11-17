@extends('layouts.app')

@section('title', 'Detail Gudang')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Detail Gudang: {{ $warehouse->name }}</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Gudang</th>
                        <td>{{ $warehouse->name }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>{{ $warehouse->location ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $warehouse->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $warehouse->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mt-3">
            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection