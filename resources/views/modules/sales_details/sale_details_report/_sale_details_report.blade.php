<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida de producto #{{ $sale->sale_doc_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            display: flex;
            width: 100%;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 95%;
            background: #fff;
            line-height: 1.6;
        }

        .container-2 {
            margin-top: 5%;
            width: 95%;
            background: #fff;
        }

        .main {
            font-size: 10pt;
        }

        header {
            display: flex;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-info {
            font-size: 10pt;
            line-height: 0.5;
            width: 48%;
            text-align: left;
        }

        h1 {
            text-align: center;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        .field-group {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .field-group label {
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
        }


        .field-group input[type="text"],
        .field-group textarea {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .full-width input[type="text"],
        .full-width textarea {
            width: calc(100% - 130px);
        }

        textarea {
            resize: none;
        }

        .note {
            font-size: 12px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
            margin-top: 20px;
        }

        .text-underline {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img style="width: 80px; height: auto; float: right; top: 20px; right: 80px; opacity: 0.9;" src="{{ 'storage/sys_config/img/' . $settings->logo_company ?? 'storage/assets/img/kaiadmin/favicon.png' }}">
            <div class="header-info">
                <p>Casa matriz: SAN PEDRO SULA, HONDURAS</p>
                <p>Tel: {{ $settings->company_phone }}</p>
                <p>Oficina principal</p>
                <p>San Pedro Sula, Cortés</p>
                <p>e-mail: {{ $settings->company_email }}</p>
            </div>
            <span style="float: right; font-weight: bold; font-size: 10pt; margin-top: -30px">#SI-{{ $sale->sale_doc_number }}</span>
        </header>

        <h4 style="text-align: center;">SALIDA DE PRODUCTO POR L. {{ number_format($sale->sale_total_amount,2) }}</h4>

        <div class="main">
            <strong>INVERSIONES ROBENIOR</strong>, con domicilio en San Pedro Sula, Cortés, en calidad de remitente, y <strong style="text-transform: uppercase;">{{ $sale->user->name }}</strong>, identificado con número de identificación <strong>{{ $sale->user->user_dni }}</strong>, con domicilio en {{ $sale->user->user_address }} y teléfono <strong>{{ $sale->user->user_phone }}</strong>, quien asume la responsabilidad y el cargo de encargado de la salida del inventario correspondiente a los productos detallados en este documento.

            <p>Por medio del presente documento, se detallan los siguientes productos:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #C83F12; color: white">
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Cantidad</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Marca / Modelo / Producto</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Estado</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Precio</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($sale_details as $sale_detail)
                    @php $total += $sale_detail->sale_subtotal; @endphp
                    <tr>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $sale_detail->product_quantity }}</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px;">{{ $sale_detail->products->product_brand }} / MODELO {{ $sale_detail->products->product_model }} / {{ $sale_detail->products->product_name }}</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">
                            {{
                                $sale_detail->products->product_status == 1 ? 'NUEVO' : 
                                ($sale_detail->products->product_status == 2 ? 'SEMINUEVO' : 
                                ($sale_detail->products->product_status == 3 ? 'USADO' : 
                                ($sale_detail->products->product_status == 0 ? 'MALO' : 'DESCONOCIDO')))
                            }}
                        </td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">L. {{ number_format($sale_detail->products->product_price,2) }}</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">L. {{ number_format($sale_detail->products->product_price * $sale_detail->product_quantity,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center; font-weight: bold;" colspan="4">TOTAL FINAL</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center; font-weight: bold;">L. {{ number_format($total,2) }}</td>
                    </tr>
                </tfoot>
            </table>
            <p>El encargado asume plena responsabilidad por la correcta gestión, custodia y manejo de los productos que han salido del inventario, comprometiéndose a cumplir con los procedimientos internos y a reportar cualquier incidencia relacionada con esta salida.</p>
            <p>Ambas partes manifiestan su conformidad con los términos aquí establecidos y firman el presente documento en señal de aceptación.</p>
            <br>
            <br>

            <table style="width: 100%; margin-top: 35px;">
                <tr>
                    <td style="width: 50%; text-align: center; vertical-align: bottom;">
                        <div style="border-top: 1.5px solid #222; width: 240px; margin: 0 auto 5px auto;"></div>
                        <div style="font-weight: bold;">Firma y huella responsable</div>
                    </td>
                    <td style="width: 50%; text-align: center; vertical-align: bottom;">
                        <img style="position: absolute; margin-top: -71px; margin-left: 70px; transform: scale(1.4)" src="{{ 'storage/sys_config/img/firma.png' ?? 'storage/assets/img/kaiadmin/favicon.png' }}" height="80px">
                        <img style="position: absolute; margin-top: -80px; margin-left: 180px; transform: scale(1.3)" src="{{ 'storage/sys_config/img/sello.png' ?? 'storage/assets/img/kaiadmin/favicon.png' }}" height="80px">
                        <div style="border-top: 1.5px solid #222; width: 200px; margin: 0 auto 5px auto;"></div>
                        <div style="font-weight: bold;">Firma ROBENIOR SYSTEM</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>