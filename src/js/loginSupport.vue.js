import { UserSupport } from '../../src/js/userSupport.module.js?t=5'

Vue.createApp({
    components : { 
        
    },
    data() {
        return {
            user: {
                email: null,
                password: null,
            },
            UserSupport : null,
            feedback : false,
            isValidMail : false,
            fieldPasswordType : 'password',
            userComplete : false,
        }
    },
    watch : {
        user : {
            handler() {
                this.checkFields()
                this.checkEmail()
            },
            deep: true
        },
    },
    methods: {
        toggleFieldPasswordType : function() {
            this.fieldPasswordType = this.fieldPasswordType == 'password' ? 'text' : 'password'
        },
        doLogin : function() {
            this.feedback = false

            // dinamicLoader.showLoader($("#button"))
            
            this.UserSupport.doLoginSupport(this.user,(response)=>{
                if(response.s == 1)
                {
                    window.location.href = '../../apps/admin'
                } else if(response.r == "INVALID_PASSWORD") {
                    this.feedback = "Las contraseña indicada no es correcta. Intente nuevamente"
                } else if(response.r == "INVALID_CREDENTIALS") {
                    this.feedback = "Las credenciales proporcionadas no son correctas, intente nuevamente"
                }
            })
        },
        checkEmail : function() {
            this.isValidMail = isValidMail(this.user.email)
        },
        checkFields : function() {
            this.userComplete = this.user.email && this.user.password
        }
    },
    mounted() 
    {
        this.UserSupport = new UserSupport
    },
}).mount('#app')