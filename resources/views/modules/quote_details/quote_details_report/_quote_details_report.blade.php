<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Cotización #{{ $quote->quote_code }}</title>

    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: -37px;
        }

        .divider {
            border-bottom: 1px solid #eee;
            margin-top: -3px;
        }

        .invoice-box {
            max-width: 800px;
            margin-top: -15px;
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
            background-color: rgba(169, 181, 223, 0.3);
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

<header style="margin-top: -20px; display: flex; justify-content: space-between; align-items: center; position: relative;">
    <!-- Imagen posicionada a la derecha -->
    <div style="position: absolute; top: 0; left: 220; opacity: 0.8;">
        <img src="{{ public_path('../storage/app/public/sys_config/img/' . $settings->logo_company) ?? public_path('../storage/app/public/assets/img/kaiadmin/favicon.png') }}" alt="" style="min-width: 90px; min-height: 90px; max-width: 180px; max-height: 100px" />
    </div>
    <div style="width: 100%; text-align: center; margin-top: 110px">
        <h3 style="margin: 5px;">{{ $settings->company_name ?? 'Nombre empresa' }}</h3>
        <span class="text_header_sm">
            {{ ucwords(strtolower($settings->company_short_address ?? 'Correo empresa')) }}<br>
            Tel: {{ $settings->company_phone ?? 'Teléfono empresa' }} -
            Correo: {{ $settings->company_email ?? 'Correo empresa' }} -
            R.T.N.: {{ $settings->company_rtn ?? 'R.T.N empresa' }}
        </span><br>
    </div>
</header>

<body>
    <div class="container">
        <!-- Client and Exonerated Information Container -->
        <div style="position: relative; width: 100%; margin-top: 50px; height: 130px;">
            <!-- Client information -->
            <div style="position: absolute; top: 20; left: 0; width: 50%; padding: 10px;">
                <p style="font-size: 8.5pt; margin-top: -3px;">Cliente: {{ $quote->client->client_code }} - {{ $quote->client->client_name }}</p>
                <p style="font-size: 8.5pt; margin-top: -8px;">R.T.N.: {{ $quote->client->client_document }}</p>
                <p style="font-size: 8.5pt; margin-top: -8px;">{{ $settings->company_short_address }}</p>
            </div>

            <!-- Quote information -->
            <div style="position: absolute; top: 10; right: 0; width: 35%; border-radius: 5px; padding: 10px;">
                <p style="font-size: 8.5pt; margin-top: -3px;">Cotización # <strong>{{ $quote->quote_code }}</strong></p>
                <p style="font-size: 8.5pt; margin-top: -8px;">Hora y fecha: {{ Carbon\Carbon::parse($todayDate)->format('d/m/Y H:i:s a') }}</p>
                <p style="font-size: 8.5pt; margin-top: -8px;">Lugar: {{ $settings->company_short_address }}</p>
                <p style="font-size: 8.5pt; margin-top: -8px;">Vendedor: {{ $quote->seller->seller_name }}</p>
            </div>
        </div>

        <div class="invoice-box">
            <table style="border-collapse: collapse;">
                <thead>
                    <tr style="text-align: center !important;">
                        <th style="border: 1px solid transparent; width: 10%; height: 45px; font-size: 10pt;">Cant.</th>
                        <th style="border: 1px solid transparent; width: 10%; font-size: 10pt;">Código</th>
                        <th style="border: 1px solid transparent; width: 30%; font-size: 10pt;">Producto</th>
                        <th style="border: 1px solid transparent; width: 10%; font-size: 10pt;">Serie</th>
                        <th style="border: 1px solid transparent; width: 19%; font-size: 10pt;">
                            @if($quote->quote_type == 'G')
                            Precio<br>individual
                            @else
                            Precio<br>normal
                            @endif
                        </th>
                        <th style="border: 1px solid transparent; width: 18%; font-size: 10pt;">Desc./Rebaj.</th>
                        <th style="border: 1px solid transparent; width: 13%; font-size: 10pt;">ISV</th>
                        <th style="border: 1px solid transparent; width: 20%; font-size: 10pt; text-align: center;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quote_details as $quote_detail)
                    <tr style="text-align: left !important;">
                        <td style="text-align: center !important; font-size: 8.5pt; padding: 10px;">
                            {{ $quote_detail->quote_quantity }}
                        </td>
                        <td style="text-align: center !important; font-size: 8.5pt; padding: 10px;">
                            {{ $quote_detail->service->service_nomenclature }}
                        </td>
                        <td style="font-size: 8.5pt; padding: 10px;">
                            {{ ucfirst(strtolower($quote_detail->quote_details ?? '')) }}
                        </td>
                        <td style="text-align: center !important; font-size: 8.5pt; padding: 10px;">
                            N/A
                        </td>
                        <td style="text-align: center !important; font-size: 8.5pt; padding: 10px;">
                            L. {{ number_format($quote_detail->quote_price,2) }}
                        </td>
                        <td style="text-align: center !important; font-size: 8.2pt; padding: 10px;">
                            L. {{ number_format($quote->quote_discount,2) }}
                        </td>
                        <td style="text-align: center !important; font-size: 8.5pt; padding: 10px;">
                            {{ $quote->quote_tax }} %
                        </td>
                        <td style="text-align: right !important; font-size: 8.5pt; padding: 10px;">
                            L. {{ number_format($quote_detail->quote_subtotal,2) }}
                            <span>{{ $quote->quote_type == 'ET' ? 'E':$quote->quote_type }}</span>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="text-align: left !important;">
                        <td style="font-size: 8.5pt;"></td>
                        <td style="font-size: 8.5pt;"></td>
                        <td style="padding: 10px; font-size: 8.5pt;">---- ULTIMA LÍNEA ----</td>
                        <td style="font-size: 8.5pt;"></td>
                        <td style="font-size: 8.5pt;"></td>
                        <td style="font-size: 8.5pt;"></td>
                        <td style="font-size: 8.5pt;"></td>
                        <td style="font-size: 8.5pt;"></td>
                    </tr>
                    <tr>
                        <td colspan="8" style="height: 20px;"></td>
                    </tr>
                </tbody>
            </table>

            <!-- Receipt information -->
            <table style="border-collapse: collapse; margin-top: -15px;">
                <tr>
                    <td style="width: 62%; padding: 10px; vertical-align: top;">
                        <p style="font-weight: bolder; font-size: 10pt; margin-top: 5px; text-align: left;">Cotización # {{ $quote->quote_code }}</p>
                        <p style="font-size: 8.5pt; margin-top: -3px; text-align: left;">Valor en letras: {{ $quote_amount_letras }} LEMPIRAS EXACTOS</p>
                        <p style="font-size: 8.5pt; margin-top: -3px; text-align: left;">G=Gravado E=Exento</p>
                        <div style="margin-top: 60px"></div>
                        <p style="font-size: 9.5pt; margin-top: -8px;">Firma:
                        <div style="float: left; margin-top: -18px; margin-left: 42px; width: 230px; border-bottom: 1px solid #000;"></div>
                        </p>
                    </td>
                    <td style="line-height: 1.1; width: 23%; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: 3px;">Importe exonerado:</p>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">Importe exento:</p>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">Importe gravado 15%:</p>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">Importe gravado 18%:</p>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">I.S.V 15%:</p>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">I.S.V 18%:</p>
                        <p style="font-weight: bolder; font-size: 9.6pt; margin-top: -3px;">Total a pagar:</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-weight: bolder; font-size: 8.5pt; margin-top: -8px;">Descuentos y rebajas:</p>

                    </td>
                    @if($quote->quote_type == 'G' && $quote->quote_exempt_tax == 0) <!-- Gravada con ISV -->
                    <td style="line-height: 1.1; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-size: 8.5pt; margin-top: 3px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_total_amount - $quote->quote_isv_amount,2) }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ $quote->quote_type == 'G' ? number_format($quote->quote_isv_amount,2):'0.00' }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-weight: bolder; font-size: 9.6pt; margin-top: -3px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_discount,2) }}</p>
                    </td>
                    @elseif($quote->quote_type == 'G' || $quote->quote_type == 'ET' && $quote->quote_exempt_tax == 1) <!-- Exenta -->
                    <td style="line-height: 1.1; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-size: 8.5pt; margin-top: 3px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-weight: bolder; font-size: 9.6pt; margin-top: -3px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_discount,2) }}</p>
                    </td>
                    @elseif($quote->quote_type == 'E') <!-- Exonerada -->
                    <td style="line-height: 1.1; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-size: 8.5pt; margin-top: 3px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-weight: bolder; font-size: 9.6pt; margin-top: -3px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_discount,2) }}</p>
                    </td>
                    @else
                    <td style="line-height: 1.1; padding: 10px; vertical-align: top; text-align: right;">
                        <p style="font-size: 8.5pt; margin-top: 3px;">L. {{ $quote->quote_type == 'G' ? '0.00':$quote->quote_total_amount }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. (X)</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ $quote->quote_type == 'G' ? number_format($quote->quote_total_amount - $quote->quote_isv_amount,2):'0.00' }}</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ $quote->quote_type == 'G' ? number_format($quote->quote_isv_amount,2):'0.00' }}</p>
                        <p style="font-size: 10pt; margin-top: -8px;">L. 0.00</p>
                        <p style="font-weight: bolder; font-size: 9.6pt; margin-top: -3px;">L. {{ number_format($quote->quote_total_amount,2) }}</p>
                        <div style="margin-top: 10px"></div>
                        <p style="font-size: 8.5pt; margin-top: -8px;">L. {{ number_format($quote->quote_discount,2) }}</p>
                    </td>
                    @endif
                </tr>
            </table>
        </div>
    </div>
    <span style="float: left; font-size: 8pt; margin-top: -16px; margin-left: 10px">
        Usuario: (X) | Impreso: {{ $dia }}/{{ $mes }}/{{ $anio }} {{ $hora }}:{{ $mins }}:{{ $seg }} | Origen: POS
    </span>
    <span style="float: right; font-size: 8pt; margin-top: -16px; margin-right: 20px">
        {{ config('app.name') }}
    </span>
</body>

</html>