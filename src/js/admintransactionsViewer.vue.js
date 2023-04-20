import { UserSupport } from '../../src/js/userSupport.module.js?t=1.0.3'

/* vue */
const AdmintransactionsViewer = {
    name: 'admintransactions-viewer',
    components : { 
    },
    data() {
        return {
            UserSupport : new UserSupport,
            transactions : null,
            transactionsAux : null,
            filters: [
                {
                    name: 'Transferidas',
                    status: 2
                },
                {
                    name: 'Pendientes',
                    status: 1
                }
            ],
            status: 1,
            query : null,
            columns: { 
                withdraw_per_user_id : {
                    name: 'withdraw_per_user_id',
                    desc: false,
                },
                user_support_id : {
                    name: 'user_support_id',
                    desc: false,
                },
                names : {
                    name: 'names',
                    desc: false,
                    alphabetically: true,
                },
                ammount : {
                    name: 'ammount',
                    desc: false,
                },
                method : {
                    name: 'method',
                    desc: false,
                },
                account : {
                    name: 'account',
                    desc: false,
                },
                create_date : {
                    name: 'create_date',
                    desc: false,
                },
            }
        }
    },
    watch : {
        query: {
            handler() {
                this.filterData()
            },
            deep: true
        },
        status: {
            handler() {
                this._getUsersTransactions()
            },
            deep: true
        }
    },
    methods: {
        filterData() {
            this.transactions = this.transactionsAux

            this.transactions = this.transactions.filter((transaction) => {
                return transaction.names.toLowerCase().includes(this.query.toLowerCase()) || transaction.user_login_id.toString().includes(this.query) || transaction.ammount.toString().includes(this.query) || transaction.account.toLowerCase().includes(this.query.toLowerCase())
            })
        },
        sortData(column) {
            this.transactions.sort((a,b) => {
                const _a = column.desc ? a : b
                const _b = column.desc ? b : a

                if(column.alphabetically)
                {
                    return _a[column.name].localeCompare(_b[column.name])
                } else {
                    return _a[column.name] - _b[column.name]
                }
            });

            column.desc = !column.desc
        },
        copyToClipboard(text,target) {
            navigator.clipboard.writeText(text).then(() => {
                target.innerText = 'Listo'
            })
        },
        applyPartialWithdraw(transaction) {
            let alert = alertCtrl.create({
                title: "Aviso",
                subTitle: `Ingresa la cantidad de depósito parcial para está transacción. Debe ser menor a <b>$ ${Math.abs(transaction.ammount).numberFormat(0)} USD</b>`,
                inputs: [
                    {
                        type : 'number',
                        placeholder: 'Ingresa la cantidad aquí',
                        id: 'amount',
                        name: 'amount'
                    }
                ],
                buttons: [
                    {
                        text: "Sí, añadir depósito parcial",
                        role: "cancel",
                        class: 'btn-success',
                        handler: (data) => {
                            if(data.amount < Math.abs(transaction.ammount))
                            {
                                this.UserSupport.applyPartialWithdraw({amount: data.amount, user_login_id: transaction.user_login_id }, (response) => {
                                    if(response.s == 1)
                                    {
                                        this._getUsersTransactions()
                                    }
                                })
                            } else {
                                alertInfo({
                                    icon:'<i class="bi bi-x"></i>',
                                    message: `El monto parcial es mayor al monto retirado`,
                                    _class:'bg-danger text-white'
                                },1200)
                            }
                        },
                    },
                    {
                        text: "Cancelar",
                        role: "cancel",
                        handler: (data) => {
                        },
                    },
                ],
            })

            alertCtrl.present(alert.modal)
        },
        applyWithdraw(transaction) {
            let alert = alertCtrl.create({
                title: "Aviso",
                subTitle: `¿Estás seguro de ingresar el retiro de <b>${transaction.names}</b> por $ <b>${Math.abs(transaction.ammount).numberFormat(2)}</b> USD como aplicado?`,
                buttons: [
                    {
                        text: "Sí, ingresar como aplicado",
                        role: "cancel",
                        class: 'btn-success',
                        handler: (data) => {
                            
                            this.UserSupport.applyWithdraw({user_login_id: transaction.user_login_id},(response)=>{
                                if(response.s == 1)
                                {
                                    this._getUsersTransactions()
                                }
                            })
                        },
                    },
                    {
                        text: "Cancelar",
                        role: "cancel",
                        handler: (data) => {
                        },
                    },
                ],
            })

            alertCtrl.present(alert.modal)
        },
        deleteWithdraw(withdraw_per_user_id,user_login_id) {
            this.UserSupport.deleteWithdraw({withdraw_per_user_id:withdraw_per_user_id,user_login_id:user_login_id},(response)=>{
                if(response.s == 1)
                {
                    this._getUsersTransactions()
                }
            })
        },
        _getUsersTransactions() {
            this.getUsersTransactions().then((transactions) => {
                this.transactions = transactions
                this.transactionsAux = transactions
            }).catch(() => {
                this.transactions = false
                this.transactionsAux = false
            })
        },
        getUsersTransactions() {
            return new Promise((resolve, reject) =>{
                this.UserSupport.getUsersTransactions({status:this.status},(response)=>{
                    if(response.s == 1)
                    {
                        resolve(response.transactions)
                    }

                    reject()
                })
            })
        },
    },
    mounted() 
    {
        this._getUsersTransactions()
    },
    template : `
        <div v-if="transactions" class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <i class="bi bi-pie-chart-fill"></i>
                            </div>
                            <div class="col fw-semibold text-dark">
                                <div class="small">Transacciones</div>
                            </div>
                            <div class="col-auto text-end">
                                <div><span class="badge bg-secondary">Total de transacciones {{Object.keys(transactions).length}}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col">
                                <input :autofocus="true" v-model="query" type="text" class="form-control" placeholder="Buscar..." />
                            </div>
                            <div class="col-auto">
                                <select class="form-control" v-model="status">
                                    <option v-for="filter in filters" v-bind:value="filter.status">{{filter.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th @click="sortData(columns.withdraw_per_user_id)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.withdraw_per_user_id.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">#</u>
                                        </th>
                                        <th @click="sortData(columns.user_support_id)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.user_support_id.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">ID</u>
                                        </th>
                                        <th @click="sortData(columns.names)" class="text-start c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.names.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">Usuario</u>
                                        </th>
                                        <th @click="sortData(columns.ammount)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.ammount.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">Monto retirado</u>
                                        </th>
                                        <th @click="sortData(columns.method)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.method.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-filssl"></i>
                                            </span>
                                            <u class="text-sm ms-2">Método</u>
                                        </th>
                                        <th @click="sortData(columns.account)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.account.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">Alias cuenta</u>
                                        </th>
                                        <th @click="sortData(columns.account)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.account.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">Alias wallet</u>
                                        </th>
                                        
                                        <th @click="sortData(columns.create_date)" class="text-center c-pointer text-uppercase text-secondary font-weight-bolder opacity-7">
                                            <span v-if="columns.create_date.desc">
                                                <i class="bi text-primary bi-arrow-up-square-fill"></i>
                                            </span>
                                            <span v-else>
                                                <i class="bi text-primary bi-arrow-down-square-fill"></i>
                                            </span>
                                            <u class="text-sm ms-2">Fecha de sol.</u>
                                        </th>

                                        <th v-if="status == 1" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="transaction in transactions">
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge text-dark">{{transaction.withdraw_per_user_id}}</span>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge text-dark">{{transaction.user_login_id}}</span>
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{transaction.names}}</h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge text-dark">$ {{Math.abs(transaction.ammount).numberFormat(0)}}</span>
                                            <div><button class="btn btn-sm btn-success shadow-none ms-2 mb-0 px-3" @click="copyToClipboard(Math.abs(transaction.ammount),$event.target)">Copiar</button></div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge border border-primary text-primary">{{transaction.method}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge text-dark">
                                                {{transaction.account}}
                                            </span>
                                            <div><button class="btn btn-sm btn-success shadow-none ms-2 mb-0 px-3" @click="copyToClipboard(transaction.account,$event.target)">Copiar</button></div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge text-dark">
                                                {{transaction.wallet}}
                                            </span>
                                            <div><button class="btn btn-sm btn-success shadow-none ms-2 mb-0 px-3" @click="copyToClipboard(transaction.wallet,$event.target)">Copiar</button></div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <p class="mb-0">{{transaction.create_date.formatDate()}}</p>
                                            <span v-if="transaction.status == 1" class="badge bg-secondary">Pendiente</span>
                                            <span v-else-if="transaction.status == 2" class="badge bg-success">Transferida</span>
                                            <span v-else-if="transaction.status == -1" class="badge bg-warning">Eliminada</span>
                                        </td>
                                        <td
                                            v-if="status == 1"
                                            class="align-middle text-center text-sm">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm px-3 shadow-none mb-0 btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">

                                                </button>
                                                <ul class="dropdown-menu shadow">
                                                
                                                    <li><button class="dropdown-item" @click="applyWithdraw(transaction)">Aplicada</button></li>    
                                                    <li><button class="dropdown-item" @click="applyPartialWithdraw(transaction)">Aplicar parcial</button></li>    
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li><button class="dropdown-item" @click="deleteWithdraw(transaction.withdraw_per_user_id,transaction.user_login_id)">Eliminar</button></li>
                                                </ul>
                                            </div>
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div v-else-if="transactions == false" class="card">
            <div class="card-body">
                <div class="alert alert-secondary text-white text-center">
                    <div>No tenemos transacciones aún</div>
                </div>
            </div>
        </div>
    `
}

export { AdmintransactionsViewer }