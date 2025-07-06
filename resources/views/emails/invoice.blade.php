<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura #{{ $invoice->invoice_number }}</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .invoice-details {
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
            font-weight: bold;
            font-size: 18px;
            color: #667eea;
        }
        .detail-label {
            color: #6c757d;
        }
        .detail-value {
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
        }
        .status-draft { background-color: #6c757d; color: white; }
        .status-sent { background-color: #007bff; color: white; }
        .status-paid { background-color: #28a745; color: white; }
        .status-overdue { background-color: #dc3545; color: white; }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 500;
        }
        .attachment-note {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 4px 4px 0;
        }
        .attachment-note .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 8px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Fatura #{{ $invoice->invoice_number }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Olá {{ $invoice->customer->name }},
            </div>

            <p>
                Esperamos que esteja bem! Anexamos a fatura referente aos serviços prestados. 
                Abaixo você encontra um resumo dos detalhes:
            </p>

            <!-- Invoice Details -->
            <div class="invoice-details">
                <div class="detail-row">
                    <span class="detail-label">Número da Fatura:</span>
                    <span class="detail-value">#{{ $invoice->invoice_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Data de Emissão:</span>
                    <span class="detail-value">{{ $invoice->issue_date->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Data de Vencimento:</span>
                    <span class="detail-value">{{ $invoice->due_date->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ $invoice->getStatusLabel() }}
                        </span>
                    </span>
                </div>
                @if($invoice->description)
                <div class="detail-row">
                    <span class="detail-label">Descrição:</span>
                    <span class="detail-value">{{ Str::limit($invoice->description, 50) }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Valor Total:</span>
                    <span class="detail-value">R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
                </div>
            </div>

            <!-- Attachment Note -->
            <div class="attachment-note">
                <span class="icon">📄</span>
                <strong>Fatura em anexo:</strong> O arquivo PDF completo da fatura está anexado a este email para download e impressão.
            </div>

            @if($invoice->status !== 'paid')
            <p>
                <strong>Instruções de Pagamento:</strong><br>
                Por favor, efetue o pagamento até a data de vencimento. Caso tenha dúvidas sobre os métodos de pagamento 
                aceitos ou precise de esclarecimentos adicionais, não hesite em entrar em contato conosco.
            </p>
            @else
            <p>
                <strong>Pagamento Confirmado:</strong><br>
                Agradecemos pelo pagamento! Esta fatura já foi quitada em {{ $invoice->paid_at?->format('d/m/Y') }}.
            </p>
            @endif

            <p>
                Agradecemos pela confiança em nossos serviços. Se tiver alguma dúvida sobre esta fatura, 
                entre em contato conosco respondendo este email ou através dos nossos canais de atendimento.
            </p>

            <p>
                Atenciosamente,<br>
                <strong>Equipe {{ config('app.name') }}</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Este é um email automático. Por favor, não responda diretamente a este email.<br>
                © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.
            </p>
        </div>
    </div>
</body>
</html>
