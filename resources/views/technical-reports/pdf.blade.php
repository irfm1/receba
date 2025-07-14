<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudo Técnico - {{ $report->report_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 24px;
            color: #4F46E5;
            margin: 0;
        }
        .header h2 {
            font-size: 18px;
            color: #666;
            margin: 5px 0;
        }
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .report-info div {
            flex: 1;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #E5E7EB;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-box {
            border: 1px solid #E5E7EB;
            padding: 15px;
            border-radius: 5px;
            background-color: #F9FAFB;
        }
        .info-box h3 {
            margin-top: 0;
            color: #374151;
            font-size: 14px;
        }
        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .equipment-table th,
        .equipment-table td {
            border: 1px solid #E5E7EB;
            padding: 8px;
            text-align: left;
        }
        .equipment-table th {
            background-color: #F3F4F6;
            font-weight: bold;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .status-approved { background-color: #10B981; }
        .status-completed { background-color: #3B82F6; }
        .status-draft { background-color: #6B7280; }
        .status-rejected { background-color: #EF4444; }
        .type-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .type-diagnostico { background-color: #3B82F6; }
        .type-instalacao { background-color: #10B981; }
        .type-manutencao { background-color: #F59E0B; }
        .type-seguranca { background-color: #EF4444; }
        .type-performance { background-color: #8B5CF6; }
        .type-infraestrutura { background-color: #6B7280; }
        .type-outros { background-color: #84CC16; }
        .findings-section {
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 15px;
            margin-bottom: 15px;
        }
        .recommendations-section {
            background-color: #DBEAFE;
            border-left: 4px solid #3B82F6;
            padding: 15px;
            margin-bottom: 15px;
        }
        .observations-section {
            background-color: #F3F4F6;
            border-left: 4px solid #6B7280;
            padding: 15px;
            margin-bottom: 15px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
            font-size: 10px;
            color: #6B7280;
        }
        .signature-section {
            margin-top: 40px;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 300px;
            margin: 0 auto;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAUDO TÉCNICO</h1>
        <h2>{{ $report->report_number }}</h2>
    </div>

    <!-- Report Information Grid -->
    <div class="info-grid">
        <div class="info-box">
            <h3>Informações do Cliente</h3>
            <strong>{{ $report->customer->name }}</strong><br>
            @if($report->customer->email)
                Email: {{ $report->customer->email }}<br>
            @endif
            @if($report->customer->phone)
                Telefone: {{ $report->customer->phone }}<br>
            @endif
            @if($report->customer->document_number)
                {{ $report->customer->document_type === 'cpf' ? 'CPF' : 'CNPJ' }}: {{ $report->customer->document_number }}<br>
            @endif
            @if($report->customer->address)
                {{ $report->customer->address }}
            @endif
        </div>
        
        <div class="info-box">
            <h3>Dados do Laudo</h3>
            <strong>Número:</strong> {{ $report->report_number }}<br>
            <strong>Data de Inspeção:</strong> {{ $report->inspection_date->format('d/m/Y') }}<br>
            <strong>Data do Laudo:</strong> {{ $report->report_date->format('d/m/Y') }}<br>
            <strong>Tipo:</strong> <span class="type-badge type-{{ $report->report_type }}">{{ $report->report_type_name }}</span><br>
            <strong>Status:</strong> <span class="status-badge status-{{ $report->status }}">{{ $report->status_name }}</span><br>
            @if($report->service_order_number)
                <strong>OS:</strong> {{ $report->service_order_number }}<br>
            @endif
            @if($report->invoice)
                <strong>Fatura:</strong> {{ $report->invoice->invoice_number }}<br>
            @endif
            @if($report->valid_until)
                <strong>Válido até:</strong> {{ $report->valid_until->format('d/m/Y') }}<br>
            @endif
        </div>
    </div>

    <!-- Technical Information -->
    <div class="info-grid">
        <div class="info-box">
            <h3>Responsável Técnico</h3>
            <strong>{{ $report->technician_name }}</strong><br>
            @if($report->technician_registration)
                <strong>Registro:</strong> {{ $report->technician_registration }}<br>
            @endif
        </div>
        
        @if($report->approved_by)
        <div class="info-box">
            <h3>Aprovação</h3>
            <strong>Aprovado por:</strong> {{ $report->approved_by }}<br>
            <strong>Data:</strong> {{ $report->approved_at->format('d/m/Y H:i') }}<br>
            @if($report->approval_notes)
                <strong>Observações:</strong> {{ $report->approval_notes }}<br>
            @endif
        </div>
        @endif
    </div>

    <!-- Title and Description -->
    <div class="section">
        <div class="section-title">Título do Laudo</div>
        <h2 style="margin: 0; color: #374151;">{{ $report->title }}</h2>
    </div>

    <div class="section">
        <div class="section-title">Descrição</div>
        <p>{{ $report->description }}</p>
    </div>

    <!-- Equipment Analyzed -->
    @if($report->equipment_analyzed && count($report->equipment_analyzed) > 0)
        <div class="section">
            <div class="section-title">Equipamentos/Sistemas Analisados</div>
            <table class="equipment-table">
                <thead>
                    <tr>
                        <th>Nome/Descrição</th>
                        <th>Modelo</th>
                        <th>Número de Série</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($report->equipment_analyzed as $equipment)
                        <tr>
                            <td>{{ $equipment['name'] ?? '-' }}</td>
                            <td>{{ $equipment['model'] ?? '-' }}</td>
                            <td>{{ $equipment['serial'] ?? '-' }}</td>
                            <td>{{ $equipment['status'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Findings -->
    <div class="section">
        <div class="section-title">Constatações</div>
        <div class="findings-section">
            {!! nl2br(e($report->findings)) !!}
        </div>
    </div>

    <!-- Recommendations -->
    <div class="section">
        <div class="section-title">Recomendações</div>
        <div class="recommendations-section">
            {!! nl2br(e($report->recommendations)) !!}
        </div>
    </div>

    <!-- Observations -->
    @if($report->observations)
        <div class="section">
            <div class="section-title">Observações Adicionais</div>
            <div class="observations-section">
                {!! nl2br(e($report->observations)) !!}
            </div>
        </div>
    @endif

    <!-- Attachments -->
    @if($report->attachments && count($report->attachments) > 0)
        <div class="section">
            <div class="section-title">Anexos</div>
            <ul>
                @foreach($report->attachments as $attachment)
                    <li>{{ $attachment['filename'] ?? 'Arquivo' }} ({{ $attachment['type'] ?? 'Tipo desconhecido' }})</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Signature -->
    <div class="signature-section">
        <div class="signature-line">
            <strong>{{ $report->technician_name }}</strong><br>
            Responsável Técnico
            @if($report->technician_registration)
                <br>{{ $report->technician_registration }}
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>
            Laudo gerado em {{ now()->format('d/m/Y H:i') }} por {{ config('app.name') }}<br>
            Este documento é válido apenas com assinatura digital ou física do responsável técnico.
        </p>
    </div>
</body>
</html>
