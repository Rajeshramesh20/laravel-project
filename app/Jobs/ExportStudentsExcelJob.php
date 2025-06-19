<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ExportInfo;
use Exception;



class ExportStudentsExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function handle(): void
    {
        // sleep(10);
        $task = ExportInfo::find($this->taskId);

        try {
            
            Excel::store(new StudentExport, 'public/exports/' . $task->file_name);

            $task->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        } catch (Exception $e) {
            $task->update([
                'status' => 'error',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
