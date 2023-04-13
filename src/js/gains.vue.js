import { User } from '../../src/js/user.module.js?t=4'

/* vue */
import { ProfitViewer } from '../../src/js/profitViewer.vue.js?t=1'

Vue.createApp({
    components: {
        ProfitViewer
    },
    data() {
        return {
            User: null,
            profits: {},
            totals: {
                total_gain: 0
            },
            columns: { // 0 DESC , 1 ASC 
                create_date: {
                    name: 'create_date',
                    desc: false,
                },
                profit: {
                    name: 'profit',
                    desc: true,
                },
                name: {
                    name: 'name',
                    desc: true,
                    alphabetically: true,
                },
            }
        }
    },
    watch: {
        user: {
            handler() {

            },
            deep: true
        },
    },
    methods: {
        sortData: function (column) {
            this.profits.sort((a, b) => {
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
        calculateTotals: function () {
            if(this.profits.length > 0)
            {
                this.profits.map((profit) => {
                    this.totals.total_gain += profit.profit ? parseFloat(profit.profit) : 0;
                })
            }
        },
        getProfits: function () {
            return new Promise((resolve) => {
                this.User.getProfits({}, (response) => {
                    if (response.s == 1) {
                        this.profits = response.profits
                    }

                    resolve()
                })
            })
        },
    },
    mounted() {
        this.User = new User
        this.getProfits().then(() => {
            this.calculateTotals()
        })
    },
}).mount('#app')