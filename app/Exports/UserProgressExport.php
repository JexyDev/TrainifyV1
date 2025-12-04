<?php

namespace App\Exports;

use App\Models\UserWorkoutProgress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserProgressExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return UserWorkoutProgress::with('workout.category')
                                 ->where('user_id', $this->userId)
                                 ->orderBy('completed_at', 'desc')
                                 ->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Workout',
            'Kategori',
            'Durasi (menit)',
            'Kalori Terbakar',
            'Catatan',
        ];
    }

    /**
     * @param mixed $progress
     * @return array
     */
    public function map($progress): array
    {
        return [
            $progress->completed_at->format('d/m/Y H:i'),
            $progress->workout->title,
            $progress->workout->category->name,
            $progress->workout->duration,
            $progress->calories_burned ?? '-',
            $progress->notes ?? '-',
        ];
    }
}
