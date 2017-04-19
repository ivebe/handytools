<template>
    <form>
        <div class="form-group">
            <label>Password</label>
            <input v-model="passwd" type="text" class="form-control">
        </div>
        <button class="btn btn-default" @click.prevent="getPasswd">New Password</button>
    </form>
</template>

<script>


export default {
    data(){
        return {
            passwd: ''
        }
    },

    mounted(){
        this.getPasswd()
    },

    methods: {
        getPasswd:
            function () {

                var vm = this

                vm.passwd = 'Processing...';

                axios.get('/api/passwd/get',{
                })
                .then(function (response) {
                    vm.passwd  = response.data.passwd
                })
                .catch(function (error) {
                    vm.passwd = 'Error! Could not reach the API. ' + error
                })
            }
    }
}
</script>