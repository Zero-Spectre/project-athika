<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate - {{ $kursus->judul ?? 'Sawit Learning' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
        }
        
        .certificate-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 800px;
            width: 100%;
            text-align: center;
            position: relative;
            border: 15px solid #f8f9fa;
        }
        
        .certificate-header {
            margin-bottom: 30px;
        }
        
        .certificate-title {
            color: #4CAF50;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .certificate-subtitle {
            color: #6c757d;
            font-size: 1.2rem;
        }
        
        .certificate-icon {
            font-size: 5rem;
            color: #4CAF50;
            margin: 30px 0;
        }
        
        .recipient-name {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            margin: 20px 0;
            padding: 15px;
            border-top: 2px solid #eee;
            border-bottom: 2px solid #eee;
        }
        
        .course-title {
            font-size: 1.5rem;
            color: #495057;
            margin: 20px 0;
        }
        
        .completion-date {
            color: #6c757d;
            font-size: 1.1rem;
            margin: 15px 0;
        }
        
        .signature-section {
            margin: 40px 0 20px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        
        .signature {
            text-align: center;
            margin: 0 20px;
        }
        
        .signature-line {
            width: 200px;
            height: 1px;
            background: #ddd;
            margin: 0 auto 15px;
        }
        
        .certificate-id {
            position: absolute;
            bottom: 20px;
            right: 20px;
            color: #adb5bd;
            font-size: 0.9rem;
        }
        
        .print-btn {
            background: linear-gradient(135deg, #8BC34A 0%, #4CAF50 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .print-btn:hover {
            background: linear-gradient(135deg, #4CAF50 0%, #8BC34A 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .print-btn {
                display: none;
            }
            
            .certificate-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-header">
            <h1 class="certificate-title">Certificate of Completion</h1>
            <p class="certificate-subtitle">This certifies that</p>
        </div>
        
        <div class="certificate-icon">
            <i class="fas fa-certificate"></i>
        </div>
        
        <h2 class="recipient-name">{{ Auth::user()->name ?? 'Student Name' }}</h2>
        
        <p class="course-title">has successfully completed the course</p>
        
        <h3 class="course-title">{{ $kursus->judul ?? 'Course Title' }}</h3>
        
        <p class="completion-date">Completed on {{ $completionDate ? $completionDate->format('F j, Y') : now()->format('F j, Y') }}</p>
        
        <div class="signature-section">
            <div class="signature">
                <div class="signature-line"></div>
                <p>{{ $kursus->instruktur->name ?? 'Course Instructor' }}</p>
            </div>
            <div class="signature">
                <div class="signature-line"></div>
                <p>Academic Director</p>
            </div>
        </div>
        
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print me-2"></i>Print Certificate
        </button>
        
        <div class="certificate-id">
            Certificate ID: SWT-{{ now()->format('Y') }}-{{ strtoupper(substr(md5($kursus->id . Auth::id()), 0, 8)) }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>