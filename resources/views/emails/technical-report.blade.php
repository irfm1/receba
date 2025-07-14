<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laudo Técnico #{{ $report->report_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            margin: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .report-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #6c757d;
        }
        .detail-value {
            color: #495057;
            font-weight: 500;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
        }
        .status-approved { background-color: #28a745; }
        .status-completed { background-color: #007bff; }
        .status-draft { background-color: #6c757d; }
        .status-rejected { background-color: #dc3545; }
        .type-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
        }
        .type-diagnostico { background-color: #007bff; }
        .type-instalacao { background-color: #28a745; }
        .type-manutencao { background-color: #ffc107; color: #212529; }
        .type-seguranca { background-color: #dc3545; }
        .type-performance { background-color: #6f42c1; }
        .type-infraestrutura { background-color: #6c757d; }
        .type-outros { background-color: #20c997; }
        .summary-section {
            background-color: #e8f4f8;
            border-left: 4px solid #4F46E5;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .summary-title {
            font-size: 16px;
            font-weight: 600;
            color: #4F46E5;
            margin-bottom: 10px;
        }
        .equipment-list {
            margin: 15px 0;
        }
        .equipment-item {
            background-color: #f8f9fa;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 4px;
            border-left: 3px solid #4F46E5;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
        }
        .footer p {
            margin: 5px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
        .btn:hover {
            background-color: #3730A3;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Laudo Técnico</h1>
            <p>{{ $report->report_number }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Olá {{ $report->customer->name }},
            </div>

            <p>
                Esperamos que esteja bem! Anexamos o laudo técnico referente aos serviços realizados. 
                Abaixo você encontra um resumo dos detalhes:
            </p>

            <!-- Report Details -->
            <div class="report-details">
                <div class="detail-row">
                    <span class="detail-label">Número do Laudo:</span>
                    <span class="detail-value">#{{ $report->report_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Data de Inspeção:</span>
                    <span class="detail-value">{{ $report->inspection_date->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Data do Laudo:</span>
                    <span class="detail-value">{{ $report->report_date->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Tipo:</span>
                    <span class="detail-value">
                        <span class="type-badge type-{{ $report->report_type }}">{{ $report->report_type_name }}</span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ $report->status }}">{{ $report->status_name }}</span>
                    </span>
                </div>
                @if($report->service_order_number)
                    <div class="detail-row">
                        <span class="detail-label">Ordem de Serviço:</span>
                        <span class="detail-value">{{ $report->service_order_number }}</span>
                    </div>
                @endif
                @if($report->invoice)
                    <div class="detail-row">
                        <span class="detail-label">Fatura Relacionada:</span>
                        <span class="detail-value">{{ $report->invoice->invoice_number }}</span>
                    </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Responsável Técnico:</span>
                    <span class="detail-value">{{ $report->technician_name }}</span>
                </div>
                @if($report->valid_until)
                    <div class="detail-row">
                        <span class="detail-label">Válido até:</span>
                        <span class="detail-value">{{ $report->valid_until->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>

            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-title">{{ $report->title }}</div>
                <p>{{ $report->description }}</p>
            </div>

            <!-- Equipment Analyzed -->
            @if($report->equipment_analyzed && count($report->equipment_analyzed) > 0)
                <div class="summary-section">
                    <div class="summary-title">Equipamentos/Sistemas Analisados</div>
                    <div class="equipment-list">
                        @foreach($report->equipment_analyzed as $equipment)
                            <div class="equipment-item">
                                <strong>{{ $equipment['name'] ?? 'Equipamento' }}</strong>
                                @if($equipment['model'])
                                    <br>Modelo: {{ $equipment['model'] }}
                                @endif
                                @if($equipment['serial'])
                                    <br>Série: {{ $equipment['serial'] }}
                                @endif
                                @if($equipment['status'])
                                    <br>Status: {{ $equipment['status'] }}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Key Findings -->
            <div class="summary-section">
                <div class="summary-title">Principais Constatações</div>
                <p>{{ Str::limit($report->findings, 200) }}</p>
            </div>

            <!-- Recommendations -->
            <div class="summary-section">
                <div class="summary-title">Recomendações</div>
                <p>{{ Str::limit($report->recommendations, 200) }}</p>
            </div>

            @if($report->status === 'approved')
                <p>
                    <strong>Laudo Aprovado:</strong><br>
                    Este laudo foi aprovado por {{ $report->approved_by }} em {{ $report->approved_at->format('d/m/Y H:i') }}.
                </p>
            @elseif($report->status === 'completed')
                <p>
                    <strong>Laudo Concluído:</strong><br>
                    Este laudo foi finalizado e está aguardando aprovação.
                </p>
            @endif

            <p>
                O laudo técnico completo está em anexo no formato PDF. Se tiver alguma dúvida sobre este laudo, 
                entre em contato conosco respondendo este email ou através dos nossos canais de atendimento.
            </p>

            <p>
                Atenciosamente,<br>
                <strong>{{ $report->technician_name }}</strong><br>
                Responsável Técnico
                @if($report->technician_registration)
                    <br>{{ $report->technician_registration }}
                @endif
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                <strong>{{ config('app.name') }}</strong><br>
                Este é um email automático. Por favor, não responda diretamente.
            </p>
            <p>
                Laudo gerado em {{ now()->format('d/m/Y H:i') }}
            </p>
        </div>
    </div>
</body>
</html>
