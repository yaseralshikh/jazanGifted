<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SchoolsExport
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
        $sheet->setCellValue('B1', 'Province');
        $sheet->setCellValue('C1', 'Educational stage');
        $sheet->setCellValue('D1', 'Educational type');
        $sheet->setCellValue('H1', 'Educational gender');
        $sheet->setCellValue('E1', 'Ministry code');
        $sheet->setCellValue('F1', 'school manager');
        $sheet->setCellValue('G1', 'Gifted teacher');
        $sheet->setCellValue('I1', 'status');
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

        foreach ($data as $school) {
            $sheet->setCellValue("A{$row}", $school->name);
            $sheet->setCellValue("B{$row}", $school->province->name);
            $sheet->setCellValue("C{$row}", $school->educational_stage);
            $sheet->setCellValue("D{$row}", $school->educational_type);
            $sheet->setCellValue("H{$row}", $school->educational_gender);
            $sheet->setCellValue("E{$row}", $school->ministry_code);
            $sheet->setCellValue("F{$row}", $school->school_manager_user_id);
            $teacher = $school->giftedTeachers()
                ->whereIn('teacher_type', ['dedicated', 'coordinator'])
                ->orderByRaw("FIELD(teacher_type, 'dedicated', 'coordinator')") // أولوية للمفرغ
                ->with('user')
                ->first();
            $sheet->setCellValue("G{$row}", $teacher->user->name ?? 'N/A');
            $sheet->setCellValue("G{$row}", $school->giftedTeachers->first()->name ?? 'N/A');
            $sheet->setCellValue("I{$row}", $school->status ? 'Active' : 'Inactive');
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
        $filename = 'schools_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = public_path($filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filename;
    }
}