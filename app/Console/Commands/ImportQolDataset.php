<?php

namespace App\Console\Commands;

use App\Models\QolRecord;
use Illuminate\Console\Command;
use SplFileObject;

class ImportQolDataset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-qol-dataset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import QOL dataset from CSV file into qol_records table';

    private const BATCH_SIZE = 500;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $filePath = resource_path('qol-dataset.csv');

        if (!file_exists($filePath)) {
            $this->error("CSV file not found at: $filePath");
            return self::FAILURE;
        }

        $file = new SplFileObject($filePath, 'r');
        $file->setFlags(SplFileObject::READ_CSV);

        $batch = [];
        $totalRows = 0;

        // Count total rows for progress bar (excluding header)
        $rowCount = 0;
        $lineNumber = 0;
        foreach ($file as $row) {
            $lineNumber++;
            if ($lineNumber === 1 || $row[0] === null) {
                continue; // Skip header row
            }
            $rowCount++;
        }

        // Reset file pointer
        $file->rewind();

        $progressBar = $this->output->createProgressBar($rowCount);
        $progressBar->start();

        $lineNumber = 0;
        foreach ($file as $row) {
            $lineNumber++;
            if ($lineNumber === 1 || $row[0] === 'id' || $row[0] === null) {
                continue; // Skip header row
            }

            $batch[] = $this->transformRow($row);
            $totalRows++;

            if (count($batch) >= self::BATCH_SIZE) {
                QolRecord::insertOrIgnore($batch);
                $progressBar->advance(count($batch));
                $batch = [];
            }
        }

        // Insert remaining records
        if (!empty($batch)) {
            QolRecord::insertOrIgnore($batch);
            $progressBar->advance(count($batch));
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Successfully imported $totalRows records from QOL dataset.");

        return self::SUCCESS;
    }

    /**
     * Transform a CSV row into database-ready format.
     *
     * @param array<string> $row
     * @return array<string, mixed>
     */
    private function transformRow(array $row): array
    {
        return [
            'id' => (int) $row[0],
            'gender' => $row[1],
            'occupation_type' => $row[2],
            'avg_work_hours_per_day' => (float) $row[3],
            'avg_rest_hours_per_day' => (float) $row[4],
            'avg_sleep_hours_per_day' => (float) $row[5],
            'avg_exercise_hours_per_day' => (float) $row[6],
            'age_at_death' => (int) $row[7],
        ];
    }
}
