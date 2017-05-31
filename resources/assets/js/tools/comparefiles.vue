<template>
    <div class="">
      <form>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                <textarea v-model="textOne" class="form-control form-height"></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
                <textarea v-model="textTwo" class="form-control form-height"></textarea>
            </div>
          </div>
          <button class="btn btn-primary" @click.stop.prevent="compareText">Compare</button>
        </div>
      </form>
      <div id="difference">
        <!-- // display difference here -->
      </div>
    </div>
</template>

<script>


export default {
    data(){
        return {
            textOne: '',
            textTwo: ''
        }
    },

    methods: {
        compareText:
            function () {
                $('#difference').empty();
                var vm = this;

                axios.get('/api/comparefiles/get',{
                  params:{
                    textOne: vm.textOne,
                    textTwo: vm.textTwo
                  }

                })
                .then(function (response) {
                    $('#difference').append(response.data.text);
                })
                .catch(function (error) {
                    vm.responseText = 'Error! Could not reach the API. ' + error
                })
            }
    }
}
</script>
<style>
  .form-height{
    height: 200px!important;
  }
  .diffDeleted{
    color: #24292E;
    background: #F1CBCB;
  }
  .diffInserted{
    color: #24292E;
    background: #A6F3A6;
  }
</style>
