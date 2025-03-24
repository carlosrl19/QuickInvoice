<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>#SC-{{ $loan->loan_code_number }}</title>
</head>

<body>
	<style>
		.container {
			max-width: 800px;
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
		}

		.subtitle {
			font-size: 14px;
			font-weight: bold;
			opacity: 1;
		}

		.subtitle_sm {
			font-size: 8pt;
		}

		.text_sm {
			font-size: 10pt;
		}

		.text_bold {
			font-weight: bold;
		}

		.header {
			text-align: center;
			margin-bottom: 40px;
			line-height: 1.1em;
		}

		.header img {
			width: 64px;
			height: 64px;
		}

		.mt-2 {
			margin-top: 20px;
		}

		.ml-100 {
			margin-left: 100px;
		}

		.ml-70 {
			margin-left: 70px;
		}

		.ml-150 {
			margin-left: 180px;
		}

		.ml-140 {
			margin-left: 140px;
		}

		/* Estilo general de la tabla */
		.table {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
		}

		/* Estilo para las celdas de la tabla */
		.table th,
		.table td {
			border: none;
			text-align: center;
			padding: 8px;
			font-size: 9pt;
		}

		/* Estilo para las cabeceras de la tabla */
		.table th {
			background-color: #f2f2f2;
			font-weight: bold;
		}

		/* Estilo para filas alternas */
		.table tr:nth-child(even) {
			background-color: #f9f9f9;
		}

		/* Estilo general de la tabla */
		.table_signatures {
			width: 100%;
			border-collapse: collapse;
			margin: 20px 0;
			font-size: 10pt;
		}

		/* Estilo para las celdas de la tabla */
		.table_signatures th,
		.table_signatures td {
			border: none;
			text-align: center;
			padding: 8px;
			font-size: 10pt;
		}

		/* Estilo para las cabeceras de la tabla */
		.table_signatures th {
			background-color: #fff;
			font-weight: bold;
		}

		/* Estilo para filas alternas */
		.table_signatures tr:nth-child(even) {
			background-color: #fff;
		}

		.font_8_italic {
			font-style: italic;
			font-size: 8pt;
		}

		.font_8 {
			font-size: 8pt;
		}

		.font_12 {
			font-size: 12pt;
		}
	</style>

	<div class="container">
		<div class="header">
			<img src="../public/storage/static/logo-rounded.png" width="120" height="94">
			<br /><br />
			<span class="subtitle">INVERSIONES ROBENIOR</span><br />
			<span class="subtitle_sm">Bº RIO DE PIEDRAS, 21 AVE, 5 CALLE, SAN PEDRO SULA, CORTES</span><br />
			<span class="subtitle_sm">TEL.: 2510-6118 | CORREO: contabilidad@robenior.com | R.T.N.: 08011999074695</span><br />
		</div>

		<div>
			<div>
				<span class="text_sm">Fecha creado:&nbsp;{{ $loan->created_at }}</span> <br />
				<span class="text_sm">Cliente:&nbsp;<strong>{{ $loan->client->client_name }}</strong></span> <br />
				<span class="text_sm">Doc.:&nbsp;<strong>{{ $loan->client->client_document }}</strong></span> <br />
				<span class="text_sm">Dirección:&nbsp;{{ $loan->client->client_address }}</span> <br />
			</div>

			<div class="mt-2">
				<span class="text_sm">Monto:&nbsp;L. {{ number_format($loan->loan_amount,2) }} ({{ number_format($loan->loan_interest,0)}}%)</span> <br />
				<span class="text_sm">Prima:&nbsp;L. {{ number_format($loan->loan_down_payment,2) }}</span> <br />
				<span class="text_sm">Monto a financiar:&nbsp;L. {{ number_format($loan->loan_total,2) }}</span> <br />
				@if($loan->loan_payment_type == 1)
				<span class="text_sm">Frecuencia de pago:&nbsp;&nbsp;</span><span class="text_sm text_bold">DIARIO</span>
				@elseif($loan->loan_payment_type == 2)
				<span class="text_sm">Frecuencia de pago:&nbsp;&nbsp;</span><span class="text_sm text_bold">SEMANAL</span>
				@elseif($loan->loan_payment_type == 3)
				<span class="text_sm">Frecuencia de pago:&nbsp;&nbsp;</span><span class="text_sm text_bold">QUINCENAL</span>
				@else
				<span class="text_sm">Frecuencia de pago:&nbsp;&nbsp;</span><span class="text_sm text_bold">MENSUAL</span>
				@endif
			</div>

			<div class="mt-2">
				<span class="text_sm">Plazo:&nbsp;{{ $loan->loan_quote_number }}
					@if($loan->loan_payment_type == 1)
					<span class="text_sm"> días</span>
					@elseif($loan->loan_payment_type == 2)
					<span class="text_sm"> semanas</span>
					@elseif($loan->loan_payment_type == 3)
					<span class="text_sm"> quincenas</span>
					@else
					<span class="text_sm"> meses</span>
					@endif
				</span> <br />
				<span class="text_sm">Cuota: L. {{ number_format($loan->loan_quote_value,2) }}</span> <br />
				<span class="text_sm">Nº cuotas: {{ $loan->loan_quote_number }}</span> <br />
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>DESCRIPCION</th>
					<th>SERIE #</th>
					<th>CANTIDAD</th>
					<th>PRECIO</th>
					<th>INTERESES</th>
					<th>TOTAL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $loan->loan_description }}</td>
					<td>N/A</td>
					<td>1</td>
					<td>{{ number_format($loan->loan_amount,2) }}</td>
					<td>{{ number_format($loan->loan_interest,0) }}%</td>
					<td>{{ number_format($loan->loan_total,2) }}</td>
				</tr>
				<tr>
					<td colspan="6">--- ULTIMA LÍNEA ---</td>
				</tr>
				<tr class="text_bold">
					<td>SUBTOTAL: {{ number_format($loan->loan_total,2) }}</td>
					<td></td>
					<td></td>
					<td></td>
					<td>TOTAL:</td>
					<td>{{ number_format($loan->loan_total,2) }}</td>
				</tr>
			</tbody>
		</table>

		<table class="table_signatures">
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Creado por:</td>
					<td>Aprobado por:</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>__________________________________________</td>
					<td>__________________________________________</td>
				</tr>
				<tr>
					<td>Nombre y firma</td>
					<td>Nombre y firma</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>__________________________________________</td>
				</tr>
				<tr>
					<td></td>
					<td>Lugar y fecha</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>

</html>