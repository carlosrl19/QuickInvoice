<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>#SC-{{ $loan->loan_code }}</title>

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
			<img src="../public/storage/static/logo-rounded.png" width="64" height="64">
			<br /><br />
			<span class="subtitle">INVERSIONES ROBENIOR</span><br />
			<span class="text_header_sm">Bº RIO DE PIEDRAS, 21 AVE, 5 CALLE, SAN PEDRO SULA, CORTES</span><br />
			<span class="text_header_sm">TEL.: 2510-6118 | CORREO: contabilidad@robenior.com | R.T.N.: 08011999074695</span><br />
		</div>

		<div class="information">
			<div>
				<strong>LUGAR Y FECHA:</strong><br />
				<span class="text_header_sm"> SAN PEDRO SULA, CORTÉS, HONDURAS</span><br />
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
			</div>
		</div>

		<div>
			<strong class="subtitle_2">HISTORIAL DE PAGOS - PRESTAMO #{{ $loan->loan_code }}</strong> <br />
		</div>

		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>FECHA PAGO</th>
					<th>DEUDA</th>
					<th>MONTO PAGADO</th>
					<th>TIPO PAGO</th>
					<th>RESTANTE</th>
				</tr>
			</thead>

			<tbody>
				@forelse($loan_payments as $i => $loan_payment)
				<tr class="item">
					<td>{{ $i + 1 }}</td>
					<td>
						@php
						$loan_payment_date = $loan_payment->loan_payment_date;
						@endphp

						{{ $loan_payment_date = Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d') }}
					</td>
					<td>L {{ number_format($loan_payment->loan_old_debt,2) }}</td>
					<td>L. {{ number_format($loan_payment->loan_payment_amount,2) }}</td>
					<td>
						@if( $loan_payment->loan_payment_type == 0)
						<span>NORMAL</span>
						@elseif( $loan_payment->loan_payment_type == 1)
						<span>ABONO</span>
						@else
						<span>FINALIZACIÓN</span>
						@endif
					</td>
					<td>
						L. {{ number_format($loan_payment->loan_new_debt,2) }}
					</td>
				</tr>
				@empty
				<tr class="item text-center">
					<td colspan="6">SIN PAGOS ACREDITADOS A ESTE PRESTAMO.</td>
				</tr>
				@endforelse
			</tbody>
			<tfoot>
				<tr class="item_footer">
					<td>---</td>
					<td>---</td>
					<td>---</td>
					<td>---</td>
					<td><strong>DEUDA</strong></td>
					<td><strong>L. {{ number_format($actual_debt,2) }}</strong></td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>

</html>