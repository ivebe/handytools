<template>
    <form>
        <div class="form-group">
            <label>Input</label>
            <input v-model="input" type="text" class="form-control"><br>
            <label>String length:</label>
            <p class="output">{{strlen}}</p>
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

    watch:{
      input: function(value){
        this.strlen = value.length;
        if(this.strlen === 0){
          this.strlen = '';
        }
        if(this.input ===''){
          this.strlen = 0;
        }

      }
    }
}
</script>
<style media="screen">
  .output{
    font-size: 20px;
  }
</style>
