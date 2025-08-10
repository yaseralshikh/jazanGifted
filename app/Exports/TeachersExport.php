<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TeachersExport
{
    public function export($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // رؤوس الأعمدة
        $sheet->getStyle('A1:J1')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFFF00');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'School');
        $sheet->setCellValue('C1', 'Specialization');
        $sheet->setCellValue('D1', 'Academic Qualification');
        $sheet->setCellValue('E1', 'Experience Years');
        $sheet->setCellValue('F1', 'Assigned at');
        $sheet->setCellValue('G1', 'Notes');
        $sheet->setCellValue('H1', 'Provinces');
        $sheet->setCellValue('I1', 'Reagion');
        $sheet->setCellValue('J1', 'Status');
        // حجم الأعمدة
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row = 2;
        // إضافة البيانات
        if (empty($data)) {
            $sheet->setCellValue('A2', 'No data available');
            return $spreadsheet; // Return the spreadsheet with no data
        }

        foreach ($data as $teacher) {
            $sheet->setCellValue("A{$row}", $teacher->user->name);
            $sheet->setCellValue("B{$row}", $teacher->school->name);
            $sheet->setCellValue("C{$row}", $teacher->specialization->name);
            $sheet->setCellValue("D{$row}", $teacher->academic_qualification);
            $sheet->setCellValue("E{$row}", $teacher->experience_years);
            $sheet->setCellValue("F{$row}", $teacher->assigned_at ? $teacher->assigned_at->format('Y-m-d') : 'N/A');
            $sheet->setCellValue("G{$row}", $teacher->notes ?? 'N/A');
            $sheet->setCellValue("H{$row}", $teacher->user->educationRegion->name);
            $sheet->setCellValue("I{$row}", $teacher->user->provinces->pluck('name')->join(', '));
            $sheet->setCellValue("J{$row}", $teacher->status ? 'Active' : 'Inactive');
            $row++;
        }

        // ضبط عرض الأعمدة تلقائيًا
        $highestColumn = $sheet->getHighestColumn(); // مثل C
        $lastRow = $sheet->getHighestRow(); // آخر صف تم ملؤه

        // المحاذاة في وسط الخلايا كلها
        $sheet->getStyle("A1:{$highestColumn}{$lastRow}")
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        // حفظ الملف
        $filename = 'teachers_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = public_path($filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filename;
    }
}