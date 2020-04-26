export default {
    data(){
        return {

        }
    }, 
    methods: {
        async callApi(method, url, data = {} ){
            // append to avoid error in backend
            if(method == 'get' || method == 'GET')
                url += "?user_confirmed=true";
            else
                data.user_confirmed = true;
            try {
              return await axios({ method, url, data });
            } catch (e) {
                return e.response
            }
        }, 

        info(desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        success(desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning(desc, title="Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        error(desc, title="Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }, 
        swr(desc='Somethingn went wrong! Please try again.', title="Oops") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }, 



    },
}