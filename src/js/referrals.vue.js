import { User } from './user.module.js'

Vue.createApp({
    components: {

    },
    data() {
        return {
            referrals: {},
            totals: {
                total_capital: 0
            },
            User: null
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
        getTotals: function () {
            this.referrals.map((user)=>{
                this.totals.total_capital += user.plan ? parseFloat(user.plan.ammount) : 0
            })
        },
        getReferrals: function () {
            return new Promise((resolve) => {
                this.User.getReferrals({}, (response) => {
                    if (response.s == 1) {
                        this.referrals = response.referrals

                        resolve()
                    }
                })
            })
        }
    },
    mounted() {
        console.log(1)
        this.User = new User

        this.getReferrals().then(()=>{
            this.getTotals()
        })
    },
}).mount('#app')