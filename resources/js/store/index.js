import { createStore } from 'vuex'
import company from './company.store';

const exportStore = createStore({
    modules: {
        company
    }
});

export default exportStore;