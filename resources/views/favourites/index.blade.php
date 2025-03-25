<!-- resources/views/favourites/index.blade.php -->
@extends('extend.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/eventonly.css') }}" />
    <style>
        /* Perbaikan layout halaman favorit */
        .event-container {
            min-height: calc(100vh - 180px);
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .page-title {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .page-title h1 {
            font-size: 1.8rem;
            color: #333;
        }
        
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 15px;
        }
        
        .empty-state-title {
            font-size: 1.5rem;
            color: #555;
        }
        
        .empty-state-description {
            color: #888;
        }
        
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
            border-radius: 10px;
            overflow: hidden;
            height: 100%;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        
        .card-body {
            display: flex;
            flex-direction: column;
        }
        
        .desc {
            flex-grow: 1;
        }
        
        .view-btn {
            margin-top: 15px;
        }
        
        .btn {
            border-radius: 5px;
            padding: 8px 15px;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
<div class="content-area">
    <div class="event-container">
        <div class="page-title">
            <h1>Event Favorit Saya</h1>
        </div>
        
        <div class="row">
            @if($favourites->isEmpty())
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="far fa-heart"></i>
                        </div>
                        <h3 class="empty-state-title">Belum Ada Event Favorit</h3>
                        <p class="empty-state-description">Anda dapat menambahkan event favorit dengan menekan tombol hati pada detail event</p>
                        <a href="{{ route('events.eventonly') }}" class="btn btn-primary mt-4">Lihat Semua Event</a>
                    </div>
                </div>
            @else
                @foreach($favourites as $favourite)
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $favourite->event->image) }}" class="card-img-top" alt="{{ $favourite->event->name }}">
                        <div class="card-body d-flex flex-column">
                            <div class="desc">
                                <h5 class="card-title">{{ $favourite->event->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($favourite->event->description, 55, '...') }}</p>
                            </div>
                            <div class="view-btn d-flex justify-content-between">
                                <a href="{{ route('events.show', $favourite->event->id) }}" class="btn btn-primary">Lihat Detail</a>
                                <form action="{{ route('favourite.remove', $favourite->event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection