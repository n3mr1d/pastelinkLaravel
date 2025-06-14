<?php

namespace App\Extensions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SessionMaria implements \SessionHandlerInterface
{
    protected $table = 'sessions';

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($sessionId)
    {
        $session = DB::table($this->table)->where('id', $sessionId)->first();
        if ($session) {
            return base64_decode($session->payload);
        }
        return '';
    }

    public function write($sessionId, $data)
    {
        $user = null;
        if (auth()->check()) {
            $user = auth()->user();
        }

        $payload = base64_encode($data);
        $now = time();

        $sessionData = [
            'id' => $sessionId,
            'payload' => $payload,
            'last_activity' => $now,
            'ip_address' => request()->ip(),
            'user_agent' => substr((string) request()->header('User-Agent'), 0, 500),
        ];

        // Jika user login, tambahkan username
        if ($user) {
            $sessionData['username'] = $user->username;
            $sessionData['user_id'] = $user->id;
        }

        // Upsert session
        $exists = DB::table($this->table)->where('id', $sessionId)->exists();
        if ($exists) {
            DB::table($this->table)->where('id', $sessionId)->update($sessionData);
        } else {
            DB::table($this->table)->insert($sessionData);
        }

        return true;
    }

    public function destroy($sessionId)
    {
        DB::table($this->table)->where('id', $sessionId)->delete();
        return true;
    }

    public function gc($lifetime)
    {
        $past = time() - $lifetime;
        DB::table($this->table)->where('last_activity', '<', $past)->delete();
        return true;
    }
}