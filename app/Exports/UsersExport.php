<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UsersExport
{
    public function export($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // رؤوس الأعمدة
        $sheet->getStyle('A1:I1')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFFF00');
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:I1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Phone');
        $sheet->setCellValue('D1', 'National_id');
        $sheet->setCellValue('E1', 'Region');
        $sheet->setCellValue('F1', 'Provinces');
        $sheet->setCellValue('G1', 'Gender');
        $sheet->setCellValue('H1', 'User Type');
        $sheet->setCellValue('I1', 'Status');
        // حجم الأعمدة
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row = 2;
        // إضافة البيانات
        if (empty($data)) {
            $sheet->setCellValue('A2', 'No data available');
            return $spreadsheet; // Return the spreadsheet with no data
        }

        foreach ($data as $user) {
            $sheet->setCellValue("A{$row}", $user->name);
            $sheet->setCellValue("B{$row}", $user->email);
            $sheet->setCellValue("C{$row}", $user->phone);
            $sheet->setCellValue("D{$row}", $user->national_id);
            $sheet->setCellValue("E{$row}", $user->educationRegion->name);
            $sheet->setCellValue("F{$row}", $user->provinces->pluck('name')->join(', '));
            $sheet->setCellValue("G{$row}", $user->gender);
            $sheet->setCellValue("H{$row}", $user->user_type);
            $sheet->setCellValue("I{$row}", $user->status ? 'Active' : 'Inactive');
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
        $filename = 'users_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = public_path($filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filename;
    }
}