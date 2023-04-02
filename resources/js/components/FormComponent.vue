<template>
<form class="shadow-md bg-white p-10" @submit="submit()">
  <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Submit Form</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600">Please note all fields are required.</p>

      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-3">

          <label for="company" class="block text-sm font-medium leading-6 text-gray-900">Company Symbol</label>
          <div class="mt-2">
            <select id="company" name="company" autocomplete="company-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="data.company_symbol" required>
                <option disabled selected>Filter By Typing</option>
                <option v-for="company in companies" :key="company.id" :value="company.Symbol">{{ company.Symbol + ' - ' + company['Company Name']}}</option>
            </select>

            <error-message :errors="errors" v-if="errors.company_symbol" />
          </div>

        </div>

        <div class="sm:col-span-3">
          <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
          <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" placeholder="Enter email address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" v-model="data.email" required>

            <error-message :errors="errors" v-if="errors.email" />
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="start-date" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
          <div class="mt-2">
            <VueDatePicker v-model="data.start_date" :format="format" :state="errors.start_date ? false : null" auto-apply  />

            <error-message :errors="errors" v-if="errors.start_date" />
          </div>
        </div>

        <div class="sm:col-span-3">
          <label for="end-date" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
          <div class="mt-2">
            <VueDatePicker v-model="data.end_date" :format="format" :state="errors.end_date ? false : null" auto-apply  />

            <error-message :errors="errors" v-if="errors.end_date" />
          </div>
        </div>

        
      </div>
    </div>
  </div>

  <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>
</form>

</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import ErrorMessage from '../components/ErrorMessage'
    import api from '../api'

    export default {
        name: 'FormComponent',
        components: {
            ErrorMessage
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
                    company_symbol: '',
                    email: '',
                    start_date: '',
                    end_date: ''
                },
                format: 'Y-MM-dd'
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
                api.post('/api/company', this.data)
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    })
            }
        }
    }
</script>