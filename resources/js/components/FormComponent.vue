<template>
    <div>
        <form class="shadow-md bg-white p-10" @submit.prevent="submit()">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 text-gray-900">Submit Form</h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">Please note all fields are required.</p>

                <alert-component :alert="alert" />

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">

                        <label for="company" class="block text-sm font-medium leading-6 text-gray-900">Company Symbol</label>
                        <div class="mt-2">
                            <select id="company" name="company" autocomplete="company-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="data.company_symbol" required>
                                <option disabled selected>Filter By Typing</option>
                                <option v-for="company in companies" :key="company.id" :value="company.Symbol + '-' + company['Company Name']">{{ company.Symbol + ' - ' + company['Company Name']}}</option>
                            </select>

                            <error-message :errors="errors.company_symbol" v-if="errors.company_symbol" />
                        </div>

                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" placeholder="Enter email address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="data.email" required>

                            <error-message :errors="errors.email" v-if="errors.email" />
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="start-date" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                        <div class="mt-2">
                            <VueDatePicker v-model="data.start_date" :format="format" auto-apply :required="true"  />

                            <error-message :errors="errors.start_date" v-if="errors.start_date" />
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="end-date" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                        <div class="mt-2">
                            <VueDatePicker v-model="data.end_date" :format="format" auto-apply :required="true"  />

                            <error-message :errors="errors.end_date" v-if="errors.end_date" />
                        </div>
                    </div>

                    
                </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" :disabled="this.alert.loading">Save</button>
            </div>
        </form>

        <section id="data" class="shadow-md bg-white p-10 mt-10" v-if="historical_data.length > 0">
            <tab-component 
                :tabs="tabs"
                :active_tab="tab"
                @switchTab="switchTab" />

            <list-component 
                :data="list_data"
                :total="historical_data.length"
                @updateData="updateData"
                v-show="tab == 'Historical Data'" />

            <chart-component
                :data="historical_data"
                v-if="tab == 'Visual Data'" />

        </section>
    </div>

</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import ErrorMessage from '../components/ErrorMessage'
    import ListComponent from './ListComponent'
    import TabComponent from './TabComponent'
    import AlertComponent from './AlertComponent'
    import ChartComponent from './ChartComponent'
    import api from '../api'

    export default {
        name: 'FormComponent',
        components: {
            ErrorMessage,
            TabComponent,
            ListComponent,
            AlertComponent,
            ChartComponent
        },
        data() {
            return {
                data: {
                    company_symbol: '',
                    email: '',
                    start_date: '',
                    end_date: ''
                },
                errors: {
                    company_symbol: null,
                    email: null,
                    start_date: null,
                    end_date: null
                },
                format: 'Y-MM-dd',
                tabs: ['Historical Data', 'Visual Data'],
                tab: 'Historical Data',
                historical_data: [],
                list_data: [],
                alert: {
                    loading: false,
                    success: false,
                    error: false
                }
            }
        },
        computed: {
            ...mapGetters({
                companies: 'company/companies'
            })
        },
        mounted() {
            this.fetchCompanies()
        },
        methods: {
            ...mapActions({
                fetchCompanies: 'company/fetchCompanies'
            }),
            submit() {
                this.alert.loading = true
                let company_symbol = this.data.company_symbol.split('-')[0]
                let company_name = this.data.company_symbol.split('-')[1]
                
                this.data.company_symbol = company_symbol
                this.data.company_name = company_name
                
                // unset historical data
                this.historical_data = []

                api.post('/api/company', this.data)
                    .then(response => {
                        this.alert.loading = false
                        this.setAlert(true, response.message)

                        if(response.errors) {
                            this.errors = response.errors
                        } else {
                            return response.data
                        }
                    })
                    .then(data => {
                        if(data) {
                            this.resetErrors()
                            
                            this.historical_data = data
                            this.updateData({
                                page: 1,
                                size: 25
                            })
                        }
                    })
            },
            resetErrors() {
                this.errors = {
                    company_symbol: null,
                    email: null,
                    start_date: null,
                    end_date: null
                }
            },
            switchTab(tab) {
                this.tab = tab
            },
            updateData({page, size}) {
                let first_index = (page - 1) * size
                let last_index = page * size
                
                if(last_index > this.historical_data.length)
                    last_index = this.historical_data.length

                this.list_data = this.historical_data.slice(first_index, last_index);
            },
            setAlert(state, message) {
                if(state) {
                    this.alert.error = false
                    this.alert.success = true
                } else {
                    this.alert.error = true
                    this.alert.success = false
                }

                this.alert.message = message

                setTimeout(() => {
                    this.resetAlert()
                }, 2000);
            },
            resetAlert() {
                this.alert.error = false
                this.alert.success = false
                this.alert.loading = false
                this.alert.message = null
            }
        }
    }
</script>