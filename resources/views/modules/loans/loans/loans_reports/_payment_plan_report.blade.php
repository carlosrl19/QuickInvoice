<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>#PP-{{ $loan->loan_code_number }}</title>

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

		th,
		td {
			padding: 8px;
			text-align: center;
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
			<!-- Imagen posicionada a la derecha -->
			<div style="position: absolute; top: 0; right: 230; opacity: 0.8;">
				<img src="{{ 'storage/sys_config/img/' . $settings->logo_company ?? 'storage/assets/img/kaiadmin/favicon.png' }}" alt="" style="min-width: 90px; min-height: 90px; max-width: 180px; max-height: 100px" />
			</div><br>
			<p style="margin-top: 60px; margin-bottom: -2px;" class="subtitle">{{ $settings->company_name ?? 'Nombre empresa' }}</p>
			<span class="text_header_sm">{{ $settings->company_address ?? 'Dirección empresa' }}</span><br />
			<span class="text_header_sm">TEL.: {{ $settings->company_phone ?? 'Teléfono empresa' }} | CORREO: {{ $settings->company_email ?? 'Email empresa' }} | R.T.N.: {{ $settings->company_rtn ?? 'R.T.N. Empresa' }}</span><br />
		</div>

		<div class="information">
			<div>
				<strong>LUGAR Y FECHA:</strong><br />
				<span class="text_header_sm"> {{ $settings->company_short_address ?? 'Dirección corta empresa' }}</span><br />
				<span class="text_header_sm">{{ $loan->created_at }}</span>
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
			</div>
		</div>

		<div>
			<strong class="subtitle_2">PLAN DE PAGOS - PRESTAMO #{{ $loan->loan_code_number }}</strong> <br />
		</div>

		@php
		$loan_start_date = new DateTime($loan->loan_start_date);
		$loan_payment_type = $loan->loan_payment_type;
		$loan_quote_number = $loan->loan_quote_number;
		$loan_quote_value = $loan->loan_quote_value;
		$loan_total = $loan->loan_total;

		// Inicializamos un array para almacenar las fechas de pago
		$payment_dates = [];

		// Calculamos las fechas de pago
		for ($i = 0; $i < $loan_quote_number; $i++) {
			switch ($loan_payment_type) {
			case 1: // Diario
			$payment_dates[]=$loan_start_date->modify('+1 day')->format('d-m-Y');
			break;
			case 2: // Semanal
			$payment_dates[] = $loan_start_date->modify('+7 days')->format('d-m-Y');
			break;
			case 3: // Quincenal
			$payment_dates[] = $loan_start_date->modify('+15 days')->format('d-m-Y');
			break;
			case 4: // Mensual
			$payment_dates[] = $loan_start_date->modify('+1 month')->format('d-m-Y');
			break;
			}
			}
			@endphp

			<table>
				<thead>
					<tr>
						<th>#</th>
						<th>FECHA PAGO</th>
						<th>CAPITAL</th>
						<th>INT. CORRIENTE</th>
						<th>INT. MORA</th>
						<th>TOTAL CUOTA</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($payment_dates as $index => $date)
					<tr class="item">
						<td>{{ $index + 1 }}</td>
						<td>{{ $date }}</td>
						<td>{{ number_format($loan_quote_value,2) }}</td>
						<td>0.00</td>
						<td>0.00</td>
						<td>{{ number_format($loan_quote_value,2) }}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr class="item_footer">
						<td>---</td>
						<td><strong>TOTALES</strong></td>
						<td>{{ number_format($loan_total,2)}}</td>
						<td>---</td>
						<td>---</td>
						<td>{{ number_format($loan_total,2)}}</td>
					</tr>
				</tfoot>
			</table>
	</div>
</body>

</html>