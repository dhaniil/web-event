@if(count($events) > 0)
    @foreach($events->chunk(4) as $chunk)
        <div class="atasan-card flex justify-center items-center gap-4 p-4">
            @foreach($chunk as $event)
                <div class="kard transition-all rounded-xl">
                    <a href="{{ route('events.show', $event->id) }}" class="img-href no-underline">
                        <div class="p-2 bg-white flex flex-col rounded-xl justify-center items-center">
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Image" class="card-img" loading="lazy" style="width: 12rem; height: 15rem; object-fit: cover; border-radius: 10px;">
                            <div class="flex flex-col items-center text-center w-full">
                                <h1 class="head text-lg max-w-sm text-center text-black w-full">{{ $event->name }}</h1>
                                <p class="desc max-w-sm w-full">{{ Str::limit($event->description, 80) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
@else
    <style>
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            text-align: center;
        }
        .empty-state-icon {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
        .empty-state-text {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .empty-state-subtext {
            font-size: 14px;
            color: #666;
        }
    </style>
    <div class="empty-state">
        <img src="https://raw.githubusercontent.com/tailwindtoolbox/Directory/master/shields/empty.svg" alt="No Events" class="empty-state-icon">
        <h3 class="empty-state-text">Tidak Ada Event yang Sesuai</h3>
        <p class="empty-state-subtext">Coba cari dengan kata kunci yang berbeda</p>
    </div>
@endif
