<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProvincesExport
{
    public function export($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // رؤوس الأعمدة
        $sheet->getStyle('A1:C1')->getFill()->setFillType('solid')->getStartColor()->setRGB('FFFF00');
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:C1')->getAlignment()->setVertical('center');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(12);
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Region');
        $sheet->setCellValue('C1', 'Status');
        // حجم الأعمدة
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row = 2;
        // إضافة البيانات
        if (empty($data)) {
            $sheet->setCellValue('A2', 'No data available');
            return $spreadsheet; // Return the spreadsheet with no data
        }

        foreach ($data as $province) {
            $sheet->setCellValue("A{$row}", $province->name);
            $sheet->setCellValue("B{$row}", $province->educationRegion->name);
            $sheet->setCellValue("C{$row}", $province->status ? 'Active' : 'Inactive');
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
        $filename = 'provinces_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = public_path($filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filename;
    }
}