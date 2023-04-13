<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div class="col fw-semibold text-dark">
                            <div class="small">Usuarios</div>
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <input v-model="query" :autofocus="true" type="text" class="form-control" placeholder="Buscar..." />
                </div>
                <div
                    v-if="Object.keys(users).length > 0" 
                    class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="align-items-center">
                                    <th @click="sortData(columns.company_id)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.company_id.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">ID</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.names)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.names.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Usuario</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.ammount)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.ammount.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Monto inv.</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.profit)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.profit.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Profit</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.additional_profit)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.additional_profit.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Profit ad</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.sponsor_profit)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.sponsor_profit.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Profit pat.</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.total_profit)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.total_profit.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Total</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.ammount)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.ammount.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Total pagado</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.ammount)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.ammount.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Porcentaje pagado</u>
                                    </th>
                                    <th 
                                        @click="sortData(columns.ponderation)"
                                        class="text-center c-pointer text-uppercase text-primary text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.ponderation.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm ms-2">Ponderación</u>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users">
                                    <td class="align-middle text-center text-sm">
                                        {{user.company_id}}
                                    </td>
                                    <td>
                                        {{user.names}}
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="user.ammount">
                                            {{user.ammount.numberFormat(2)}}
                                        </span>
                                        <span v-else>
                                            0
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="user.catalog_plan_id">
                                            {{user.profit}}%
                                        </span>
                                        <span v-else>
                                            0%
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="user.catalog_plan_id">
                                            {{user.additional_profit}}%
                                        </span>
                                        <span v-else>
                                            0%
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="user.catalog_plan_id">
                                            {{user.sponsor_profit}}%
                                        </span>
                                        <span v-else>
                                            0%
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="user.catalog_plan_id">
                                            {{user.total_profit}}%
                                        </span>
                                        <span v-else>
                                            0%
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        {{user.total_payed.numberFormat(2)}}
                                    </td>
                                    <td class="align-middle text-center text-sm">-</td>
                                    <td class="align-middle text-center text-sm">{{user.ponderation.numberFormat(4)}}% </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td>Total </td>
                                    <td class="align-middle text-center text-sm">
                                        <div>$ {{total_amount.numberFormat(2)}}</div>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="align-middle text-center text-sm">
                                        <div>$ {{total_payed.numberFormat(2)}}</div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div>{{total_percentaje_payed.numberFormat(2)}} %</div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div>{{total_ponderation.numberFormat(2)}} %</div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div v-else
                    class="card-body">
                    <div class="alert alert-secondary text-white text-center">
                        <div>No tenemos usuarios aún</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>