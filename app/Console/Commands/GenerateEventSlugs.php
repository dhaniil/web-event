<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateEventSlugs extends Command
{
    protected $signature = 'events:generate-slugs';
    protected $description = 'Generate slugs for events that dont have one';

    public function handle()
    {
        $this->info('Mulai generate slugs untuk events...');

        $events = Event::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($events as $event) {
            $baseSlug = Str::slug($event->name);
            $slug = $baseSlug;
            $counter = 1;

            // Periksa apakah slug sudah ada
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $event->slug = $slug;
            $event->save();
            $count++;
        }

        $this->info("Selesai! {$count} events telah di-update dengan slug baru.");
    }
}
