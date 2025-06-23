<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formato de trabajo {{ config('app.name') }}</title>
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
            text-align: center;
            font-weight: bold;
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
            font-size: 8pt;
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
    </style>
</head>

<body>
    <div class="container">
        <header>
            <img style="float: right; top: 20px; right: 80px;" src="{{ 'storage/sys_config/img/' . $settings->logo_company ?? 'storage/assets/img/kaiadmin/favicon.png' }}" width="90" height="90">
            <div class="header-info">
                <p>OFICINA PRINCIPAL</p>
                <p>TEL: +504 2515-2685&nbsp;&nbsp;&nbsp;CEL: +504 3160-9917</p>
                <p>SAN PEDRO SULA, CORTES</p>
                <p>E-MAIL: gerenciahn@robenior.com</p>
            </div>
        </header>

        <form>
            <div class="field-group">
                <label>FECHA: </label>
                <span style="font-size: 11pt; color: gray; font-style: italic; font-family: 'Times New Roman', Times, serif; text-transform: uppercase; display: inline-block; width: 35%; text-align: center; border-bottom: 1px solid #000"></span>

                <!-- Divider -->
                <span style="display: inline-block; width: 2%;"></span>

                <label>HORA: </label>
                <span style="text-transform: uppercase; display: inline-block; width: 20%; text-align: center; border-bottom: 1px solid #000"></span>
            </div>

            <div class="field-group full-width">
                <label>CLIENTE:</label>
                <span style="display: inline-block; width: 55%; border-bottom: 1px solid #000"></span>

                <!-- Divider -->
                <span style="display: inline-block; width: 2%;"></span>

                <label>TEL:</label>
                <span style="display: inline-block; width: 26%; border-bottom: 1px solid #000"></span>
            </div>

            <div class="field-group full-width">
                <label>DIRECCIÓN:</label>
                <span style="display: inline-block; width: 87%; border-bottom: 1px solid #000"></span>
            </div>

            <div class="field-group">
                <label>TECNICO:</label>
                <span style="display: inline-block; width: 40%; border-bottom: 1px solid #000"></span>

                <!-- Divider -->
                <span style="display: inline-block; width: 2%;"></span>

                <label>FACTURA:</label>
                <span style="display: inline-block; width: 35%; border-bottom: 1px solid #000"></span>
            </div>

            <div class="field-group full-width">
                <p style="font-size: 11pt; font-weight: bold; margin-bottom: 25px">TIPO DE TRABAJO</p>

                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" id="orden-trabajo" style="vertical-align: middle;">
                    <label for="orden-trabajo" style="vertical-align: middle;">ORDEN TRABAJO</label>
                </div>
                <span style="display: inline-block; width: 2%;"></span>

                <div style="display: inline-block; vertical-align: middle; margin-left: 2.8%">
                    <input type="checkbox" id="estudio-campo" style="vertical-align: middle;">
                    <label for="estudio-campo" style="vertical-align: middle;">ESTUDIO CAMPO</label>
                </div>
                <span style="display: inline-block; width: 2%;"></span>

                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" id="revision-equipo" style="vertical-align: middle;">
                    <label for="revision-equipo" style="vertical-align: middle;">REVISIÓN EQUIPO</label>
                </div>
                <span style="display: inline-block; width: 2%;"></span>

                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" id="recepcion-equipo" style="vertical-align: middle;">
                    <label for="recepcion-equipo" style="vertical-align: middle;">RECEPCIÓN EQUIPO</label>
                </div>
                <span style="display: inline-block; width: 2%;"></span>

                <div style="display: inline-block; vertical-align: middle;">
                    <input type="checkbox" id="entrega-equipo" style="vertical-align: middle;">
                    <label for="entrega-equipo" style="vertical-align: middle;">ENTREGA EQUIPO</label>
                </div>
            </div>

            <br>
            <div class="field-group full-width">
                <textarea style="height: 300px; width: 94%; border: 2px solid #000; color: lightgray; font-size: 9pt; padding: 20px">COMENTARIOS:</textarea>
            </div>

            <div class="field-group full-width" style="text-align: center;">
                <span style="font-size: 8.5pt; font-weight: bold">
                    NOTA: TIEMPO DE RESPUESTA PARA ENTREGA DE EQUIPO SERÁ DE 48 A 72 HORAS HÁBILES, INICIANDO EN LA FECHA DE RECEPCIÓN DE EQUIPO POR PARTE DE ROBENIOR SYSTEM.
                </span>
            </div>

            <div class="field-group" style="margin-top: 15%;">
                <div style="margin-left: 5%; width: 90%; margin-right: 5%; ">
                    <div style="display: inline-block; width: 45%; margin-right: 5%;">
                        <span style="display: block; border-bottom: 1px solid #000; width: 100%;"></span>
                        <label style="text-align: center; display: block; margin-top: 5px;">FIRMA ROBENIOR SYSTEM</label>
                    </div>
                    <div style="display: inline-block; width: 45%;">
                        <span style="display: block; border-bottom: 1px solid #000; width: 100%;"></span>
                        <label style="text-align: center; display: block; margin-top: 5px;">FIRMA CLIENTE</label>
                    </div>
                </div>
            </div>

        </form>
    </div>
</body>

</html>