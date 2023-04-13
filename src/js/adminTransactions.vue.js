import { UserSupport } from '../../src/js/userSupport.module.js?t=5'

/* vue */

Vue.createApp({
    components : { 
    },
    data() {
        return {
            UserSupport : null,
            transactions : {},
            filters: [
                {
                    name: 'Transferidas',
                    status: 2
                },
                // {
                //     name: 'Todas',
                //     status: -2
                // },
                // {
                //     name: 'Expiradas',
                //     status: 0
                // },
                // {
                //     name: 'Eliminadas',
                //     status: -1
                // },
                {
                    name: 'Pendientes',
                    status: 1
                }
            ],
            status: 1,
            query : null,
            columns: { // 0 DESC , 1 ASC 
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
        status: {
            handler() {
                this.getUsersTransactions()
            },
            deep: true
        }
    },
    methods: {
        sortData: function (column) {
            this.administrators.sort((a,b) => {
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
        applyWithdraw : function(user_login_id) {
            
            this.UserSupport.applyWithdraw({user_login_id: user_login_id},(response)=>{
                if(response.s == 1)
                {
                    this.getUsersTransactions()
                }
            });
        },
        deleteWithdraw : function(user_wallet_id) {
        },
        getUsersTransactions : function() {
            this.UserSupport.getUsersTransactions({status:this.status},(response)=>{
                if(response.s == 1)
                {
                    this.transactions = response.transactions
                }
            })
        },
    },
    mounted() 
    {
        this.UserSupport = new UserSupport
        this.getUsersTransactions()
    },
}).mount('#app')