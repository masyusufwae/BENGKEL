<?php

namespace App\Helpers;

use Carbon\Carbon;

class ServiceScheduleHelper
{
    /**
     * Standar interval servis berkala per merk (dalam bulan)
     * Berdasarkan rekomendasi pabrikan
     */
    private static $serviceIntervals = [
        'toyota' => 6,
        'honda' => 6,
        'nissan' => 6,
        'daihatsu' => 6,
        'mitsubishi' => 6,
        'suzuki' => 6,
        'hyundai' => 6,
        'kia' => 6,
        'bmw' => 12,
        'mercedes' => 12,
        'audi' => 12,
    ];

    /**
     * Hitung jadwal servis berikutnya berdasarkan last service date
     *
     * @param string $merek Brand/merk kendaraan
     * @param \Carbon\Carbon|string $lastServiceDate Tanggal servis terakhir
     * @return array ['date' => Carbon, 'text' => 'X hari/bulan/tahun lagi', 'days' => int]
     */
    public static function calculateNextService($merek, $lastServiceDate)
    {
        // Convert ke Carbon jika string
        if (is_string($lastServiceDate)) {
            $lastServiceDate = Carbon::parse($lastServiceDate);
        }

        // Get interval berdasarkan merk (default 6 bulan)
        $interval = self::getServiceInterval($merek);

        // Hitung tanggal servis berikutnya
        $nextServiceDate = $lastServiceDate->copy()->addMonths($interval);

        // Hitung selisih hari
        $daysRemaining = (int) round(now()->diffInDays($nextServiceDate, false)); // false = bisa negative
        $monthsRemaining = (int) round(now()->diffInMonths($nextServiceDate, false));
        $yearsRemaining = (int) round(now()->diffInYears($nextServiceDate, false));

        // Tentukan format text berdasarkan selisih
        $text = self::formatScheduleText($daysRemaining, $monthsRemaining, $yearsRemaining);

        return [
            'date' => $nextServiceDate,
            'text' => $text,
            'days_remaining' => max(0, $daysRemaining),
            'is_overdue' => $daysRemaining < 0,
            'status' => self::getStatus($daysRemaining)
        ];
    }

    /**
     * Get service interval untuk merk tertentu
     */
    public static function getServiceInterval($merek)
    {
        $merek = strtolower(trim($merek));
        return self::$serviceIntervals[$merek] ?? 6; // default 6 bulan
    }

    /**
     * Format text jadwal servis
     */
    private static function formatScheduleText($daysRemaining, $monthsRemaining, $yearsRemaining)
    {
        // Jika sudah overdue
        if ($daysRemaining < 0) {
            $absDays = abs($daysRemaining);
            if ($absDays == 0) {
                return 'Hari ini!';
            } elseif ($absDays <= 30) {
                return $absDays . ' hari yang lalu';
            } elseif ($monthsRemaining <= 0) {
                $absMonths = abs($monthsRemaining);
                return $absMonths . ' bulan yang lalu';
            } else {
                $absYears = abs($yearsRemaining);
                return $absYears . ' tahun yang lalu';
            }
        }

        // Jika masih dalam hitungan hari (0-30 hari)
        if ($daysRemaining <= 30) {
            if ($daysRemaining == 0) {
                return 'Hari ini!';
            } elseif ($daysRemaining == 1) {
                return 'Besok';
            } else {
                return $daysRemaining . ' hari lagi';
            }
        }

        // Jika masih dalam hitungan bulan (30 hari - 12 bulan)
        if ($monthsRemaining >= 1 && $monthsRemaining < 12) {
            if ($monthsRemaining == 1) {
                return 'Bulan depan';
            } else {
                return $monthsRemaining . ' bulan lagi';
            }
        }

        // Jika lebih dari 1 tahun
        if ($yearsRemaining >= 1) {
            if ($yearsRemaining == 1) {
                return 'Tahun depan';
            } else {
                return $yearsRemaining . ' tahun lagi';
            }
        }

        return 'Segera';
    }

    /**
     * Get status badge
     */
    public static function getStatus($daysRemaining)
    {
        if ($daysRemaining < 0) {
            return 'overdue'; // Merah - sudah lewat
        } elseif ($daysRemaining <= 7) {
            return 'urgent'; // Merah - segera
        } elseif ($daysRemaining <= 30) {
            return 'warning'; // Kuning - peringatan
        } else {
            return 'normal'; // Hijau - normal
        }
    }

    /**
     * Get status badge color untuk Tailwind
     */
    public static function getStatusColor($status)
    {
        $colors = [
            'overdue' => 'bg-red-100 text-red-800',
            'urgent' => 'bg-red-100 text-red-800',
            'warning' => 'bg-yellow-100 text-yellow-800',
            'normal' => 'bg-green-100 text-green-800',
        ];

        return $colors[$status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get icon untuk status
     */
    public static function getStatusIcon($status)
    {
        $icons = [
            'overdue' => '⚠️',
            'urgent' => '🔴',
            'warning' => '🟡',
            'normal' => '✅',
        ];

        return $icons[$status] ?? '➖';
    }
}
