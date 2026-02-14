<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Entrance Examination Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #1a1a1a;
        }
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 18px;
            color: #666;
            font-weight: normal;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 5px 0;
            font-weight: bold;
            font-size: 12px;
        }
        .info-value {
            display: table-cell;
            padding: 5px 0;
            font-size: 12px;
        }
        .result-box {
            background-color: #f5f5f5;
            border: 2px solid #333;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .result-score {
            font-size: 36px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 10px 0;
        }
        .result-description {
            font-size: 18px;
            color: #666;
            margin: 5px 0;
        }
        .result-percentile {
            font-size: 14px;
            color: #999;
        }
        .notes-box {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            font-size: 12px;
            line-height: 1.6;
        }
        .signatures {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        .signature-block {
            display: table-cell;
            width: 50%;
            padding: 20px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 11px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 12px;
        }
        .signature-date {
            font-size: 10px;
            color: #666;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SISC Basic Education</h1>
        <h2>Entrance Examination Result</h2>
    </div>

    <!-- Student Information -->
    <div class="section">
        <div class="section-title">STUDENT INFORMATION</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $result->student->first_name }} {{ $result->student->last_name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value">{{ $result->student->date_of_birth->format('F d, Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Age at Examination:</div>
                <div class="info-value">{{ number_format($result->age_at_exam, 2) }} years</div>
            </div>
            <div class="info-row">
                <div class="info-label">Grade Level Applied:</div>
                <div class="info-value">{{ $result->grade_level_at_exam ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Application Number:</div>
                <div class="info-value">{{ $result->student->application_number ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Exam Information -->
    <div class="section">
        <div class="section-title">EXAMINATION DETAILS</div>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Examination:</div>
                <div class="info-value">{{ $result->exam->title }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Date Taken:</div>
                <div class="info-value">{{ $result->created_at->format('F d, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Results -->
    <div class="section">
        <div class="section-title">EXAMINATION RESULTS</div>
        <div class="result-box">
            <div class="result-score">{{ $result->raw_score }}</div>
            <div class="result-description">{{ $result->performance_description ?? 'Not Available' }}</div>
            @if($result->percentile)
                <div class="result-percentile">{{ $result->percentile }}th Percentile</div>
            @endif
        </div>
    </div>

    <!-- Psychometrician Assessment -->
    @if($result->psychometrician_notes)
    <div class="section">
        <div class="section-title">PSYCHOMETRICIAN ASSESSMENT</div>
        <div class="notes-box">
            {{ $result->psychometrician_notes }}
        </div>
    </div>
    @endif

    <!-- Counselor Assessment -->
    @if($result->counselor_notes)
    <div class="section">
        <div class="section-title">COUNSELOR ASSESSMENT</div>
        <div class="notes-box">
            {{ $result->counselor_notes }}
        </div>
    </div>
    @endif

    <!-- Recommendation -->
    @if($result->recommendation)
    <div class="section">
        <div class="section-title">RECOMMENDATION</div>
        <div class="notes-box" style="font-weight: bold; font-size: 14px; text-align: center;">
            {{ strtoupper($result->recommendation) }}
        </div>
    </div>
    @endif

    <!-- Signatures -->
    <div class="signatures">
        @php
            $psychSig = $result->signatures->where('role', 'psychometrician')->first();
            $counselorSig = $result->signatures->where('role', 'counselor')->first();
        @endphp

        <div class="signature-block">
            <div class="signature-line">
                @if($psychSig)
                    <div class="signature-name">{{ $psychSig->user->name }}</div>
                    <div>Psychometrician</div>
                    <div class="signature-date">Signed: {{ $psychSig->signed_at->format('F d, Y h:i A') }}</div>
                @else
                    <div style="color: #999;">Pending Signature</div>
                    <div>Psychometrician</div>
                @endif
            </div>
        </div>

        <div class="signature-block">
            <div class="signature-line">
                @if($counselorSig)
                    <div class="signature-name">{{ $counselorSig->user->name }}</div>
                    <div>Guidance Counselor</div>
                    <div class="signature-date">Signed: {{ $counselorSig->signed_at->format('F d, Y h:i A') }}</div>
                @else
                    <div style="color: #999;">Pending Signature</div>
                    <div>Guidance Counselor</div>
                @endif
            </div>
        </div>
    </div>

    <div class="footer">
        This is an official document from SISC Basic Education Entrance Examination System.<br>
        Generated on {{ now()->format('F d, Y h:i A') }}
    </div>
</body>
</html>
