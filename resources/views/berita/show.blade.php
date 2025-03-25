@extends('extend.main')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/eventonly.css') }}" />
    <style>
        .content-area {
            padding-top: 20px;
        }
        
        .berita-container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .berita-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .berita-header {
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        
        .berita-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .berita-metadata {
            color: #666;
            font-size: 0.9rem;
            margin: 1rem 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .berita-body {
            line-height: 1.8;
            color: #444;
            font-size: 1.1rem;
        }
        
        .berita-excerpt {
            font-size: 1.2rem;
            color: #555;
            font-style: italic;
            margin-bottom: 2rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-left: 4px solid #4F46E5;
            border-radius: 0 8px 8px 0;
        }
        
        @media (max-width: 768px) {
            .berita-metadata {
                flex-direction: column;
                gap: 5px;
            }
            
            .berita-title {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="content-area">
    <div class="container">
        <div class="berita-container">
            <div class="berita-header">
                <h1 class="berita-title">{{ $berita->judul ?? $berita->title }}</h1>
                <div class="berita-metadata">
                    <span><i class="fas fa-tag me-1"></i> Kategori: {{ ucfirst($berita->kategori ?? $berita->category) }}</span> •
                    <span><i class="far fa-calendar-alt me-1"></i> Diterbitkan: {{ ($berita->tanggal_terbit ?? $berita->published_at)->format('d M Y') }}</span> •
                    <span><i class="far fa-user me-1"></i> Oleh: {{ $berita->user?->name ?? $berita->author?->name ?? 'Admin' }}</span> •
                    <span><i class="far fa-eye me-1"></i> Dilihat: {{ $berita->views ?? 0 }} kali</span>
                </div>
            </div>

            <div class="berita-image-container">
                <img src="{{ $berita->image_url }}" 
                     alt="{{ $berita->judul ?? $berita->title }}" 
                     class="img-fluid berita-image">
            </div>

            @if(isset($berita->ringkasan) || isset($berita->excerpt))
                <div class="berita-excerpt">
                    {{ $berita->ringkasan ?? $berita->excerpt }}
                </div>
            @endif

            <div class="berita-body">
                {!! $berita->konten ?? $berita->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
