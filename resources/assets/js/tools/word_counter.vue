<template>
    <form>
        <div class="form-group">
            <label>Input</label>
            <textarea class="form-control" v-model="text"></textarea><br>
            <label>Words:</label>
            <p class="output">{{counter}}</p>
        </div>
    </form>
</template>

<script>


export default {
    data(){
        return {
            text: '',
            counter: 0
        }
    },

    watch:{
      text: function(str){
        this.counter = str.trim().split(/\s+/).length;
        if(this.text === ''){
          this.counter = 0;
        }
      }
    }
}
</script>
<style>
  .output{
    font-size: 20px;
  }
</style>
