<div class="container-fluid py-4" id="app">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row align-items-center">
                <div class="col-auto">
                    <i class="bi bi-pie-chart-fill"></i>
                </div>
                <div class="col fw-semibold text-dark">
                    <div class="small">Broker</div>
                    <div v-if="day">
                        <span class="text-uppercase text-primary">{{broker.name}}</span>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <div><span class="badge bg-secondary">Total de inversiones {{ Object.keys(capitals).length }}</span></div>
                </div>
            </div>
        </div>
        <div class="card-header pb-0">
            <input 
                :autofocus="true"
                v-model="query"
                type="text" class="form-control" placeholder="Buscar..."/>
        </div>
        <div class="card-body">
            <div
                v-if="Object.keys(capitals).length > 0"
                >
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Monto invertido</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="capital in capitals"
                            class="text-center">
                                <td>
                                    {{capital.capital_per_broker_id}}
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm">$ {{capital.capital.numberFormat(2)}}</h6>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">Fecha</p>
                                    <p class="text-xs text-secondary mb-0">{{capital.create_date.formatDate()}}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            
                                        </button>
                                        <ul class="dropdown-menu shadow">
                                            <li><button class="dropdown-item" @click="deleteCapital(capital.capital_per_broker_id)">Eliminar</button></li>
                                        </ul>
                                    </div>
                                </td>
                                
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-secondary text-white text-center">
                    <div>No tenemos montos invertidos para éste broker</div>
                </div>
            </div>
        </div>
    </div>
</div>