<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>#RP-{{ $loan_payment->loan_payment_doc_number }}</title>

    @php $currency = App\Models\Settings::value('default_currency_symbol') @endphp

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            /* border: 1px solid #eee; */
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            line-height: 1.35em;
            font-size: 10pt;
        }

        .title {
            font-size: 14pt;
            font-weight: bold;
            opacity: 0.7;
        }

        .subtitle {
            font-size: 12pt;
            font-weight: bold;
            opacity: 1;
        }

        .subtitle_2 {
            font-size: 12pt;
            font-weight: bold;
            opacity: 0.5;
            display: flex;
            margin: auto;
            text-align: center;
            text-decoration: underline;
        }

        .information {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .information div {
            width: 48%;
            font-size: 10pt;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #eee;
            font-weight: bold;
            font-size: 10pt;
        }

        tr.item td {
            border-bottom: 1px solid #eee;
            font-size: 9pt;
        }

        tr.item td {
            font-size: 9pt;
            text-align: center;
        }

        tr.item_footer td {
            font-size: 10pt;
            text-align: center;
            border: none;
            font-weight: bold;
        }

        .text_header_sm {
            font-size: 8pt;
            text-align: center;
        }

        .font_8_italic {
            font-style: italic;
            font-size: 8pt;
        }

        .payment-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .payment-details thead th {
            text-align: left !important;
            border: 1px solid lightgray;
            padding: 10px;
            font-size: 12px;
        }

        .payment-details tbody td {
            padding: 10px;
            border: 1px solid lightgray;
            font-size: 12px;
        }

        .receipt-footer {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 10px;
        }

        .receipt-footer h3 {
            font-size: 16px;
        }

        .receipt-footer p {
            margin: 5px 0;
        }

        @media only screen and (max-width: 600px) {
            .information {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .information div {
                width: auto;
                /* Allow full width on small screens */
                margin-bottom: 10px;
                /* Add spacing between items */
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">

        <div class="header">
            <img src="{{ 'storage/sys_config/img/' . $settings->logo_company ?? 'storage/assets/img/kaiadmin/favicon.png' }}" width="64" height="64">
            <br /><br />
            <span class="subtitle">{{ $settings->company_name ?? 'Nombre empresa' }}</span><br />
            <span class="text_header_sm">{{ $settings->company_address ?? 'Dirección empresa' }}</span><br />
            <span class="text_header_sm">TEL.: {{ $settings->company_phone ?? 'Teléfono empresa' }} | CORREO: {{ $settings->company_email ?? 'Email empresa' }} | R.T.N.: {{ $settings->company_rtn ?? 'R.T.N. Empresa' }}</span><br />
        </div>

        <div class="information">
            <div>
                <strong>LUGAR Y FECHA:</strong><br />
                <span class="text_header_sm"> {{ $settings->company_short_address ?? 'Dirección corta empresa' }}</span><br />
                <span>{{ $loan->created_at }}</span>
            </div>

            <br>

            <div>
                <strong>CLIENTE:</strong> <br />
                <span class="text_header_sm">{{ $loan->client->client_name }}</span><br />
                <span class="text_header_sm">DOCUMENTO: {{ $loan->client->client_document }}</span><br />
                @if( $loan->client->client_phone2 == '')
                <span class="text_header_sm">TELEFONO: {{ $loan->client->client_phone1 }}</span><br />
                @else
                <span class="text_header_sm">TELEFONOS: {{ $loan->client->client_phone1 }}, {{ $loan->client->client_phone2 }}</span><br />
                @endif
                <span class="text_header_sm">REFERENCIA: <strong>#{{ $loan->loan_code_number }}</strong></span><br />
            </div>
        </div>

        <table class="payment-details">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: left !important;">
                    <td>
                        Abono al préstamo #{{ $loan->loan_code_number }} | Int. Corriente: 0.00 | Mora: 0.00<br>
                        Capital: {{ $currency }} {{ number_format($loan_payment->loan_quote_payment_amount, 2) }}<br>
                        Saldo Anterior: {{ $currency }} {{ number_format($loan_payment->loan_old_debt,2) }}<br>
                        Nuevo Saldo: {{ $currency }} {{ number_format($loan_payment->loan_new_debt,2) }}
                    </td>
                    <td>{{ $currency }} {{ number_format($loan_payment->loan_quote_payment_amount, 2) }}</td>
                </tr>
                <tr style="text-align: left !important;">
                    <td>---- ULTIMA LÍNEA ----</td>
                    <td></td>
                </tr>
                <tr style="text-align: right !important; font-weight: bold">
                    <td>Total</td>
                    <td>{{ $currency }} {{ number_format($loan_payment->loan_quote_payment_amount, 2) }}</td>
                </tr>
                <tr style="text-align: right !important; font-weight: bold">
                    <td>Cambio</td>
                    <td>{{ $currency }} 0.00</td>
                </tr>
            </tbody>
        </table>

        <div class="receipt-footer">
            <p style="font-size: 14px"><strong>Recibo de pago # RP{{ $loan_payment->loan_payment_doc_number }}</strong></p>
            <p>SON: {{ $loan_amount_letras }} EXACTO</p>
            <p style="font-size: 8px"><strong>NOTA: EL IMPORTE TOTAL DE ESTA FACTURA DEVENGARÁ EL 3% MENSUAL DESPUÉS DE LA FECHA DE VENCIMIENTO</strong></p>
        </div>
    </div>
</body>

</html>