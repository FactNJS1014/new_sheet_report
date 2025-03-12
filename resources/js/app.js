import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import 'primeicons/primeicons.css'


import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row';                   // optional

// import $ from 'jquery'; // If you don't have jQuery already installed
// window.$ = window.jQuery = $;
// import 'datatables.net';
// import 'datatables.net-buttons';
// import 'jszip';
// import 'pdfmake';
// import 'datatables.net-buttons/js/buttons.html5.min.js';
// import 'datatables.net-buttons/js/buttons.print.min.js';


const app = createApp(App)
app.use(router)
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup);
app.component('Row', Row);


app.mount('#app')
