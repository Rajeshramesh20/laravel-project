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


// class ExportStudentsExcelJob implements ShouldQueue
// {
//     use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

//     /**
//      * Create a new job instance.
//      */

//     protected $fileName;

//     public function __construct($fileName)
//     {
//         $this->fileName = $fileName;
//     }

//     public function handle(): void
//     {
//         // Save Excel file to storage/app/exports
//         Excel::store(new StudentExport, 'public/exports/' . $this->fileName);
//     }



// }

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
        } catch (\Exception $e) {
            $task->update([
                'status' => 'error',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
