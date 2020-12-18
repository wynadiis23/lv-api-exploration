<template>
  
</template>

<script>
import axios from 'axios'
import Vue from 'vue'

let listTotalAmountPerId = null
export default {
    name: 'Customer',
    components: {

    },
    data (){
        return {

        }
    },

    mounted () {
        axios.all([
            axios.get('http://localhost:8000/api/getTotalAmountPerId')
        ])
        .then(axios.spread((totalAmountPerId) => {
            this.listTotalAmountPerId = totalAmountPerId.data.data
        }))
    }


}
</script>

<style>

</style>