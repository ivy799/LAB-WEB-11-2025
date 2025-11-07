@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h1 class="h3 mb-0">Edit Ikan: {{ $fish->name }}</h1>
                </div>
                <div class="card-body">
                    <!-- Form ini akan mengirim data ke route 'fishes.update' -->
                    <form action="{{ route('fishes.update', $fish) }}" method="POST">
                        @method('PUT') <!-- Method spoofing untuk UPDATE -->

                        <!-- Meng-include form partial -->
                        @include('fishes._form', [
                            'fish' => $fish, // Kirim data $fish ke partial
                            'submitButtonText' => 'Perbarui Data Ikan'
                        ])
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
