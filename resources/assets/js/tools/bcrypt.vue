<template>
    <form>
        <div class="form-group">
            <label>Text Input</label>
            <input v-model="raw_input" type="text" class="form-control" placeholder="Raw value">
        </div>
        <div class="form-group col-md-11 nopadding">
            <label>BCrypt hash</label>
            <input v-model="hash" type="text" class="form-control" v-bind:placeholder="hash_placeholder">
        </div>
        <div class="col-md-1 nopadding">
            <identitiles></identitiles>
        </div>

        <div class="form-group col-md-11 nopadding">
            <label>BCrypt hash to compare</label>
            <input v-model="hash_compare" type="text" class="form-control" v-bind:placeholder="hash_compare_placeholder">
        </div>
        <div class="col-md-1 nopadding text-center">
            <span v-bind:class="[
                compare_results == 1 ?
                    'glyphicon-ok' : compare_results == -1 ? 'glyphicon-refresh gly-spin' : 'glyphicon-remove'
                    ]"
                  class="glyphicon"
                  aria-hidden="true"></span>
        </div>

    </form>
</template>

<script>


export default {
    data(){
        return {
            raw_input: '',
            hash: '',
            hash_placeholder: 'BCrypt hash',
            hash_compare: '',
            hash_compare_placeholder: 'Enter BCrypt hash to compare',
            compare_results: 0
        }
    },

    mounted(){

    },

    watch: {
        raw_input: function () {
            this.hash = ''
            this.hash_placeholder = 'Typing...'
            this.getBCrypt()

            if(this.hash_compare != '')
                this.compareBCrypt()
        },

        hash_compare: function(){
            this.compareBCrypt()
        }
    },

    methods: {
        getBCrypt: _.debounce(
            function () {

                var vm = this

                vm.hash = '';

                if(vm.raw_input == ''){
                    vm.hash_placeholder = 'Please enter some value...'
                    return
                }

                vm.hash_placeholder = 'Processing...'

                axios.get('/api/bcrypt/get',{
                    params: {
                        'input': vm.raw_input,
                        'hash': vm.hash
                    }
                })
                .then(function (response) {
                    vm.hash  = response.data.hash
                    vm.match = response.data.match

                    vm.$store.commit('updateIdentitiles', vm.raw_input)
                })
                .catch(function (error) {
                    vm.hash = 'Error! Could not reach the API. ' + error
                })
            },
            500
        ),

        compareBCrypt: _.debounce(
            function () {

                var vm = this

                vm.compare_results = -1

                if(vm.raw_input == ''){
                    vm.hash_compare_placeholder = 'Please enter some value...'
                    return
                }

                axios.get('/api/bcrypt/get',{
                    params: {
                        'input': vm.raw_input,
                        'hash': vm.hash_compare
                    }
                })
                .then(function (response) {
                    vm.compare_results = response.data.match
                    vm.$store.commit('updateIdentitiles', vm.raw_input)
                })
                .catch(function (error) {
                    vm.hash_compare = 'Error! Could not reach the API. ' + error
                })
            },
            500
        )
    }
}
</script>

<style scoped>
    .nopadding{
        padding: 0;
    }

    .glyphicon{
        font-size: 50px;
        margin-top: 20px;
    }

    .gly-spin {
        -webkit-animation: spin 2s infinite linear;
        -moz-animation: spin 2s infinite linear;
        -o-animation: spin 2s infinite linear;
        animation: spin 2s infinite linear;
    }
    @-moz-keyframes spin {
        0% {
            -moz-transform: rotate(0deg);
        }
        100% {
            -moz-transform: rotate(359deg);
        }
    }
    @-webkit-keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
        }
    }
    @-o-keyframes spin {
        0% {
            -o-transform: rotate(0deg);
        }
        100% {
            -o-transform: rotate(359deg);
        }
    }
    @keyframes spin {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(359deg);
            transform: rotate(359deg);
        }
    }
    .gly-rotate-90 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=1);
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }
    .gly-rotate-180 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .gly-rotate-270 {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        transform: rotate(270deg);
    }
    .gly-flip-horizontal {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1);
        -webkit-transform: scale(-1, 1);
        -moz-transform: scale(-1, 1);
        -ms-transform: scale(-1, 1);
        -o-transform: scale(-1, 1);
        transform: scale(-1, 1);
    }
    .gly-flip-vertical {
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1);
        -webkit-transform: scale(1, -1);
        -moz-transform: scale(1, -1);
        -ms-transform: scale(1, -1);
        -o-transform: scale(1, -1);
        transform: scale(1, -1);
    }
</style>