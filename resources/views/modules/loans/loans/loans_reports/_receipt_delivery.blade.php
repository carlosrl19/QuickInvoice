<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>#CE-{{ $loan->loan_code_number }}</title>

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
            font-size: 9pt;
        }

        .payment-details tbody td {
            padding: 10px;
            border: 1px solid lightgray;
            font-size: 7.5pt;
        }

        .receipt-footer {
            display: flex;
            justify-content: space-between;
            margin-top: -80px;
            width: 60%;
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
            <img src="../public/storage/static/logo-rounded.png" width="64" height="64">
            <br /><br />
            <span class="subtitle">INVERSIONES ROBENIOR</span><br />
            <span class="text_header_sm">Bº RIO DE PIEDRAS, 21 AVE, 5 CALLE, SAN PEDRO SULA, CORTES</span><br />
            <span class="text_header_sm">TEL.: 2510-6118 | CORREO: contabilidad@robenior.com | R.T.N.: 08011999074695</span><br />
        </div>

        <div class="information">
            <div>
                <span class="text_header_sm">Lugar: SAN PEDRO SULA, CORTÉS</span><br />
                <span CLASS="text_header_sm">Fecha: {{ Carbon\Carbon::parse($loan->created_at)->format('d/m/Y H:i:s a') }}</span>
            </div>
            <div>
                <span class="text_header_sm">Cliente: <strong>{{ $loan->client->client_name }}</strong></span><br />
                <span class="text_header_sm">R.T.N.: {{ $loan->client->client_document }}</span><br />
                <span class="text_header_sm">Referencia: {{ $loan->loan_request_number }}</span><br />
            </div>
        </div>

        <table class="payment-details">
            <thead>
                <tr>
                    <th>Cant.</th>
                    <th style="width: 43%;">Producto / Código</th>
                    <th>Serie #</th>
                    <th>Desc.</th>
                    <th style="text-align: right !important;">Precio</th>
                    <th style="text-align: right !important;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: left !important;">
                    <td>1</td>
                    <td>{{ $loan->loan_description }} / (X)</td>
                    <td>N/A</td>
                    <td>0.00%</td>
                    <td style="text-align: right !important;">L. {{ number_format($loan->loan_total,2) }}</td>
                    <td style="text-align: right !important;">L. {{ number_format($loan->loan_total,2) }}</td>
                </tr>
                <tr style="text-align: left !important;">
                    <td></td>
                    <td>---- ULTIMA LÍNEA ----</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <!-- Extra rows -->
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr style="text-align: right !important; font-weight: bold;">
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;"></td>
                    <td style="border-top: none !important; border-left: none !important; border-right: none !important; border-bottom: 1px solid #eee">Descuento:</td>
                    <td style="border-top: none !important; border-left: none !important; border-right: none !important; border-bottom: 1px solid #eee"></td>
                    <td style="border-top: none !important; border-left: none !important; border-right: none !important; border-bottom: 1px solid #eee">L. 0.00</td>
                </tr>
                <tr style="text-align: right !important; font-weight: bold;">
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;">Total:</td>
                    <td style="border: none !important;"></td>
                    <td style="border: none !important;">L. {{ number_format($loan->loan_total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="receipt-footer">
            <p style="font-size: 11pt;"><strong>Comprobante de entrega # {{ $loan->loan_code_number }}</strong></p>
            <p style="font-size: 8pt">Fecha vencimiento: {{ \Carbon\Carbon::parse($loan->loan_end_date)->format('d/m/Y') }} Crédito a {{ $loan->loan_quote_number }}
                @if($loan->loan_payment_type == 1)
                días
                @elseif($loan->loan_payment_type == 2)
                semanas
                @elseif($loan->loan_payment_type == 3)
                quincenas
                @elseif($loan->loan_payment_type == 4)
                meses
                @else
                <strong class="text-danger">(?)</strong>
                @endif
            </p>
            <p style="font-size: 7pt"><strong>NOTA: EL IMPORTE TOTAL DE ESTA FACTURA DEVENGARÁ EL 3% MENSUAL DESPUÉS DE LA FECHA DE VENCIMIENTO</strong></p>
            <p style="font-size: 8pt">Son: {{ $loan_amount_letras }} LEMPIRAS EXACTOS</p>
        </div>
    </div>
</body>

</html>