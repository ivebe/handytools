<template>
    <div class="text-center"><canvas id="canvas" width="60" height="60"></canvas></div>
</template>

<script>


export default {

    created(){
        $.getScript('/js/identitiles.js', function(){
            identitiles('canvas', '00000000000000000000000000000000');
        })
    },

    computed: {
        identitiles_value(){
            return this.$store.state.identitiles_value
        }
    },

    watch: {
        identitiles_value: function(){

            var vm = this;

            if(this.$store.state.identitiles_value == '')
            {
                identitiles('canvas', '00000000000000000000000000000000')
            }
            else
            {
                axios.get('/api/md5/get', {
                    params: {
                        'input': vm.$store.state.identitiles_value
                    }
                })
                .then(function (response) {
                    identitiles('canvas', response.data.md5)
                    vm.$store.commit('updateIdentitilesMD5', response.data.md5)
                })
                .catch(function (error) {
                })
            }
        }
    }
}
</script>
