<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class linkschecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:linkschecker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek semua link dan hapus yang offline';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("Checking links...");

        $links = Link::all();

        foreach ($links as $link) {
            $status = $this->isOnline($link->link);

            if ($status) {
                $link->is_online = true;
                $link->last_checked_at = now();
                $link->save();

                $this->line("[ONLINE] {$link->link}");
            } else {
                $this->line("[OFFLINE - DELETED] {$link->link}");
                $link->delete(); 
            }
        }

        $this->info("Done.");
    }

    protected function isOnline(string $url): bool
    {
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_NOBODY => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        if (str_ends_with($url, '.onion')) {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:9050');
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5_HOSTNAME);
        }

        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode >= 200 && $httpCode < 400;
    }
}
