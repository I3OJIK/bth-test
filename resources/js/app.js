import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import axios from 'axios';
// import 'primeflex/primeflex.css'
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config'
import Aura from '@primeuix/themes/aura'
import Button  from 'primevue/button'
import { definePreset } from '@primeuix/themes'
import ToastService from 'primevue/toastservice'
import {Dialog, InputText, Password, Select, InputNumber, Textarea } from 'primevue'

axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';

const MyPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{indigo.50}',
            100: '{indigo.100}',
            200: '{indigo.200}',
            300: '{indigo.300}',
            400: '{indigo.400}',
            500: '{indigo.500}',
            600: '{indigo.600}',
            700: '{indigo.700}',
            800: '{indigo.800}',
            900: '{indigo.900}',
            950: '{indigo.950}'
        }
    }
  });

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(PrimeVue, {
                theme: {
                    preset: MyPreset,
                },
            })
            .use(ToastService)
            .component('Button', Button)
            .component('InputText', InputText)
            .component('Password', Password)
            .component('InputNumber', InputNumber)
            .component('Textarea', Textarea)
            .component('Select', Select)
            .mount(el)
    },
})