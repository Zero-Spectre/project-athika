<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $modul->judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .course-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }
        .content {
            font-size: 14px;
        }
        .content img {
            max-width: 100%;
            height: auto;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $modul->judul }}</div>
        <div class="course-info">
            Course: {{ $modul->kursus->judul }} | 
            Module Type: {{ ucfirst(str_replace('_', ' ', $modul->tipe_materi)) }}
        </div>
    </div>
    
    <div class="content">
        {!! $modul->konten_teks !!}
    </div>
    
    <div class="footer">
        Generated on {{ date('F j, Y') }} | Exported from Sawit Learning Platform
    </div>
</body>
</html>