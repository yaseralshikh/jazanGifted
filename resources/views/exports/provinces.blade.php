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
                    الإدارة العامة للتعليم بمنطقة جازان<br>
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

        <h2>كشف المحافظات</h2>

        {{-- جدول المحتوى --}}
        <table class="table-content">
            <thead>
                <tr>
                    <th>الرقم</th>
                    <th>المحافظة</th>
                    <th>المنطقة التعليمية</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($data as $province)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $province->name }}</td>
                        <td>{{ $province->educationRegion->name }}</td>
                        <td>
                            @if($province->status)
                                <span class="text-green-600">نشط</span>
                            @else
                                <span class="text-gray-600">غير نشط</span>      
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