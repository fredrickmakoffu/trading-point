require('./bootstrap')

import { createApp } from 'vue'
import store from './store'
import components from './components';

const app = createApp({})

app.use(store)

Object.entries(components).forEach(component => {
    app.component(component[0], component[1])
})

app.mount('#app')
