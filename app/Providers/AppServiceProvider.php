<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bagikan jumlah notifikasi yang belum dikerjakan ke seluruh view
        View::composer('*', function ($view) {
            $jumlahNotif = 0;

            if (Auth::check()) {
                $userId = Auth::id();
                $today = Carbon::today()->toDateString();

                // Hitung jadwal hari ini milik user yang kondisinya masih kosong / belum dikerjakan
                $jumlahNotif = DB::table('perawatan')
                    ->where('id_pemilik_tanaman', $userId)
                    ->whereDate('tanggal_perawatan', $today)
                    ->where(function ($query) {
                        $query->whereNull('kondisi')
                              ->orWhere('kondisi', '')
                              ->orWhere('kondisi', '-')
                              ->orWhereRaw('LOWER(kondisi) = ?', ['belum']);
                    })
                    ->count();
            }

            $view->with('jumlahNotifBelumDikerjakan', $jumlahNotif);
        });
    }
}