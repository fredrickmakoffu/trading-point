<template>
    <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px">
            <li v-for="tab in tabs" :key="tab">
                <a class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" 
                    href="#" 
                    v-if="active_tab != tab"
                    @click="updateTab(tab)">{{ tab }}</a>

                <a class="inline-block p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500" 
                    href="#" 
                    v-if="active_tab == tab">{{ tab }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'TabComponent',
        props: {
            tabs: {
                required: true,
                type: Array,
                default: []
            },
            active_tab: {
                required: true,
                type: String
            }
        },
        methods: {
            updateTab(tab) {
                // emit to parent component
                this.$emit('switchTab', tab)
            }
        }
    }
</script>