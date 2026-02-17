<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Psychological Test Profile Sheet</title>
    <style>
        @page {
            size: letter;
            margin: 0.5in;
        }
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 10pt;
            line-height: 1.2;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            height: 50px;
            vertical-align: middle;
            margin-right: 15px;
        }
        .header-text {
            display: inline-block;
            vertical-align: middle;
            text-align: center;
        }
        .school-name {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .document-title {
            font-size: 11pt;
            font-weight: bold;
            font-style: italic;
            margin-top: 2px;
        }
        .doc-code {
            font-size: 8pt;
            margin-bottom: 5px;
            text-align: right;
        }
        .section-header {
            font-weight: bold;
            font-style: italic;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
            margin-top: 10px;
            text-transform: uppercase;
            font-size: 10pt;
        }
        .info-box {
            border: 1px solid black;
            padding: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        .info-table td {
            padding: 2px 5px;
            vertical-align: bottom;
        }
        .result-table {
            width: 100%;
            border: 1px solid black;
            margin-bottom: 10px;
        }
        .result-table th {
            border: 1px solid black;
            background-color: #f0f0f0;
            padding: 3px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }
        .result-table td {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
            font-size: 9pt;
        }
        .recommendation-section {
            margin-top: 10px;
            font-size: 10pt;
        }
        .checkbox-list {
            margin-left: 20px;
            margin-top: 5px;
        }
        .checkbox-item {
            margin-bottom: 3px;
        }
        .signatures {
            margin-top: 30px;
            width: 100%;
        }
        .signature-block {
            text-align: center;
            float: left;
            width: 45%;
        }
        .signature-line {
            border-top: 1px solid black;
            margin-top: 30px;
            padding-top: 2px;
        }
        .signee-name {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
        }
        .signee-title {
            font-style: italic;
            font-size: 9pt;
        }
        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        @if(!empty($systemLogo) && file_exists(public_path($systemLogo)))
            <img src="{{ public_path($systemLogo) }}" alt="Logo">
        @elseif(file_exists(public_path('storage/logo.png')))
             <img src="{{ public_path('storage/logo.png') }}" alt="Logo">
        @endif
        <div class="header-text">
            <div class="school-name">Southville International School and Colleges</div>
            <div class="document-title">PSYCHOLOGICAL TEST PROFILE SHEET</div>
        </div>
    </div>

    <div class="doc-code">SISC/QSF-GUI-006 Rev. 000 01/21/04</div>

    <div class="section-header">I. BACKGROUND INFORMATION</div>
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td width="15%"><strong>Name:</strong></td>
                <td width="50%" style="border-bottom: 1px solid black;">{{ $result->student->full_name }}</td>
                <td width="10%" align="right"><strong>Age:</strong></td>
                <td width="25%" style="border-bottom: 1px solid black;">{{ number_format($result->age_at_exam, 1) }}</td>
            </tr>
            <tr>
                <td><strong>Birthdate:</strong></td>
                <td style="border-bottom: 1px solid black;">{{ $result->student->date_of_birth->format('F d, Y') }}</td>
                <td align="right"><strong>Date Assessed:</strong></td>
                <td style="border-bottom: 1px solid black;">{{ $result->created_at->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Level Applied:</strong></td>
                <td style="border-bottom: 1px solid black;">{{ $result->grade_level_at_exam ?? 'N/A' }}</td>
                <td align="right"><strong>SY:</strong></td>
                <td style="border-bottom: 1px solid black;">AY {{ now()->format('Y') }}-{{ now()->addYear()->format('Y') }}</td>
            </tr>
            <tr>
                <td><strong>School Last Attended:</strong></td>
                <td style="border-bottom: 1px solid black;" colspan="3">{{ $result->student->school_last_attended ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-header">II. ASSESSMENT RESULTS</div>

    @php
        $scores = $result->getSectionScores();
        
        $intelligenceProfile = $scores->where('type', 'intelligence');
        $achievementProfile = $scores->where('type', 'achievement');

        if ($intelligenceProfile->isEmpty() && $achievementProfile->isEmpty() && $scores->isNotEmpty()) {
             $intelligenceProfile = $scores;
        }
        
        $showFallback = $scores->isEmpty();
    @endphp

    <!-- Intelligence Profile Table -->
    <table class="result-table">
        <thead>
            <tr>
                <th colspan="5" style="background-color: #e0e0e0; text-transform: uppercase;">INTELLIGENCE PROFILE</th>
            </tr>
            <tr>
                <th width="35%" style="text-align: left; padding-left: 10px;">AREA</th>
                <th width="15%">RAW SCORE</th>
                <th width="15%">SAI</th>
                <th width="15%">% Tile</th>
                <th width="20%">DESCRIPTION</th>
            </tr>
        </thead>
        <tbody>
            @php
                // Helper to find score by flexible title matching
                $findScore = function($scores, $keywords) {
                    foreach($scores as $score) {
                        foreach($keywords as $keyword) {
                            if (stripos($score['title'], $keyword) !== false) {
                                return $score;
                            }
                        }
                    }
                    return null;
                };

                // Helper for qualitative descriptions
                $getDesc = function($sai) {
                    if (!$sai || $sai == '-') return '-';
                    $val = (int)$sai;
                    if ($val >= 128) return 'Very Superior';
                    if ($val >= 120) return 'Superior';
                    if ($val >= 111) return 'Above Average';
                    if ($val >= 90)  return 'Average';
                    if ($val >= 80)  return 'Below Average';
                    if ($val >= 70)  return 'Well Below Average';
                    return 'Low';
                };

                // Intelligence Rows
                $verbal = $findScore($intelligenceProfile, ['Verbal']);
                $nonVerbal = $findScore($intelligenceProfile, ['Non-Verbal', 'Non Verbal']);
            @endphp

            <tr>
                <td style="text-align: left; padding-left: 10px; font-weight: bold; font-style: italic;">VERBAL</td>
                <td>{{ $verbal['raw_score'] ?? '' }}</td>
                <td>-</td>
                <td>{{ isset($verbal) ? $verbal['percent_score'].'%' : '' }}</td>
                <td>-</td>
            </tr>
            <tr>
                <td style="text-align: left; padding-left: 10px; font-weight: bold; font-style: italic;">NON-VERBAL</td>
                <td>{{ $nonVerbal['raw_score'] ?? '' }}</td>
                <td>-</td>
                <td>{{ isset($nonVerbal) ? $nonVerbal['percent_score'].'%' : '' }}</td>
                <td>-</td>
            </tr>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td style="text-align: left; padding-left: 10px;">TOTAL (OLSAT)</td>
                <td>{{ $result->raw_score }}</td>
                <td>{{ $result->sai ?? '-' }}</td>
                <td>{{ $result->percentile ? $result->percentile.'%' : '-' }}</td>
                <td>{{ $getDesc($result->sai) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Achievement Profile Table -->
    <table class="result-table" style="margin-top: 15px;">
        <thead>
            <tr>
                <th colspan="7" style="background-color: #e0e0e0; text-transform: uppercase;">ACHIEVEMENT PROFILE</th>
            </tr>
            <tr>
                <th width="25%">Subjects</th>
                <th width="10%">RS</th>
                <th width="10%">SS</th>
                <th width="10%">GE</th>
                <th width="10%">PR</th>
                <th width="10%">STA</th>
                <th width="25%">Description</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subjects = ['Reading', 'Math', 'Language', 'Science'];
            @endphp

            @foreach($subjects as $subject)
                @php
                    $score = $findScore($achievementProfile, [$subject]);
                @endphp
                <tr>
                    <td style="text-align: left; font-weight: bold; font-style: italic; padding-left: 5px;">{{ $subject }}</td>
                    <td>{{ $score['raw_score'] ?? '' }}</td>
                    <td></td><td></td><td></td><td></td><td></td>
                </tr>
            @endforeach
            
            <!-- Basic Battery Row -->
             @php
                $basicBattery = $findScore($achievementProfile, ['Basic Battery', 'Battery']);
            @endphp
            <tr>
                <td style="text-align: left; font-weight: bold; font-style: italic; padding-left: 5px;">Basic Battery</td>
                <td>{{ $basicBattery['raw_score'] ?? '' }}</td>
                <td></td><td></td><td></td><td></td><td></td>
            </tr>
        </tbody>
    </table>

    <div class="section-header">III. RECOMMENDATIONS</div>
    <div class="recommendation-section">
        <div>
            Level Recommended: <span style="border-bottom: 1px solid black; display: inline-block; width: 200px; text-align: center; font-weight: bold;">{{ $result->recommendation ?? '____________________' }}</span>
        </div>
        <div class="checkbox-list" style="margin-top: 5px;">
            <div class="checkbox-item">[ &nbsp;&nbsp; ] Strongly Recommended</div>
            <div class="checkbox-item">[ &nbsp;&nbsp; ] Recommended</div>
            <div class="checkbox-item">[ &nbsp;&nbsp; ] Probation: Suggested Intervention <span style="border-bottom: 1px solid black; display: inline-block; width: 250px;"></span></div>
            <div class="checkbox-item">[ &nbsp;&nbsp; ] Not Recommended</div>
        </div>
    </div>

    <!-- Signatures -->
    @php
        $psychSig = $result->signatures->where('role', 'psychometrician')->first();
        $counselorSig = $result->signatures->where('role', 'counselor')->first();
    @endphp

    <div class="signatures">
        <!-- LEFT: Psychometrician (Roel) -->
        <div class="signature-block">
            <div style="position: relative; padding-top: 135px;"> <!-- Reserve space for signature -->
                @if($psychSig && $psychSig->user->signature_path && file_exists(public_path('storage/' . $psychSig->user->signature_path)))
                    {{-- Position absolute relative to this block, centered horizontally, sitting on the line --}}
                    <img src="{{ public_path('storage/' . $psychSig->user->signature_path) }}" 
                         style="height: 70px; position: absolute; bottom: 135px; left: 50%; transform: translateX(-50%); z-index: 10;">
                @endif
                
                <div class="signature-line" style="margin-top: 0; position: relative; z-index: 5;">
                     @if($psychSig)
                        <div class="signee-name">{{ $psychSig->user->name }}</div>
                     @else
                         <div class="signee-name">Roel (Psychometrician)</div>
                     @endif
                    <div class="signee-title">Guidance Associate</div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Counselor (IT Support) -->
        <div class="signature-block" style="float: right;">
            <div style="text-align: right; margin-bottom: 20px;">
                Date: <span style="border-bottom: 1px solid black; display: inline-block; width: 100px; text-align: center;">{{ $result->created_at->format('M d, Y') }}</span>
            </div>
            
             <div style="position: relative; padding-top: 135px;"> <!-- Reserve space for signature -->
                 @if($counselorSig && $counselorSig->user->signature_path && file_exists(public_path('storage/' . $counselorSig->user->signature_path)))
                    <img src="{{ public_path('storage/' . $counselorSig->user->signature_path) }}" 
                         style="height: 70px; position: absolute; bottom: 135px; left: 50%; transform: translateX(-50%); z-index: 10;">
                @endif

                <div class="signature-line" style="margin-top: 0; position: relative; z-index: 5;">
                    @if($counselorSig)
                        <div class="signee-name">{{ $counselorSig->user->name }}</div>
                     @else
                        <div class="signee-name">IT Support</div>
                     @endif
                    <div class="signee-title">Head, CAPS</div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>

