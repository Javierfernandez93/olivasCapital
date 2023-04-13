import { User } from '../../src/js/user.module.js?t=4'

Vue.createApp({
    components : { 
        
    },
    data() {
        return {
            user: {
                company_id: null,
                email: null,
                names: null,
                image: null,
                plan: false,
                country_id: 159, // by default when loads is México
                has_card: false,
                referral_notification: false,
                referral_email: false,
                info_email: false,
            },
            countries : {},
            lastReferrals : {},
        }
    },
    watch : {
        user : {
            handler() {
                this.editProfile()
            },
            deep: true
        },
    },
    methods: {
        getProfile : function() {
            this.User.getProfile({include_countries:true},(response)=>{
                if(response.s == 1)
                {
                    Object.assign(this.user, response.user)
                    
                    Object.assign(this.countries, response.countries)
                }
            })
        },
        editProfile : function() {
            this.User.editProfile(this.user,(response)=>{
                if(response.s == 1)
                {
                    
                }
            })
        },
        getLastReferrals : function() {
            this.User.getLastReferrals({},(response)=>{
                if(response.s == 1)
                {
                    this.lastReferrals = response.lastReferrals.map((referral)=>{
                        referral.signup_date = new Date(referral.signup_date*1000).toLocaleDateString()
                        return referral
                    })
                }
            })
        },
        checkFields : function() {
        },
        openFileManager: function () 
        {
            this.$refs.file.click()
        },
        uploadFile: function () 
        {
            $(".progress").removeClass("d-none")

            let files = $(this.$refs.file).prop('files');
            var form_data = new FormData();
          
            form_data.append("file", files[0]);
          
            this.User.uploadImageProfile(form_data,$(".progress-chat").find(".progress-bar"),(response)=>{
              if(response.s == 1)
              {
                  this.user.image = response.target_path
              }
            });
        },
    },
    mounted() 
    {
        this.User = new User
        
        this.getProfile()
        this.getLastReferrals()

        $(this.$refs.phone).mask('(00) 0000-0000');
    },
}).mount('#app')