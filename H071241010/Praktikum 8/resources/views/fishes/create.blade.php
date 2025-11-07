@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0">Tambah Ikan Baru</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('fishes.store') }}" method="POST">
                        
                        <!-- Meng-include form partial -->
                        @include('fishes._form', [
                            'submitButtonText' => 'Simpan Ikan Baru'
                        ])

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
