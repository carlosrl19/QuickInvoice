<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>#FV-{{ $sale->id }}</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: -37px
        }

        .divider {
            border-bottom: 1px solid #eee;
            margin-top: -3px;
        }

        .invoice-box {
            max-width: 800px;
            margin-top: 15px;
            /* border: 1px solid #eee; */
            /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            font-weight: bold;
            font-size: 10pt;
        }

        .text_header_sm {
            font-size: 8pt;
            text-align: center;
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

<header style="margin-top: -20px">
    <div style="width: 48%;">
        <h3>Inversiones Robenior</h3>
        <div class="divider"></div>
        <span class="text_header_sm">
            Casa matriz: San Pedro Sula, Honduras Tel: 2510 6118
        </span><br>
        <span class="text_header_sm">
            Correo: contabilidad@robenior.com
        </span><br>
        <span class="text_header_sm">
            R.T.N.: 08011999074695
        </span><br>
        <span class="text_header_sm">
            Sucursal: OFICINA PRINCIPAL
        </span><br>
        <span class="text_header_sm">
            Lugar: SAN PEDRO SULA, CORTÉS.
        </span><br>
        <span class="text_header_sm">
            Despachado desde: OFICINA PRINCIPAL
        </span><br>
        <span class="text_header_sm">
            Fecha: {{ Carbon\Carbon::parse($sale->created_at)->format('d/m/Y H:i:s a') }}
        </span><br>
    </div>
    <div style="width: 100%;">
        <img style="margin-left: 84%; margin-top: -25.7%" src="../public/storage/static/logo-rounded.png" width="80" height="80"><br>
        <img style="margin-left: 80%; margin-top: -17.2%" src="../public/storage/static/logo-letters.jpg" width="138" height="40">
    </div>
</header>

<body>
    <div class="container">
        <!-- Client information -->
        <div style="width: 45%; border: 1px solid #000; border-radius: 5px; padding: 10px;">
            <p style="font-weight: bolder; font-size: 11pt; margin-top: -2px;">Cliente:</p>
            <p style="font-size: 8.5pt; margin-top: -3px;">{{ $sale->client->client_code }} - {{ $sale->client->client_name }}</p>
            <p style="font-size: 8.5pt; margin-top: -8px;">R.T.N.: {{ $sale->client->client_document }}</p><br>
            <span style="font-size: 8.5pt;">Comentario: Vendedor: {{ $sale->seller->seller_name }}</span>
        </div>

        <!-- Exonerated information -->
        <div style="float: right; margin-top: -131px; width: 45%; height: 115px; border: 1px solid #000; border-radius: 5px; padding: 10px">
            <p style="font-size: 8.5pt; margin-top: -2px; letter-spacing: -0.5px">DATOS DEL ADQUIRIENTE EXONERADO</p>
            <p style="font-size: 8.5pt; margin-top: -3px;">No. correlativo de orden de compra exenta:</p>
            <p style="font-size: 8.5pt; border-bottom: 1px solid #000; width: 50%;"></p>
            <p style="font-size: 8.5pt; margin-top: -3px;">No. correlativo de constancia registro exonerado:</p>
            <p style="font-size: 8.5pt; border-bottom: 1px solid #000; width: 50%;"></p>
            <p style="font-size: 8.5pt; margin-top: -3px;">No. identificativo del registro de la SAG:</p>
            <p style="font-size: 8.5pt; border-bottom: 1px solid #000; width: 50%;"></p>
        </div>

        <div class="invoice-box">
            <table class="payment-details" style="border: 1px solid #000; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: center !important;">
                        <th style="width: 8%; height: 45px; border: 1px solid #000; font-size: 10pt;">Cant.</th>
                        <th style="width: 66%; border: 1px solid #000; font-size: 10pt;">Descripción del producto / código</th>
                        <th style="width: 5%; border: 1px solid #000; font-size: 10pt;">Serie</th>
                        <th style="width: 16%; border: 1px solid #000; font-size: 10pt;">Precio<br>Unit.</th>
                        <th style="width: 18%; border: 1px solid #000; font-size: 10pt;">Desc./Rebaj.</th>
                        <th style="width: 26%; border: 1px solid #000; font-size: 10pt;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pos_details as $sale_detail)
                    <tr style="text-align: left !important;">
                        <td style="text-align: center !important; border-right: 1px solid #000; font-size: 8.5pt; padding: 10px;">
                            {{ $sale_detail->sale_quantity }}
                        </td>
                        <td style="border-right: 1px solid #000; font-size: 8.5pt; padding: 10px;">
                            {{ $sale_detail->service->service_name }} / {{ $sale_detail->service->service_nomenclature }}
                            {{ $sale_detail->sale_details ? $sale_detail->sale_details:'' }}
                        </td>
                        <td style="text-align: center !important; border-right: 1px solid #000; font-size: 8.5pt; padding: 10px;">
                            N/A
                        </td>
                        <td style="text-align: right !important; border-right: 1px solid #000; font-size: 8.5pt; padding: 10px;">
                            L. {{ number_format($sale->sale_total_amount - $sale->sale_isv_amount,2) }}
                        </td>
                        <td style="text-align: center !important; border-right: 1px solid #000; font-size: 8.2pt; padding: 10px;">{{ number_format($sale_detail->sale->sale_discount,2) }} ({{ number_format($sale_detail->sale->sale_discount,2) }}%)</td>
                        <td style="text-align: right !important; font-size: 8.5pt; padding: 10px;">L. {{ number_format($sale->sale_total_amount - $sale->sale_isv_amount,2) }} (X)</td>
                    </tr>
                    @endforeach
                    <tr style="text-align: left !important;">
                        <td style="border-right: 1px solid #000; font-size: 8.5pt;"></td>
                        <td style="padding: 10px; border-right: 1px solid #000; font-size: 8.5pt;">---- ULTIMA LÍNEA ----</td>
                        <td style="border-right: 1px solid #000; font-size: 8.5pt;"></td>
                        <td style="border-right: 1px solid #000; font-size: 8.5pt;"></td>
                        <td style="border-right: 1px solid #000; font-size: 8.5pt;"></td>
                        <td style="border-right: 1px solid #000; font-size: 8.5pt;"></td>
                    </tr>
                    <tr>
                        <td style="border-right: 1px solid #000; height: 130px;"></td>
                        <td style="border-right: 1px solid #000;"></td>
                        <td style="border-right: 1px solid #000;"></td>
                        <td style="border-right: 1px solid #000;"></td>
                        <td style="border-right: 1px solid #000;"></td>
                        <td style="border-right: 1px solid #000;"></td>
                    </tr>
                </tbody>
            </table>

            <!-- Receipt information -->
            <table style="border: 1px solid #000; border-collapse: collapse; margin-top: -15px;">
                <tr>
                    <td style="width: 59%; padding: 10px; vertical-align: top;">
                        <p style="font-weight: bolder; font-size: 11.5pt; margin-top: 5px;">Factura de contado # 000-001-01-00008034 (X)</p>
                        <p style="font-size: 9pt; margin-top: -3px;">Valor en letras: {{ $sale_amount_letras }} LEMPIRAS EXACTOS</p>
                        <p style="font-weight: bolder; font-size: 9.5pt; margin-top: -8px;">CONDICIONES GENERALES:</p>
                        <div style="margin-top: 15px"></div>
                        <p style="font-size: 10.5pt; margin-top: -8px;">Firma:
                        <div style="float: left; margin-top: -18px; margin-left: 42px; width: 230px; border-bottom: 1px solid #000;"></div>
                        </p>
                        <p style="font-size: 7pt; margin-top: -10px;">CAI: 2513C0-E8BB43-D7BAE0-63BE03-090902-4C Fecha limite de emisión: 22/10/2025 (X)</p>
                        <p style="font-size: 7.8pt; margin-top: -8px;">Rango autorizado: 000-001-01-00007971 al 000-001-01-00008970</p>
                        <p style="font-size: 7.8pt; margin-top: -8px;">G=Gravado E=Exento</p>
                        <p style="font-size: 8.7pt; margin-top: -8px; line-height: 1.5;">NOTA: EL IMPORTE TOTAL DE ESTA FACTURA DEVENGARÁ EL 3% MENSUAL DESPUÉS DE LA FECHA DE VENCIMIENTO</p>
                        <p style="font-weight: bolder; font-size: 10.2pt; margin-top: -8px;">La factura es beneficio de todos "EXIJALA"</p>
                    </td>
                    <td style="line-height: 0.9; width: 23%; padding: 10px; vertical-align: top; border-left: 1px solid #000; border-right: 1px solid #000; text-align: right;">
                        <p style="font-size: 10pt; margin-top: 3px;">Importe exonerado:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">Importe exento:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">Importe gravado 15%:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">Importe gravado 18%:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">I.S.V 15%:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">I.S.V 18%:</p>
                        <p style="font-weight: bolder; font-size: 10.6pt; margin-top: -3px;">Total a pagar:</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 10pt; margin-top: -8px;">Descuentos y rebajas:</p>
                        <p style="font-size: 10pt; margin-top: -8px;">Método pago efectivo:</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 10pt; margin-top: -8px;">Cambio:</p>
                    </td>
                    <td style="line-height: 0.9; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-size: 10pt; margin-top: 3px;">L. (X)</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. (X)</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. {{ number_format($sale->sale_total_amount - $sale->sale_isv_amount,2) }}</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. {{ number_format($sale->sale_isv_amount,2) }}</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-weight: bolder; font-size: 10.6pt; margin-top: -3px;">L. {{ number_format($sale->sale_total_amount,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 10pt; margin-top: -8px;">L. {{ number_format($sale->sale_discount,2) }}</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. {{ number_format($sale->sale_payment_received,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 10pt; margin-top: -8px;">L. {{ number_format($sale->sale_payment_change,2) }}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <span style="float: left; font-size: 8pt; margin-top: -16px; margin-left: 10px">
        Usuario: (X) | Impreso: XX/X/XXXX XX:XX:XX | Origen: POS
    </span>
    <span style="float: right; font-size: 8pt; margin-top: -16px; margin-right: 20px">
        {{ config('app.name') }}
    </span>
</body>

</html>