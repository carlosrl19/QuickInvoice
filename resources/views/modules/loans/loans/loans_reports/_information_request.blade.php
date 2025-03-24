<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<title>#SC-{{ $loan->loan_code_number }}</title>

	<style>
		body {
			font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
			margin: 0;
			padding: 0;
		}

		.divider {
			width: 100%;
			height: 1px;
			background-color: #ddd;
			margin: 10px 0;
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
			margin-bottom: 10px;
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
			font-size: 11pt;
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
			font-weight: bold;
			font-size: 8pt;
		}

		tr.item td {
			border-bottom: 1px solid #eee;
			font-size: 8pt;
			text-align: center;
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
			<span class="subtitle">INVERSIONES ROBENIOR</span>
			<div class="divider"></div>
			<span class="subtitle">Solicitud de crédito # {{ $loan->loan_request_number }}</span>
		</div>

		<div class="information">
			<div style="width: 80%;">
				<span class="text_header_sm">Estado:
					<strong>
						@if($loan->loan_request_status == 0)
						Solicitud en espera
						@elseif($loan->loan_request_status == 1)
						Solicitud aceptada
						@elseif($loan->loan_request_status == 2)
						Solicitud rechazada
						@else
						(?)
						@endif
					</strong>
				</span><br>
				<span class="text_header_sm">Fecha creado: {{ Carbon\Carbon::parse($loan->created_at)->format('d/m/Y') }}</span>
				<div style="height: 5px;"></div>
				<span class="text_header_sm">Cliente: <strong>{{ $loan->client->client_name }}</strong></span><br>
				<span class="text_header_sm">Identificación: {{ $loan->client->client_document }}</span><br>
				<span class="text_header_sm">Dirección: {{ $loan->client->client_address ? $loan->client->client_address : 'N/A' }}</span><br>
				<span class="text_header_sm">Teléfono: {{ $loan->client->client_phone1 }}</span><br>
			</div>

			<div class="divider"></div>

			<div style="width: 100%;">
				<div style="width: 48%; display: inline-block; vertical-align: top;">
					<!-- Contenido del primer div -->
					<span class="text_header_sm">Monto del crédito: {{ number_format($loan->loan_total,2) }}</span><br />
					<span class="text_header_sm">Prima: {{ number_format($loan->loan_bonus_payment,2) }}</span><br />
					<span class="text_header_sm"><strong>Monto a financiar: {{ number_format($loan->loan_total,2) }}</strong></span><br />
					<span class="text_header_sm">Frecuencia de pago:
						@if($loan->loan_payment_type == 1)
						<span class="text_header_sm"> DIARIO</span>
						@elseif($loan->loan_payment_type == 2)
						<span class="text_header_sm"> SEMANAL</span>
						@elseif($loan->loan_payment_type == 3)
						<span class="text_header_sm"> QUINCENAL</span>
						@else
						<span class="text_header_sm"> MENSUAL</span>
						@endif
					</span><br>
					<span class="text_header_sm">Plazo:&nbsp;{{ $loan->loan_quote_number }}
						@if($loan->loan_payment_type == 1)
						<span class="text_header_sm"> {{ $loan->loan_quota_number <= 1 ? 'día':'días' }}</span>
						@elseif($loan->loan_payment_type == 2)
						<span class="text_header_sm"> {{ $loan->loan_quota_number <= 1 ? 'semana':'semanas' }}</span>
						@elseif($loan->loan_payment_type == 3)
						<span class="text_header_sm"> {{ $loan->loan_quota_number <= 1 ? 'quincena':'quincenas' }}</span>
						@else
						<span class="text_header_sm"> {{ $loan->loan_quota_number <= 1 ? 'mes':'meses' }}</span>
						@endif
					</span><br>
				</div>

				<div style="width: 48%; display: inline-block; vertical-align: top;">
					<!-- Contenido del segundo div -->
					<span class="text_header_sm">Cuota: {{ number_format($loan->loan_quote_value,2) }}</span><br />
					<span class="text_header_sm">Número cuotas: {{ $loan->loan_quote_number }}</span><br />
					<span class="text_header_sm">Tasa mora: (X)</span><br />
					<span class="text_header_sm">Vendedor: {{ $loan->seller->seller_name }}</span><br />
				</div>
			</div>
		</div>

		<div class="divider"></div>
		<p style="margin-top: -5px;">Productos</p>

		<table>
			<thead>
				<tr>
					<th style="text-align: left;">Producto / Código</th>
					<th>Serie #</th>
					<th>Cantidad</th>
					<th>Precio</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align: left; font-size: 8pt !important;">{{ $loan->loan_description }}</td>
					<td style="font-size: 8pt !important; color: lightgray">N/A</td>
					<td style="font-size: 8pt !important;">1</td>
					<td style="font-size: 8pt !important;">{{ $loan->loan_total }}</td>
					<td style="font-size: 8pt !important;">{{ $loan->loan_total }}</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5"></td>
				</tr>
				<tr>
					<td style="text-align: left; font-size: 10pt !important; background-color: #d1eef6;">Sub-total <strong>{{ number_format($loan->loan_total,2) }}</strong></td>
					<td colspan="2" style="text-align: left; font-size: 10pt !important; background-color: #d1eef6;">ISV <strong>{{ number_format($loan->loan_interest,2) }}</strong></td>
					<td colspan="2" style="text-align: left; font-size: 10pt !important; background-color: #d1eef6;">Total <strong>{{ number_format($loan->loan_total,2) }}</strong></td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>

</html>