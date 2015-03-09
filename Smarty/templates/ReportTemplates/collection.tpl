<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
{include file='ReportTemplates/header.tpl'}
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-3">
			</div>
			<div class="col-xs-6">
				<h2 class="text-center"> Collection </h2>
			</div>
			<div class="col-xs-3">
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				{include file='ReportTemplates/logo.tpl'}
			</div>
			<div class="col-xs-6">
				<table class="table">
				<tr>
					<th colspan=3> Summary - {$CDATE}</th>
				</tr>
				{if $DATA.summary.Cash_on_hand }
					<tr> <th colspan=3>Cash Transaction </th></tr>
					<tr>
						<td> &nbsp;</td>
						<th> Collection: </th>
						<td> {$DATA.summary.Cash_on_hand.payment}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> EWT: </th>
						<td> {$DATA.summary.Cash_on_hand.awt}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> Bank Charge: </th>
						<td> {$DATA.summary.Cash_on_hand.bc}</td>
					</tr>
				{/if}

				{if $DATA.summary.Check }
					<tr> <th colspan=3>Check Transaction </th></tr>
					<tr>
						<td> &nbsp;</td>
						<th> Collection: </th>
						<td> {$DATA.summary.Check.payment}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> EWT: </th>
						<td> {$DATA.summary.Check.awt}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> Bank Charge: </th>
						<td> {$DATA.summary.Check.bc}</td>
					</tr>
				{/if}

				{if $DATA.summary.Cash_online }
					<tr> <th colspan=3>Cash online Transaction </th></tr>
					<tr>
						<td> &nbsp;</td>
						<th> Collection: </th>
						<td> {$DATA.summary.Cash_online.payment}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> EWT: </th>
						<td> {$DATA.summary.Cash_online.awt}</td>
					</tr>
					<tr>
						<td> &nbsp;</td>
						<th> Bank Charge: </th>
						<td> {$DATA.summary.Cash_online.bc}</td>
					</tr>
				{/if}
				<tr>
					<th colspan=2> Total Collection: </th>
					<th>{$DATA.summary.Summary.payment}</th>
				</tr>

				</table>
			</div>
			<div class="col-xs-12">
			{if $DATA.summary.Cash_on_hand }
					<h3>Cash Transactions</h3>
					{foreach key=CollectionNo item=ARS from=$DATA.summary.Cash_on_hand.details}
								{assign var=subtotal value=$ARS.detail.total}
								{assign var=subPayment value=$ARS.detail.payment}
								{assign var=subAwt value=$ARS.detail.awt}
								{assign var=subBc value=$ARS.detail.bc}
								<table class="table table-striped">
									<tr>
										<th colspan=1> {$CollectionNo} </th>
									</tr>
									<tr>
										<th> Sales No.</td>
										<th> Payment </td>
										<th> EWT </td>
										<th> Bank Charge </td>
										<th> Total </td>
									</tr>
								{foreach key=ID item=AR from=$ARS.lists}
									{assign var=sa_no_ value=$AR.sa_no_}
									{assign var=payment value=$AR.payment}
									{assign var=awt value=$AR.awt}
									{assign var=bc value=$AR.bc}
									{assign var=total value=$AR.total}
									<tr>
										<td> {$sa_no_}</td>
										<td> {$payment}</td>
										<td> {$awt}</td>
										<td> {$bc}</td>
										<td> {$total}</td>
									</tr>
								{/foreach}
								<tr>
									<th style="text-align:right" > Sub Total: </th>
									<th> {$subPayment} </th>
									<th> {$subAwt} </th>
									<th> {$subBc} </th>
									<th> {$subtotal} </th>
								</tr>
								</table>
					{/foreach}
			{/if}

			{if $DATA.summary.Check }
				<h3>Check Transactions</h3>
					{foreach key=CollectionNo item=ARS from=$DATA.summary.Check.details}
								{assign var=subtotal value=$ARS.detail.total}
								{assign var=subPayment value=$ARS.detail.payment}
								{assign var=subAwt value=$ARS.detail.awt}
								{assign var=subBc value=$ARS.detail.bc}
								<table class="table table-striped">
									<tr>
										<th colspan=5> {$CollectionNo} &nbsp; {$ARS.detail.chk_no} - {$ARS.detail.bank} - {$ARS.detail.date_of_chk} </th>
									</tr>
									<tr>
										<th> Sales No.</td>
										<th> Payment </td>
										<th> EWT </td>
										<th> Bank Charge </td>
										<th> Total </td>
									</tr>
								{foreach key=ID item=AR from=$ARS.lists}
									{assign var=sa_no_ value=$AR.sa_no_}
									{assign var=payment value=$AR.payment}
									{assign var=awt value=$AR.awt}
									{assign var=bc value=$AR.bc}
									{assign var=total value=$AR.total}
									<tr>
										<td> {$sa_no_}</td>
										<td> {$payment}</td>
										<td> {$awt}</td>
										<td> {$bc}</td>
										<td> {$total}</td>
									</tr>
								{/foreach}
								<tr>
									<th style="text-align:right" > Sub Total: </th>
									<th> {$subPayment} </th>
									<th> {$subAwt} </th>
									<th> {$subBc} </th>
									<th> {$subtotal} </th>
								</tr>
								</table>
					{/foreach}
			{/if}

			{if $DATA.summary.Cash_online }
				<h3>Cash Online Transactions</h3>
					{foreach key=CollectionNo item=ARS from=$DATA.summary.Cash_online.details}
								{assign var=subtotal value=$ARS.detail.total}
								{assign var=subPayment value=$ARS.detail.payment}
								{assign var=subAwt value=$ARS.detail.awt}
								{assign var=subBc value=$ARS.detail.bc}
								<table class="table table-striped">
									<tr>
										<th colspan=1> {$CollectionNo} </th>
									</tr>
									<tr>
										<th> Sales No.</td>
										<th> Payment </td>
										<th> EWT </td>
										<th> Bank Charge </td>
										<th> Total </td>
									</tr>
								{foreach key=ID item=AR from=$ARS.lists}
									{assign var=ar_no_ value=$AR.ar_no_}
									{assign var=sa_no_ value=$AR.sa_no_}
									{assign var=cl_no_ value=$AR.cl_no_}
									{assign var=payment value=$AR.payment}
									{assign var=awt value=$AR.awt}
									{assign var=bc value=$AR.bc}
									{assign var=total value=$AR.total}
									<tr>
										<td> {$sa_no_}</td>
										<td> {$payment}</td>
										<td> {$awt}</td>
										<td> {$bc}</td>
										<td> {$total}</td>
									</tr>
								{/foreach}
								<tr>
									<th style="text-align:right" > Sub Total: </th>
									<th> {$subPayment} </th>
									<th> {$subAwt} </th>
									<th> {$subBc} </th>
									<th> {$subtotal} </th>
								</tr>
								</table>
					{/foreach}
			{/if}
			</div>
			{include file='ReportTemplates/footercollection.tpl'}
		</div>
	</div>