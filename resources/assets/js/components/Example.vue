<template>
    <div>
        <span v-if="this.counter !=0"><button style="width:50px;height: 50px;text-align: center;font-size: 20px" class="btn btn-danger" v-on:click="descrementCounter">-</button> </span>
        <input style="width:70px;height: 70px;text-align: center;font-size: 50px" min="0" max="100" v-model="counter" :id=getProd disabled>
        <span v-if="this.counter !=10"><button style="width:50px;height: 50px;text-align: center;;font-size: 20px"  class="btn btn-success" v-on:click="incrementCounter">+</button></span>
    </div>

</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                counter: 0,

            };
        },
        mounted() {

        },
        watch:{
            getId() {
                return concat('equipo_','hola')
            }
        },
        computed: {
            getProd() {
                return 'equipo_'+ this.message
            }
        },

        methods: {
            incrementCounter: function () {
                this.counter += 1
            },
            descrementCounter: function () {
                this.counter -= 1
            }
        },
    }
</script>
