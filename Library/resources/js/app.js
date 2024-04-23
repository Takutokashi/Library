import './bootstrap'
 import router from './router.js'
import {createApp} from "vue";
import MainComponent from "./components/MainComponent.vue";
 import store from "./components/store.js";




const app = createApp(MainComponent)
{
    app.use(router);
     app.use(store);

    app.mount('#app');
}













// import './bootstrap';
// import { createApp } from 'vue';
//
// const app = createApp({});
// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);
//
// app.mount('#app');
