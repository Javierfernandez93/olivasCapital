import { UserSupport } from '../../src/js/userSupport.module.js?t=5'

/* vue */

Vue.createApp({
    components: {
    },
    data() {
        return {
            UserSupport: new UserSupport,
            users: {},
            usersAux: {},
            query: null,
            percentaje: 0,
            total_amount: 0,
            total_payed: 0,
            total_percentaje_payed: 0,
            total_ponderation: 0,
            columns: { // 0 DESC , 1 ASC 
                company_id: {
                    name: 'company_id',
                    desc: false,
                },
                profit: {
                    name: 'profit',
                    desc: false,
                },
                names: {
                    name: 'names',
                    desc: false,
                    alphabetically: true,
                },
                additional_profit: {
                    name: 'additional_profit',
                    desc: false,
                },
                sponsor_profit: {
                    name: 'sponsor_profit',
                    desc: false,
                },
                total_profit: {
                    name: 'total_profit',
                    desc: false,
                },
                ammount: {
                    name: 'ammount',
                    desc: false,
                },
                ponderation: {
                    name: 'ponderation',
                    desc: false,
                },
            }
        }
    },
    watch: {
        query:
        {
            handler() {
                this.filterData()
            },
            deep: true
        }
    },
    methods: {
        sortData: function (column) {
            this.users.sort((a, b) => {
                const _a = column.desc ? a : b
                const _b = column.desc ? b : a

                if (column.alphabetically) {
                    return _a[column.name].localeCompare(_b[column.name])
                } else {
                    return _a[column.name] - _b[column.name]
                }
            });

            column.desc = !column.desc
        },
        filterData: function () {
            this.users = this.usersAux

            this.users = this.users.filter((user) => {
                return user.names.toLowerCase().includes(this.query.toLowerCase()) || user.email.toLowerCase().includes(this.query.toLowerCase()) || user.company_id.toString().includes(this.query.toLowerCase())
            })
        },
        addOldComissions: function (company_id) {
            window.location.href = '../../apps/admin-users/addOldComissions?ulid=' + company_id
        },
        viewDeposits: function (company_id) {
            window.location.href = '../../apps/admin-users/deposits?ulid=' + company_id
        },
        getInBackoffice: function (company_id) {
            this.UserSupport.getInBackoffice({ company_id: company_id }, (response) => {
                if (response.s == 1) {
                    window.location.href = '../../apps/backoffice'
                }
            })
        },
        deleteUser: function (company_id) {
            this.UserSupport.deleteUser({ company_id: company_id }, (response) => {
                if (response.s == 1) {
                    this.getUsers()
                }
            })
        },
        deletePlan: function (company_id) {
            let alert = alertCtrl.create({
                title: "Aviso",
                subTitle: "¿Estás seguro de eliminar el plan de éste usuario?. Ya no recibirá más ganancias a partir de ahora",
                buttons: [
                    {
                        text: "Sí, eliminar",
                        role: "cancel",
                        class: 'btn-danger',
                        handler: (data) => {
                            this.UserSupport.deletePlan({ company_id: company_id }, (response) => {
                                if (response.s == 1) {
                                    this.getUsers()
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

            alertCtrl.present(alert.modal); 
        },
        goToActivatePlan: function (company_id) {
            window.location.href = '../../apps/admin-users/activate?ulid=' + company_id
        },
        goToEdit: function (company_id) {
            window.location.href = '../../apps/admin-users/edit?ulid=' + company_id
        },
        getTotals: function () {
            this.users.map((user)=>{
                this.total_amount += user.ammount
                this.total_payed += user.total_payed
            })
            
            this.total_percentaje_payed = (this.total_payed * 100) / this.total_amount 

            this.users.map((user)=>{
                user.ponderation = ( user.total_payed * 100 ) / this.total_payed
                this.total_ponderation += user.ponderation
            })
        },
        getUsers: function () {
            this.UserSupport.getUsers({flat:true}, (response) => {
                if (response.s == 1) {
                    this.usersAux = response.users
                    this.users = this.usersAux

                    this.getTotals()
                }
            })
        },
    },
    mounted() {
        this.getUsers()
    },
}).mount('#app')