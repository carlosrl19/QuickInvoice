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

		tr.item_footer td {
			font-size: 8pt;
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
			<span class="subtitle">{{ $settings->company_name ?? 'Nombre empresa' }}</span>
			<div class="divider"></div>
			<span class="subtitle">Estado de cuenta # {{ $loan->loan_code_number }}</span>
		</div>

		<div class="information">
			<div style="width: 80%;">
				<span class="text_header_sm">Estado:
					<strong>
						@if($loan->loan_status == 1)
						En proceso
						@elseif($loan->loan_status == 2)
						Cancelado
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

			<br>

			<div style="width: 100%;">
				<div style="width: 48%; display: inline-block; vertical-align: top;">
					<!-- Contenido del primer div -->
					<span class="text_header_sm">Monto del crédito: {{ number_format($loan->loan_total,2) }}</span><br />
					<span class="text_header_sm">Prima: {{ number_format($loan->loan_bonus_payment,2) }}</span><br />
					<span class="text_header_sm"><strong>Monto a financiar: {{ number_format($loan->loan_total,2) }}</strong></span><br />
					<span class="text_header_sm"><strong>Cuotas mora: (X)</strong></span><br />
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
					<span class="text_header_sm">Tipo de amortización: (X)</span><br />
					<span class="text_header_sm">Taza de interes corriente: (X)</span><br />
					<span class="text_header_sm">Taza mora: (X)</span><br />
				</div>

				<div style="width: 48%; display: inline-block; vertical-align: top;">
					<!-- Contenido del segundo div -->
					<span class="text_header_sm">Plazo:&nbsp;{{ $loan->loan_quote_number }}
						@if($loan->loan_payment_type == 1)
						<span class="text_header_sm"> {{ $loan->loan_quote_number == 1 ? 'día':'días' }}</span>
						@elseif($loan->loan_payment_type == 2)
						<span class="text_header_sm"> {{ $loan->loan_quote_number == 1 ? 'semana':'semanas' }}</span>
						@elseif($loan->loan_payment_type == 3)
						<span class="text_header_sm"> {{ $loan->loan_quote_number == 1 ? 'quincena':'quincenas' }}</span>
						@elseif($loan->loan_payment_type == 4)
						<span class="text_header_sm"> {{ $loan->loan_quote_number == 1 ? 'mes':'meses' }}</span>
						@else
						<span class="text_header_sm"> (?)</span>
						@endif
					</span><br>

					<span class="text_header_sm">Cuota: {{ number_format($loan->loan_quote_value,2) }}</span><br />
					<span class="text_header_sm">Número cuotas: {{ $loan->loan_quote_number }}</span><br />
					<span class="text_header_sm">Vendedor: {{ $loan->seller->seller_name }}</span><br />
					<span class="text_header_sm">Gestor cobros: </span><br />
					<span class="text_header_sm"><strong>Abonos: {{ number_format($loan_payment_amount_sum = DB::table('loan_payments')->where('loan_id', $loan->id)->where('loan_quote_payment_status', 1)->sum('loan_quote_payment_amount'),2) }}</strong></span><br />
					<span class="text_header_sm"><strong>Saldo: {{ number_format($loan->loan_total - $loan_payment_amount_sum,2) }}</strong></span><br />
					<span class="text_header_sm"><strong>Monto pendiente: {{ number_format($loan->loan_total - $loan_payment_amount_sum,2) }}</strong></span>
				</div>
			</div>
		</div>

		<div class="divider"></div>
		<p style="margin-top: -5px;">Historial de pagos</p>

		<table>
			<thead>
				<tr>
					<th>Fecha pagado</th>
					<th>Tipo Oper.</th>
					<th>Capital</th>
					<th>Int. Corr.</th>
					<th>Int. Mora</th>
					<th>Total Pag.</th>
					<th>Usuario</th>
					<th>Estado</th>
					<th>Ref.</th>
				</tr>
			</thead>

			<tbody>
				@forelse($loan_payments as $loan_payment)
				<tr class="item">
					<td>
						{{ Carbon\Carbon::parse($loan_payment->loan_quote_payment_date)->format('d-m-Y') }}<br>
					</td>
					<td>
						PAG
					</td>
					<td>{{ number_format($loan_payment->loan_quote_payment_amount,2) }}</td>
					<td>0.00</td>
					<td>0.00</td>
					<td>{{ $loan_payment->loan_quote_payment_status == 1 ? $loan_payment->loan_quote_payment_received : '0.00' }}</td>
					<td>(X)</td>
					<td>
						{{ $loan_payment->loan_quote_payment_status == 1 ? 'PAGADO' : ($loan_payment->loan_quote_payment_status == 0 ? 'PENDIENTE' : 'MORA') }}
					</td>
					<td>{{ $loan_payment->loan_quote_payment_doc_number }}</td>
				</tr>
				@empty
				<tr class="item text-center">
					<td colspan="9">Sin pagos acreditados a este préstamo.</td>
				</tr>
				@endforelse
			</tbody>
			<tfoot>
				<tr class="item_footer">
					<td>---</td>
					<td>---</td>
					<td>{{ number_format($loan_payments_sum,2) }}</td>
					<td>(X)</td>
					<td>(X)</td>
					<td>{{ number_format($loan_payments_paid_sum,2) }}</td>
					<td>(X)</td>
					<td>---</td>
					<td>---</td>
				</tr>
			</tfoot>
		</table>
	</div>
</body>

</html>