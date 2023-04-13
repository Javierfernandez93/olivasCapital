import { User } from '../../src/js/user.module.js?t=4'

/* vue */ 
import { NoticeViewer } from '../../src/js/noticeViewer.vue.js?t=2'
import { ProfitViewer } from '../../src/js/profitViewer.vue.js?t=2'

Vue.createApp({
    components : { 
        ProfitViewer, NoticeViewer
    },
    data() {
        return {
            User : null,
            profits : {},
            landing : null,
        }
    },
    watch : {
        user : {
            handler() {
                
            },
            deep: true
        },
    },
    methods: {
        copyLanding : function() {
            copyToClipboardTextFromData(this.$refs.landing)
        },
        getProfits : function() {
            this.User.getProfits({},(response)=>{
                if(response.s == 1)
                {
                    this.profits = response.profits.map((profit)=>{
                        profit['create_date'] = new Date(profit['create_date']*1000).toLocaleDateString()
                        return profit
                    })
                }
            })
        },
        getBackofficeVars : function() {
            this.User.getBackofficeVars({},(response)=>{
                if(response.s == 1)
                {
                    this.landing = response.landing
                }
            })
        },
    },
    mounted() 
    {
        this.User = new User
        this.getProfits()
        this.getBackofficeVars()
    },
}).mount('#app')