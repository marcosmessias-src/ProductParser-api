<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDetailsController extends Controller
{
    /**
     * Display API Details.
     */
    public function apiDetails(Request $request)
    {
        // Testar conexão com o banco de dados
        try {
            DB::connection()->getPdo();
            $testDB = true;
        } catch (\Exception $e) {
            $testDB = false;
        }

        // Obtém o horário da última importação de produtos
        $lastCronExecution = ImportHistory::latest()->first();

        // Obtém o tempo de execução da máquina
        $uptime = exec('uptime');

        // Obtém a memória em uso
        $memoryUsage = memory_get_usage();

        return response()->json([
            'test_db' => $testDB,
            'last_cron_execution' => Carbon::parse($lastCronExecution->created_at)->format('d/m/Y H:i:s'),
            'uptime' => $uptime,
            'memory_usage' => formatMemory($memoryUsage),
        ]);
    }
}

function formatMemory($bytes) {
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $unitIndex = 0;
    while ($bytes > 1024 && $unitIndex < count($units) - 1) {
        $bytes /= 1024;
        $unitIndex++;
    }

    return round($bytes, 2) . ' ' . $units[$unitIndex];
}
