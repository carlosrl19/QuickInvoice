<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consignación de producto #{{ $consignment->consignment_code }}</title>
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
            <span style="float: right; font-weight: bold; font-size: 10pt; margin-top: -30px">#CN-{{ $consignment->consignment_code }}</span>
        </header>

        <h4 style="text-align: center;">CONSIGNACIÓN DE PRODUCTO POR L. {{ number_format($consignment->consignment_amount,2) }}</h4>

        <div class="main">
            <strong>INVERSIONES ROBENIOR</strong>, con domicilio en San Pedro Sula, Cortés, en calidad de remitente, y <strong>{{ $consignment->person_name }}</strong>, identificado con número de identificación <strong>{{ $consignment->person_dni }}</strong>, con domicilio en {{ $consignment->person_address }} y teléfono <strong>{{ $consignment->person_phone }}</strong>, actuando como destinatario.

            <p>Por medio del presente documento, se detallan los siguientes productos:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <thead>
                    <tr style="background-color: #27548A; color: white">
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Cantidad</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Producto</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Estado</th>
                        <th style="border: 1px solid #ccc; padding: 8px; text-align: center;">Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($consignment_details as $detail)
                    @php $total += $detail->total_price; @endphp
                    <tr>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">{{ $detail->quantity }}</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px;">{{ $detail->product->product_brand }} {{ $detail->product->product_model }} - {{ $detail->product->product_name }}</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">
                            {{
                                $detail->product->product_status == 1 ? 'NUEVO' : 
                                ($detail->product->product_status == 2 ? 'SEMINUEVO' : 
                                ($detail->product->product_status == 3 ? 'USADO' : 
                                ($detail->product->product_status == 0 ? 'MALO' : 'DESCONOCIDO')))
                            }}
                        </td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center;">L. {{ number_format($detail->product->product_price,2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center; font-weight: bold;" colspan="3">TOTAL A PAGAR</td>
                        <td style="font-size: 8pt; border: 1px solid #ccc; padding: 8px; text-align: center; font-weight: bold;">L. {{ number_format($total,2) }}</td>
                    </tr>
                </tfoot>
            </table>
            <p> El receptor acepta los bienes exclusivamente para su exhibición y comercialización, comprometiéndose a custodiar y mantenerlos en buen estado, así como a informar al remitente sobre cualquier venta realizada. La propiedad de los productos permanecerá con el primero hasta que se concrete la venta al cliente final. </p>
            <p> En caso de venta, el receptor entregará al remitente el importe acordado, descontando la comisión previamente pactada entre ambas partes. Si los productos no se venden dentro del plazo establecido, el receptor se obliga a devolverlos en las mismas condiciones en que fueron recibidos, salvo el desgaste natural por exhibición. </p>
            <p> Ambas partes manifiestan su conformidad con los términos aquí establecidos y firman el presente documento en señal de aceptación. </p>
            <br>
            <br>

            <div style="display: flex; justify-content: center; text-align: center; margin-top: 35px;  width: 100%;">
                <strong style="margin-right: 25px;">___________________________</strong>
                <strong style="margin-left: 25px;">___________________________</strong>
            </div>

            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 5px;  width: 100%;">
                <strong style="margin-right: 100px;">Firma consignatario</strong>
                <strong style="margin-left: 25px;">Huella consignatario</strong>
            </div>

            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 50px;  width: 100%;">
                <strong>________________________</strong>
            </div>

            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 5px;  width: 100%;">
                <strong>Firma consignador</strong>
            </div>
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<body>
    <div class="container-2">
        <!-- Code container -->
        <div style="float: right">
            <span style="font-size: 10pt !important; font-weight: bold">#PG-{{ $consignment->consignment_code }}</span>
        </div>

        <!-- Promissory note title -->
        <h4 style="text-decoration: underline; text-align: center; margin-top: 80px">PAGARE L. {{ number_format($consignment->consignment_amount,2)}}</h4>

        <!-- Promissory note body -->
        <div style="font-size: 11pt; line-height: 1.8;">Yo: <strong class="text-uppercase text-underline">{{ $consignment->person_name }}</strong>, mayor de
            edad, con documento Nacional de identificación número <strong class="text-underline">{{ $consignment->person_dni }}</strong>, y domicilio en <strong class="text-underline">{{ $consignment->person_address }}</strong>
            <strong>PAGARÉ INCONDICIONALMENTE</strong> la cantidad de <strong class="text-underline">{{$amountLetras}} EXACTO</strong>
            (<strong class="text-underline">L. {{ number_format($consignment->consignment_amount, 2) }}</strong>)
            a favor de <strong class="text-underline">JUNIOR ALEXIS AYALA GUERRERO</strong>, mayor de edad, hondureño, soltero y
            comerciante, con documento Nacional de identificación número <strong class="text-underline">0801199907469</strong>,
            con domicilio en la ciudad de San Pedro Sula, departamento de Cortés, Honduras.

            En fe de lo anterior, firmo el presente <strong>PAGARÉ</strong> en la ciudad de San Pedro Sula, del departamento de Cortés a los a los {{ $dia }} días del mes de {{ $mes }} del año {{ $anio }}.
        </div>
        <br>

        <!-- Promissory note signature -->
        <div style="text-align: center; line-height: 1.8;">
            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 35px;  width: 100%;">
                <strong style="margin-right: 25px;">___________________________</strong>
                <strong style="margin-left: 25px;">___________________________</strong>
            </div>

            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 5px;  width: 100%;">
                <strong style="margin-right: 100px;">Firma consignatario</strong>
                <strong style="margin-left: 25px;">Huella consignatario</strong>
            </div>
            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 80px;  width: 100%;">
                <strong>________________________</strong>
            </div>

            <div style="display: flex;  justify-content: center; text-align: center; margin-top: 5px;  width: 100%;">
                &nbsp;&nbsp;
                <img style="position: absolute; margin-top: -71px; margin-left: 220px; transform: scale(1.4)" src="{{ 'storage/sys_config/img/firma.png' ?? 'storage/assets/img/kaiadmin/favicon.png' }}" height="80px">
                <img style="position: absolute; margin-top: -80px; margin-left: 380px; transform: scale(1.3)" src="{{ 'storage/sys_config/img/sello.png' ?? 'storage/assets/img/kaiadmin/favicon.png' }}" height="80px">
                <strong>Firma consignador</strong>
            </div>
        </div>
    </div>
</body>

</html>