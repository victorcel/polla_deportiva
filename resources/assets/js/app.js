
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app',
    data() {
        return {
            mensaje: [],
            lector: [],
            cantidad: 0,
            slug:''
        };

    },
    computed: {
        getCedula() {
            return this.mensaje.concat().join('')
        },
        getDirConfir(){
            return "cart/confir/"+this.slug
        },
        getDirAdd(){
            return "cart/add/"+this.slug
        }

    },
    methods: {
        getLector() {
            // alert('Funciona ' + this.lector);
            $('#edit').modal('show');
            //return this.mensaje.concat().join('')
        },
        borrarCedula() {
            this.lector = []
        },
        borrarTarjeta() {
            this.mensaje = []
        },
        sumarCantidad() {
            this.cantidad += 1;
            this.$emit('increment')
        },
        restarCantidad() {
            this.cantidad -= 1;
        },
        getSlug($dato) {
            this.slug = $dato;
        }
    }
});
