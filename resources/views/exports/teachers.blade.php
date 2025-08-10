<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <style>
            body {
                font-family: 'XBRiyaz', sans-serif;
                direction: rtl;
                margin: 40px;
            }

            .header-table {
                width: 100%;
                border: none;
                margin-bottom: 5px;
            }

            .header-table td {
                border: none;
                vertical-align: top;
                font-size: 11px;
                font-weight: bold;
            }

            .header-right {
                text-align: center;
                line-height: 1.5;
            }

            .header-center {
                text-align: center;
            }

            .header-left {
                text-align: center;
            }

            h2 {
                text-align: center;
                margin-top: 5px;
            }

            .table-content {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
                font-size: 14px;
            }

            .table-content th, .table-content td {
                border: 1px solid #000;
                padding: 8px;
                text-align: center;
            }

            .table-content th {
                background-color: #eee;
            }

            thead { display: table-header-group; }
            tfoot { display: table-row-group; }
            thead tr { page-break-inside: avoid; page-break-after: auto; }

            @page {
                footer: html_myFooter;
            }

            .footer {
                font-size: 12px;
                text-align: center;
                color: #444;
            }
        </style>
    </head>
    <body>

        {{-- الترويسة --}}
        <table class="header-table">
            <tr>
                <!-- يمين: معلومات الوزارة -->
                <td class="header-right" style="width: 33%;">
                    المملكة العربية السعودية<br>
                    وزارة التعليم<br>
                    {{ Auth::user()->educationRegion->Name }}<br>
                    الشؤون التعليمية – إدارة تنمية القدرات<br>
                    قسم الموهوبين
                </td>

                <!-- وسط: الشعار -->
                <td class="header-center" style="width: 34%;">
                    <img src="{{ public_path('images/moe-logo.png') }}" width="150" alt="شعار وزارة التعليم">
                </td>

                <!-- يسار: التاريخ -->
                <td class="header-left" style="width: 33%;">
                    التاريخ: {{ \Carbon\Carbon::now()->format('Y/m/d') }}
                </td>
            </tr>
        </table>

        <hr>

        <h2>كشف المستخدمين</h2>

        {{-- جدول المحتوى --}}
        <table class="table-content">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>School</th>
                    <th>Specialization</th>
                    <th>Academic Qualification</th>
                    <th>Experience Years</th>
                    <th>Assigned at</th>
                    <th>Notes</th>
                    <th>Provinces</th>
                    <th>Reagion</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data as $teacher)
                    <tr>
                        {{-- Displaying the teacher's details --}}
                        <td>{{ $i++ }}</td>
                        <td>{{ $teacher->user->name }}</td>
                        <td>{{ $teacher->school->name }}</td>       
                        <td>{{ $teacher->specialization->name }}</td>
                        <td>{{ $teacher->academic_qualification }}</td>
                        <td>{{ $teacher->experience_years }}</td>
                        <td>{{ optional($teacher->assigned_at)->format('Y-m-d') }}</td>
                        <td>{{ $teacher->notes ?? 'N/A' }}</td>
                        <td>{{ $teacher->user->provinces->pluck('name')->join(', ') }}</td>
                        <td>{{ $teacher->user->educationRegion->name }}</td>
                        <td>
                            @if($teacher->status)
                                <span class="text-green-600">Active</span>
                            @else
                                <span class="text-gray-600">Disactive</span>      
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <htmlpagefooter name="myFooter">
            <div class="footer">
                الصفحة {PAGENO} من {nbpg}
            </div>
        </htmlpagefooter>
    </body>
</html>