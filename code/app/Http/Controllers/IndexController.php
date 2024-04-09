<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        // Testar conexão com o banco de dados
        try {
            DB::connection()->getPdo();
            $testDB = true;
        } catch (\Exception $e) {
            $testDB = false;
        }

        // Obtém o horário da última importação de produtos
        $lastImport = ImportHistory::latest()->first();
        $lastCronExecution = Carbon::parse($lastImport->created_at)->format('d/m/Y H:i:s');

        // Obtém o tempo de execução da máquina
        $uptime = exec('uptime');

        // Obtém a memória em uso
        $memoryUsage = formatMemory(memory_get_usage());

        return view('welcome', compact('testDB', 'lastCronExecution', 'uptime', 'memoryUsage'));
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
}
