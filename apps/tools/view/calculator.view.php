<div class="container-fluid py-4" id="app">
	<div class="row justify-content-center">
		<div class="col-12 col-lg-10">
			<div class="card bg-gradient-warning mb-3">
				<div class="card-header bg-transparent text-white">
					<h4 class="text-white mb-0">Calculadora</h4>
				</div>
				<div class="card-body">
					<div class="row mb-3">
						<div class="col-12 mb-3">
							<div class="form-floating">
								<input 
									@keydown.enter.exact.prevent="$refs.quantity.focus()"
									v-model="data.capital" :autofocus="true" type="number" class="form-control" placeholder="0">
								<label>Balance</label>
							</div>
						</div>
						<div class="col-12 col-xl-6">
							<div class="form-floating">
								<input
									@keydown.enter.exact.prevent="$refs.ammount.focus()" 
									ref="quantity" 
									v-model="data.duration.quantity" type="number" class="form-control" placeholder="0">
								<label>Duración</label>

								<select 
									v-if="data.duration.quantity == 1"
									class="form-select select-anidable" v-model="data.duration.every" aria-label="">
									<option v-for="period in periods" v-bind:value="period.months">
										{{period.name}}
									</option>
								</select>
								<select 
									v-else
									class="form-select select-anidable" v-model="data.duration.every" aria-label="">
									<option v-for="period in periods" v-bind:value="period.months">
										{{period.namePlural}}
									</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-xl-6">
							<div class="form-floating position-relative">
								<input ref="ammount" v-model="data.contribution.ammount" type="number" class="form-control" placeholder="0">
								<label>Aportaciones</label>

								<select class="form-select select-anidable" v-model="data.contribution.every" aria-label="">
									<option v-for="period in periods" v-bind:value="period.months">
										{{period.aportationName}}
									</option>
								</select>
							</div>
						</div>
					</div>

					<div class="row mb-3 d-none">
						<div class="col-6">
							<div class="form-floating">
								<input v-model="data.fee" type="number" class="form-control" placeholder="0">
								<label>Impuestos anuales (opcional) </label>
							</div>
						</div>
						<div class="col-6">
							<div class="form-floating">
								<input v-model="data.inflation" type="number" class="form-control" placeholder="0">
								<label>Inflación anual (opcional) </label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div
				v-if="results.length" 
				class="row mb-3">
				<div class="col-12">
					<div class="card">
						<div class="table-responsive p-0">
							<table class="table align-items-center mb-0">
								<thead>
									<tr class="align-items-center">
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Periodo
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Capital
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Contribuciones
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Total cap.
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Interés
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Utilidad
										</th>
										<th class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
											Total
										</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="result in results">
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">{{result.period}}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">$ {{result.capitalInitial.numberFormat(2)}}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">$ {{result.contribution.numberFormat(2)}}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">$ {{result.capital.numberFormat(2)}}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">{{result.profit.numberFormat(0)}} %</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">$ {{result.gain.numberFormat(2)}}</p>
										</td>
										<td class="align-middle text-center text-sm">
											<p class="font-weight-bold mb-0">$ {{result.newCapital.numberFormat(2)}}</p>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="row text-center">
				<div
					v-if="data.capital" 
					class="col-6">
					<div class="card">
						<div class="card-body">
							<div>Capital inicial</div>
							<h5 v-if="data.capital">$ {{ data.capital.numberFormat(2) }}</h5>
						</div>
					</div>
				</div>
				<div
					v-if="data.result.capital"  
					class="col-6">
					<div class="card bg-gradient-success">
						<div class="card-body">
							<div class="text-white">Capital final</div>
							<h5 class="text-white" v-if="data.result.capital">
								$ {{ data.result.capital.numberFormat(2) }}
								<span class="text-white text-sm font-weight-bolder"> + {{ data.result.profit.numberFormat(0)}} % </span>
							</h5>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-6 d-none">
			<div class="card">
				<div class="card-body">
					<canvas id="myChart" width="400" height="400"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>