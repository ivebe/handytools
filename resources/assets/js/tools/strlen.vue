<template>
    <form>
        <div class="form-group">
            <label>Input</label>
            <input v-model="input" type="text" class="form-control"><br>
            <label>String length:</label>
            <p>{{strlen}}</p>
        </div>
    </form>
</template>

<script>


export default {
    data(){
        return {
            input: '',
            strlen: 0
        }
    },

    mounted(){
        this.getText()
    },
    watch:{
      input: function(value){
        this.strlen = value.length;
        if(this.strlen === 0){
          this.strlen = '';
        }

      }
    },

    methods: {
        getText:
            function () {

                var vm = this

                vm.text = 'Processing...';

                axios.get('/api/strlen/get',{
                })
                .then(function (response) {
                    vm.text  = response.data.text
                })
                .catch(function (error) {
                    vm.text = 'Error! Could not reach the API. ' + error
                })
            }
    }
}
</script>
<style media="screen">
  .form-width{
    width: 7%;
  }
</style>
