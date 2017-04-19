<template>
    <form>
        <div class="form-group">
            <label>Input</label>
            <input v-model="input" type="text" class="form-control" placeholder="Raw value">
        </div>
        <div class="form-group col-md-11 nopadding">
            <label>MD5</label>
            <input v-model="identitilesMD5" type="text" class="form-control" v-bind:placeholder="md5_placeholder">
        </div>
        <identitiles></identitiles>

    </form>
</template>

<script>



export default {
    data(){
        return {
            input: '',
            md5_placeholder: 'MD5 hash'
        }
    },

    watch: {
        input: function (newValue) {
            this.$store.commit('updateIdentitilesMD5', '')
            this.md5_placeholder = 'Typing...'
            this.getMD5()
        }
    },

    computed: {
        identitilesMD5: function(){
            return this.$store.state.identitiles_md5
        }
    },

    mounted(){
        this.$store.commit('updateIdentitilesMD5', '')
    },

    methods: {
        getMD5: _.debounce(
            function () {
                var vm = this

                if(vm.input == ''){
                    vm.md5_placeholder = 'Please enter some value...'
                    return
                }

                vm.md5_placeholder = 'Processing...'
                vm.$store.commit('updateIdentitiles', vm.input)
            },
            500
        )
    }
}
</script>

<style>
    .nopadding{
        padding: 0;
    }
</style>