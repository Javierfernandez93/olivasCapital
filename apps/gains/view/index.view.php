<div class="container-fluid py-4" id="app">
    <profit-viewer></profit-viewer>
    
    <div class="row">
        <div class="col-12">
            <div
                v-if="profits.length > 0"
                class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col fw-semibold text-dark">Profits</div>
                        <div class="col-auto"><span class="badge bg-primary">Total de ganancias {{profits.length}}</span></div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th @click="sortData(columns.create_date)" class="text-center c-pointer text-uppercase text-xxs text-primary font-weight-bolder opacity-7">
                                        <span v-if="columns.create_date.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Fecha</u>
                                    </th>
                                    <th @click="sortData(columns.profit)" class="text-center c-pointer text-uppercase text-xxs text-primary font-weight-bolder opacity-7">
                                        <span v-if="columns.profit.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Monto</u>
                                    </th>
                                    <th @click="sortData(columns.name)" class="text-center c-pointer text-uppercase text-xxs text-primary font-weight-bolder opacity-7">
                                        <span v-if="columns.name.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Tipo</u>
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="profit in profits" class="text-center">
                                    <td>
                                        <p class="text-xs text-secondary mb-0">{{profit.create_date.formatDate()}}</p>
                                    </td>
                                    <td>
                                        <p class="fw-semibold">$ {{profit.profit.numberFormat(2)}}</p>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-sm">{{profit.name}}</h6>
                                        <h6 class="mb-0 text-xs text-primary">{{profit.description}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Liberada</span>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="text-center">
                                    <td>Total</td>
                                    <td><p class="fw-semibold">$ {{totals.total_gain.numberFormat(2)}}</p></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-secondary text-white text-center">
                    <div>No tenemos información sobre tus ganancias.</div>
                </div>
            </div>
        </div>
    </div>
</div>