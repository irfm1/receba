<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatura {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            border-bottom: 2px solid #3B82F6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info {
            text-align: right;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #3B82F6;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 10px;
        }
        .invoice-info {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .invoice-info > div {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-title {
            font-size: 16px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 10px;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background-color: #D1FAE5; color: #065F46; }
        .status-sent { background-color: #DBEAFE; color: #1E40AF; }
        .status-draft { background-color: #F3F4F6; color: #374151; }
        .status-overdue { background-color: #FEE2E2; color: #991B1B; }
        .status-cancelled { background-color: #F3F4F6; color: #6B7280; }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #E5E7EB;
        }
        .items-table th {
            background-color: #F9FAFB;
            font-weight: bold;
            color: #374151;
        }
        .items-table .text-right {
            text-align: right;
        }
        .items-table .text-center {
            text-align: center;
        }
        
        .totals {
            margin-top: 25px;
            width: 300px;
            margin-left: auto;
        }
        .totals .row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #E5E7EB;
        }
        .totals .total-row {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #3B82F6;
            border-bottom: none;
            margin-top: 10px;
            padding-top: 10px;
        }
        .total-amount {
            color: #3B82F6;
        }
        
        .description-box,
        .notes-box {
            background-color: #F9FAFB;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #3B82F6;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">Receba</div>
            <div>Sistema de Gestão de Faturas</div>
        </div>
        
        <div class="invoice-title">FATURA</div>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <strong>{{ $invoice->invoice_number }}</strong><br>
                Fatura #{{ $invoice->id }}
            </div>
            <div>
                <span class="status-badge status-{{ $invoice->status }}">
                    {{ $invoice->getStatusLabel() }}
                </span>
            </div>
        </div>
    </div>

    <div class="invoice-info">
        <div>
            <div class="info-section">
                <div class="info-title">Cliente</div>
                <strong>{{ $invoice->customer->name }}</strong><br>
                {{ $invoice->customer->email }}<br>
                @if($invoice->customer->phone)
                    {{ $invoice->customer->phone }}<br>
                @endif
                @if($invoice->customer->address)
                    {{ $invoice->customer->address }}
                @endif
            </div>
        </div>
        
        <div>
            <div class="info-section">
                <div class="info-title">Informações da Fatura</div>
                <strong>Data de Emissão:</strong> {{ $invoice->issue_date->format('d/m/Y') }}<br>
                <strong>Data de Vencimento:</strong> {{ $invoice->due_date->format('d/m/Y') }}<br>
                @if($invoice->paid_at)
                    <strong>Data de Pagamento:</strong> {{ $invoice->paid_at->format('d/m/Y') }}<br>
                @endif
            </div>
        </div>
    </div>

    @if($invoice->description)
        <div class="info-section">
            <div class="info-title">Descrição</div>
            <div class="description-box">
                {{ $invoice->description }}
            </div>
        </div>
    @endif

    @if($invoice->items && count($invoice->items) > 0)
        <div class="info-section">
            <div class="info-title">Itens</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th class="text-center">Qtd</th>
                        <th class="text-right">Valor Unit.</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                        <tr>
                            <td>{{ $item['description'] }}</td>
                            <td class="text-center">{{ $item['quantity'] }}</td>
                            <td class="text-right">R$ {{ number_format($item['unit_price'], 2, ',', '.') }}</td>
                            <td class="text-right">R$ {{ number_format($item['quantity'] * $item['unit_price'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="totals">
        <div class="row">
            <span>Subtotal:</span>
            <span>R$ {{ number_format($invoice->subtotal, 2, ',', '.') }}</span>
        </div>
        
        @if($invoice->tax_amount > 0)
            <div class="row">
                <span>Impostos:</span>
                <span>R$ {{ number_format($invoice->tax_amount, 2, ',', '.') }}</span>
            </div>
        @endif
        
        @if($invoice->discount_amount > 0)
            <div class="row">
                <span>Desconto:</span>
                <span>-R$ {{ number_format($invoice->discount_amount, 2, ',', '.') }}</span>
            </div>
        @endif
        
        <div class="row total-row">
            <span>Total:</span>
            <span class="total-amount">R$ {{ number_format($invoice->total_amount, 2, ',', '.') }}</span>
        </div>
    </div>

    @if($invoice->notes)
        <div class="info-section">
            <div class="info-title">Observações</div>
            <div class="notes-box">
                {{ $invoice->notes }}
            </div>
        </div>
    @endif

    <div class="footer">
        <p>Fatura gerada em {{ now()->format('d/m/Y H:i') }} pelo sistema Receba</p>
    </div>
</body>
</html>
