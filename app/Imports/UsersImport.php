<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Database\QueryException;

class UsersImport implements ToModel, WithBatchInserts, WithChunkReading
{
    private $skippedRows = 0;

    public function batchSize(): int
    {
        return 1000; // Set your desired batch size
    }

    public function chunkSize(): int
    {
        return 1000; // Set your desired chunk size
    }

    public function model(array $row)
    {
        try {
            return new User([
                'name' => $row[0] . ' ' . $row[2],
                'email' => $row[2],
                'phone' => $row[3],
                'user_type' => 'user',
                'admin_id' => auth()->user()->id,
                'password' => Hash::make('User@999'), // Generate a random password
            ]);
        } catch (QueryException $e) {
            $message = $e->getMessage();
            if (Str::contains($message, 'Duplicate entry')) {
                preg_match('/Duplicate entry \'(.*?)\' for/', $message, $matches);
                $duplicateValue = $matches[1];
                return "Duplicate entry found for: $duplicateValue";
            } else {
                Log::error('Error importing user: ' . $e->getMessage());
                $this->skippedRows++;
                return null; // Skip this row
            }
        }
    }

    public function getSkippedRowsCount()
    {
        return $this->skippedRows;
    }
}
