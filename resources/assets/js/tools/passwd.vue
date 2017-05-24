<template>
    <form>
        <switches v-model="action" :selected="action" :label="switch_label" type-bold="true" theme="bulma" color="blue"></switches>
        <div v-if="action">
          <div class="form-group">
              <label>Password</label>
              <input v-model="passwd" type="text" class="form-control">
              <label>Password Length</label>
              <input type="number" v-model="length" class="form-control form-width">
              <label>Special Characters</label><br>
              <switches v-model="specialChar" :selected="specialChar" :label="specChar_label" type-bold="true" theme="bulma" color="red"></switches>
          </div>
          <button class="btn btn-primary" @click.prevent="getPasswd" :disabled="isFloat(length)">New Password</button>
        </div>
        <div v-else>
          <div class="form-group">
              <label>Password</label>
              <input v-model="passwd" type="text" class="form-control">
          </div>
          <button class="btn btn-primary" @click.prevent="getPasswd">New Password</button>
        </div>

    </form>
</template>

<script>

import Switches from 'vue-switches';

export default {
    data(){
        return {
            length: null,
            passwd: '',
            specialChar: true,
            action: false
        }
    },

    mounted(){
        this.getPasswd()
    },
    computed: {
        switch_label: function(){
            return this.action ? 'Advanced' : 'Simple';
        },
        specChar_label: function(){
            return this.specialChar ? 'Yes' : 'No';
        }
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
            },
        isFloat: function(x) { return !!(x % 1); }

    },
    components: {
        Switches
    }
}
</script>
<style>
  .form-width{
    width: 7%;
  }
</style>
