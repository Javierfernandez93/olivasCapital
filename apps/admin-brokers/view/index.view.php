<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-12">
            <div
                class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <i class="bi bi-pie-chart-fill"></i>
                        </div>
                        <div class="col fw-semibold text-dark">
                            <div class="small">Brokers</div>
                        
                            <div v-if="date.day">
                                <span class="text-uppercase">operación del 
                                    <span 
                                        v-if="!date.editing"
                                        @click="toggleDateEditing"
                                        class="text-primary cursor-pointer"> 
                                        <u>{{date.day}}</u>
                                    </span>
                                    <span v-else>
                                        <input 
                                            v-model="date.day"
                                            @change="getBrokersByDate"
                                            :max="date.today"
                                            type="date" class="form-control w-20 d-inline-flex"/>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <?php if($UserSupport->hasPermission('add_broker')) { ?>
                                <div><a href="../../apps/admin-brokers/add" type="button" class="btn btn-success btn-sm">Añadir broker</a></div>
                            <?php } ?>
                            <div><span class="badge bg-secondary">Total de brokers {{Object.keys(brokers).length}}</span></div>
                        </div>
                    </div>
                </div>
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col">
                            <input 
                                :autofocus="true"
                                v-model="query"
                                type="text" class="form-control" placeholder="Buscar..."/>
                        </div>
                        <div class="col-auto">
                            <?php if($UserSupport->hasPermission('close_operation')) { ?>
                                <button 
                                :disabled="!operation_open" 
                                    @click="closeOperation"
                                    ref="operation_open"
                                    class="btn btn-success">Cerrar operación</button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div 
                    v-if="Object.keys(brokers).length > 0"
                    class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th @click="sortData(columns.name)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.name.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Broker</u>
                                    </th>
                                    <th @click="sortData(columns.capital)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.capital.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Monto invertido</u>
                                    </th>
                                    <th @click="sortData(columns.portfolio)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.portfolio.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">% portafolio</u>
                                    </th>
                                    <th @click="sortData(columns.gain)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.gain.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Ganancia bruta</u>
                                    </th>
                                    <th @click="sortData(columns.fee)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.fee.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Fee</u>
                                    </th>
                                    <th @click="sortData(columns.real_gain)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.real_gain.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Ganancia neta</u>
                                    </th>
                                    <th @click="sortData(columns.percentaje_gain)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.percentaje_gain.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">% ganado</u>
                                    </th>
                                    <th @click="sortData(columns.new_capital)" class="text-center c-pointer text-uppercase text-xxs text-secondary font-weight-bolder opacity-7">
                                        <span v-if="columns.new_capital.desc">
                                            <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                        </span>    
                                        <span v-else>    
                                            <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                        </span>    
                                        <u class="text-sm">Nuevo saldo</u>
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="broker in brokers"
                                    :class="!broker.status ? 'opacity-25' : ''"
                                    class="text-center">
                                    <td>
                                        <h6 class="mb-0 text-sm">{{broker.name}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">$ {{broker.capital.numberFormat(2)}} </h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">{{broker.portfolio}} %</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span v-if="broker.editing">
                                            <input 
                                                v-model="broker.gain"
                                                @keydown.enter.exact.prevent="addGainPerBroker(broker)"
                                                class="form-control" type="number" placeholder="$0">
                                        </span>
                                        <span v-else
                                            @click="toggleEditing(broker)">
                                            <h6 class="mb-0 text-success c-pointer text-sm"><u>$ {{broker.gain.numberFormat(2)}}</u></h6>
                                        </span>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">{{broker.fee}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">$ {{broker.real_gain.numberFormat(2)}} </h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">{{broker.percentaje_gain.numberFormat(2)}} %</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <h6 class="mb-0 text-sm">$ {{broker.new_capital.numberFormat(2)}}</h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                
                                            </button>
                                            <ul class="dropdown-menu shadow">
                                                <?php if($UserSupport->hasPermission('list_capitals')) { ?>
                                                    <li><button class="dropdown-item" @click="viewCapitals(broker.broker_id)">Ver montos invertidos</button></li>
                                                <?php } ?>
                                                <?php if($UserSupport->hasPermission('add_capital')) { ?>
                                                    <li><button class="dropdown-item" @click="addCapital(broker)">Añadir monto invertido</button></li>
                                                <?php } ?>
                                                <?php if($UserSupport->hasPermission('edit_broker')) { ?>
                                                    <li><button class="dropdown-item" @click="goToEdit(broker.broker_id)">Editar</button></li>
                                                <?php } ?>
                                                <!-- <li><hr class="dropdown-divider"></li>
                                                <li v-if="!broker.status"><button class="dropdown-item" @click="inactiveBroker(broker.broker_id)">Inactivar</button></li>
                                                <li v-if="broker.status"><button class="dropdown-item" @click="activeBroker(broker.broker_id)">Activar</button></li> -->
                                                <li><hr class="dropdown-divider"></li>
                                                <?php if($UserSupport->hasPermission('delete_broker')) { ?>
                                                    <li><button class="dropdown-item" @click="deleteBroker(broker.broker_id)">Eliminar</button></li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </td>
                                
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr class="text-center">
                                    <td class="border-bottom-0 border-top"></td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">$ {{totals.capital.numberFormat(2)}}</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">{{totals.portfolio.numberFormat(2)}} %</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">$ {{totals.gain.numberFormat(2)}}</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">{{totals.fee.numberFormat(2)}} %</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">$ {{totals.real_gain.numberFormat(2)}}</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">{{totals.percentaje_gain.numberFormat(2)}}%</h6>
                                    </td>
                                    <td class="align-middle border-bottom-0 border-top fw-semibold text-center">
                                        <h6 class="mb-0 text-sm">$ {{totals.new_capital.numberFormat(2)}}</h6>
                                    </td>
                                    <td class="border-bottom-0 border-top">
                                        
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div v-else
                    class="card-body">
                    <div class="alert alert-secondary text-white text-center">
                        <div>No tenemos brokers aún</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if($UserSupport->hasPermission('list_stats')) { ?>
        <stats-viewer></stats-viewer>
    <?php } ?>
</div>