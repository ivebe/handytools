<template>
    <form>
        <switches v-model="action" :selected="action" :label="switch_label" type-bold="true" theme="bulma" color="blue"></switches>

        <div class="form-group">
            <label>Input</label>
            <textarea v-model="input" class="form-control" placeholder="Input text..."></textarea>
        </div>
        <div class="form-group">
            <label>Output</label>
            <textarea v-model="output" class="form-control" placeholder="Output text..."></textarea>
        </div>
    </form>
</template>

<script>

import Switches from 'vue-switches';

export default {
    data(){
        return {
            action: true,
            input: '',
            output: ''
        }
    },

    computed: {
        switch_label: function(){
            this.getIt()
            return this.action ? 'Encode' : 'Decode';
        }
    },

    components: {
        Switches
    },

    watch: {
        input: function () {
            this.getIt()
        }
    },


    methods: {
        getIt: _.debounce(
            function () {

                var vm = this

                if(vm.input == ''){
                    vm.output = ''
                    return
                }

                axios.get('/api/base64/get',{
                    params: {
                        'data': vm.input,
                        'action': vm.action
                    }
                })
                .then(function (response) {
                    vm.output = response.data.data
                })
                .catch(function (error) {
                    vm.output = 'Error! Could not reach the API. ' + error
                })
            },
            500
        )
    }
}
</script>