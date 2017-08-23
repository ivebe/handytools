<template>
    <form>
        <div class="form-group">
            <input v-model="text" type="text" class="form-control">
        </div>

        <div class="form-group">
        <div class="pull-left" style="padding-top: 7px;">Your text is</div>
        <div class="pull-left col-md-1"><input class="form-control" v-model="slen" type="text"></div>
        <div class="pull-left" style="padding-top: 7px;">characters long.</div>
        </div>
    </form>
</template>

<script>

export default {
    data(){
        return {
            text: '',
            slen: 0
        }
    },

    watch: {
        text: function(){
            this.getText()
        }
    },

    methods: {
        getText: _.debounce(
            function () {

                var vm = this

                axios.get('/api/strlen/get',{
                    params: {
                        'input': vm.text
                    }
                })
                .then(function (response) {
                    vm.slen = response.data.strlen
                })
                .catch(function (error) {
                    alert( 'Error! Could not reach the API. ' + error )
                })
            },
            500
        )
    }
}
</script>