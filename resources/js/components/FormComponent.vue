<template>
    <div>
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

        <section id="data" class="shadow-md bg-white p-10 mt-10">
            <tab-component 
                :tabs="tabs"
                @switchTab="switchTab" />

            <list-component 
                :data="historical_data"
                v-if="tab == 'Historical Data' || !historical_data.length" />

        </section>
    </div>

</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import ErrorMessage from '../components/ErrorMessage'
    import ListComponent from './ListComponent'
    import TabComponent from './TabComponent'
    import api from '../api'

    export default {
        name: 'FormComponent',
        components: {
            ErrorMessage,
            TabComponent,
            ListComponent
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
                format: 'Y-MM-dd',
                tabs: ['Historical Data', 'Visual Data'],
                tab: 'Historical Data',
                historical_data: [
                    {
                        "date": "2022-06-30T04:00:00.000Z",
                        "open": 137.25,
                        "high": 138.369995,
                        "low": 133.770004,
                        "close": 136.720001,
                        "adjClose": 136.304245,
                        "volume": 98964500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-29T04:00:00.000Z",
                        "open": 137.460007,
                        "high": 140.669998,
                        "low": 136.669998,
                        "close": 139.229996,
                        "adjClose": 138.80661,
                        "volume": 66242400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-28T04:00:00.000Z",
                        "open": 142.130005,
                        "high": 143.419998,
                        "low": 137.320007,
                        "close": 137.440002,
                        "adjClose": 137.022064,
                        "volume": 67083400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-27T04:00:00.000Z",
                        "open": 142.699997,
                        "high": 143.490005,
                        "low": 140.970001,
                        "close": 141.660004,
                        "adjClose": 141.229218,
                        "volume": 70207900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-24T04:00:00.000Z",
                        "open": 139.899994,
                        "high": 141.910004,
                        "low": 139.770004,
                        "close": 141.660004,
                        "adjClose": 141.229218,
                        "volume": 89116800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-23T04:00:00.000Z",
                        "open": 136.820007,
                        "high": 138.589996,
                        "low": 135.630005,
                        "close": 138.270004,
                        "adjClose": 137.849533,
                        "volume": 72433800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-22T04:00:00.000Z",
                        "open": 134.789993,
                        "high": 137.759995,
                        "low": 133.910004,
                        "close": 135.350006,
                        "adjClose": 134.938416,
                        "volume": 73409200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-21T04:00:00.000Z",
                        "open": 133.419998,
                        "high": 137.059998,
                        "low": 133.320007,
                        "close": 135.869995,
                        "adjClose": 135.456833,
                        "volume": 81000500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-17T04:00:00.000Z",
                        "open": 130.070007,
                        "high": 133.080002,
                        "low": 129.809998,
                        "close": 131.559998,
                        "adjClose": 131.159927,
                        "volume": 134520300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-16T04:00:00.000Z",
                        "open": 132.080002,
                        "high": 132.389999,
                        "low": 129.039993,
                        "close": 130.059998,
                        "adjClose": 129.66449,
                        "volume": 108123900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-15T04:00:00.000Z",
                        "open": 134.289993,
                        "high": 137.339996,
                        "low": 132.160004,
                        "close": 135.429993,
                        "adjClose": 135.018158,
                        "volume": 91533000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-14T04:00:00.000Z",
                        "open": 133.130005,
                        "high": 133.889999,
                        "low": 131.479996,
                        "close": 132.759995,
                        "adjClose": 132.356277,
                        "volume": 84784300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-13T04:00:00.000Z",
                        "open": 132.869995,
                        "high": 135.199997,
                        "low": 131.440002,
                        "close": 131.880005,
                        "adjClose": 131.478958,
                        "volume": 122207100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-10T04:00:00.000Z",
                        "open": 140.279999,
                        "high": 140.759995,
                        "low": 137.059998,
                        "close": 137.130005,
                        "adjClose": 136.712997,
                        "volume": 91437900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-09T04:00:00.000Z",
                        "open": 147.080002,
                        "high": 147.949997,
                        "low": 142.529999,
                        "close": 142.639999,
                        "adjClose": 142.206238,
                        "volume": 69473000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-08T04:00:00.000Z",
                        "open": 148.580002,
                        "high": 149.869995,
                        "low": 147.460007,
                        "close": 147.960007,
                        "adjClose": 147.510071,
                        "volume": 53950200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-07T04:00:00.000Z",
                        "open": 144.350006,
                        "high": 149,
                        "low": 144.100006,
                        "close": 148.710007,
                        "adjClose": 148.257782,
                        "volume": 67808200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-06T04:00:00.000Z",
                        "open": 147.029999,
                        "high": 148.570007,
                        "low": 144.899994,
                        "close": 146.139999,
                        "adjClose": 145.695602,
                        "volume": 71598400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-03T04:00:00.000Z",
                        "open": 146.899994,
                        "high": 147.970001,
                        "low": 144.460007,
                        "close": 145.380005,
                        "adjClose": 144.937912,
                        "volume": 88570300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-02T04:00:00.000Z",
                        "open": 147.830002,
                        "high": 151.270004,
                        "low": 146.860001,
                        "close": 151.210007,
                        "adjClose": 150.750183,
                        "volume": 72348100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-06-01T04:00:00.000Z",
                        "open": 149.899994,
                        "high": 151.740005,
                        "low": 147.679993,
                        "close": 148.710007,
                        "adjClose": 148.257782,
                        "volume": 74286600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-31T04:00:00.000Z",
                        "open": 149.070007,
                        "high": 150.660004,
                        "low": 146.839996,
                        "close": 148.839996,
                        "adjClose": 148.38739,
                        "volume": 103718400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-27T04:00:00.000Z",
                        "open": 145.389999,
                        "high": 149.679993,
                        "low": 145.259995,
                        "close": 149.639999,
                        "adjClose": 149.184952,
                        "volume": 90978500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-26T04:00:00.000Z",
                        "open": 137.389999,
                        "high": 144.339996,
                        "low": 137.139999,
                        "close": 143.779999,
                        "adjClose": 143.342758,
                        "volume": 90601500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-25T04:00:00.000Z",
                        "open": 138.429993,
                        "high": 141.789993,
                        "low": 138.339996,
                        "close": 140.520004,
                        "adjClose": 140.092697,
                        "volume": 92482700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-24T04:00:00.000Z",
                        "open": 140.809998,
                        "high": 141.970001,
                        "low": 137.330002,
                        "close": 140.360001,
                        "adjClose": 139.933167,
                        "volume": 104132700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-23T04:00:00.000Z",
                        "open": 137.789993,
                        "high": 143.259995,
                        "low": 137.649994,
                        "close": 143.110001,
                        "adjClose": 142.674805,
                        "volume": 117726300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-20T04:00:00.000Z",
                        "open": 139.089996,
                        "high": 140.699997,
                        "low": 132.610001,
                        "close": 137.589996,
                        "adjClose": 137.171585,
                        "volume": 137426100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-19T04:00:00.000Z",
                        "open": 139.880005,
                        "high": 141.660004,
                        "low": 136.600006,
                        "close": 137.350006,
                        "adjClose": 136.932327,
                        "volume": 136095600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-18T04:00:00.000Z",
                        "open": 146.850006,
                        "high": 147.360001,
                        "low": 139.899994,
                        "close": 140.820007,
                        "adjClose": 140.391785,
                        "volume": 109742900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-17T04:00:00.000Z",
                        "open": 148.860001,
                        "high": 149.770004,
                        "low": 146.679993,
                        "close": 149.240005,
                        "adjClose": 148.786179,
                        "volume": 78336300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-16T04:00:00.000Z",
                        "open": 145.550003,
                        "high": 147.520004,
                        "low": 144.179993,
                        "close": 145.539993,
                        "adjClose": 145.097427,
                        "volume": 86643800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-13T04:00:00.000Z",
                        "open": 144.589996,
                        "high": 148.100006,
                        "low": 143.110001,
                        "close": 147.110001,
                        "adjClose": 146.662659,
                        "volume": 113990900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-12T04:00:00.000Z",
                        "open": 142.770004,
                        "high": 146.199997,
                        "low": 138.800003,
                        "close": 142.559998,
                        "adjClose": 142.12648,
                        "volume": 182602000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-11T04:00:00.000Z",
                        "open": 153.5,
                        "high": 155.449997,
                        "low": 145.809998,
                        "close": 146.5,
                        "adjClose": 146.054504,
                        "volume": 142689800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-10T04:00:00.000Z",
                        "open": 155.520004,
                        "high": 156.740005,
                        "low": 152.929993,
                        "close": 154.509995,
                        "adjClose": 154.040131,
                        "volume": 115366700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-09T04:00:00.000Z",
                        "open": 154.929993,
                        "high": 155.830002,
                        "low": 151.490005,
                        "close": 152.059998,
                        "adjClose": 151.597595,
                        "volume": 131577900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-06T04:00:00.000Z",
                        "open": 156.009995,
                        "high": 159.440002,
                        "low": 154.179993,
                        "close": 157.279999,
                        "adjClose": 156.801712,
                        "volume": 116124600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-05T04:00:00.000Z",
                        "open": 163.850006,
                        "high": 164.080002,
                        "low": 154.949997,
                        "close": 156.770004,
                        "adjClose": 156.063995,
                        "volume": 130525300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-04T04:00:00.000Z",
                        "open": 159.669998,
                        "high": 166.479996,
                        "low": 159.259995,
                        "close": 166.020004,
                        "adjClose": 165.272324,
                        "volume": 108256500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-03T04:00:00.000Z",
                        "open": 158.149994,
                        "high": 160.710007,
                        "low": 156.320007,
                        "close": 159.479996,
                        "adjClose": 158.761765,
                        "volume": 88966500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-05-02T04:00:00.000Z",
                        "open": 156.710007,
                        "high": 158.229996,
                        "low": 153.270004,
                        "close": 157.960007,
                        "adjClose": 157.248627,
                        "volume": 123055300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-29T04:00:00.000Z",
                        "open": 161.839996,
                        "high": 166.199997,
                        "low": 157.25,
                        "close": 157.649994,
                        "adjClose": 156.940002,
                        "volume": 131747600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-28T04:00:00.000Z",
                        "open": 159.25,
                        "high": 164.520004,
                        "low": 158.929993,
                        "close": 163.639999,
                        "adjClose": 162.90303,
                        "volume": 130216800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-27T04:00:00.000Z",
                        "open": 155.910004,
                        "high": 159.789993,
                        "low": 155.380005,
                        "close": 156.570007,
                        "adjClose": 155.864883,
                        "volume": 88063200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-26T04:00:00.000Z",
                        "open": 162.25,
                        "high": 162.339996,
                        "low": 156.720001,
                        "close": 156.800003,
                        "adjClose": 156.093842,
                        "volume": 95623200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-25T04:00:00.000Z",
                        "open": 161.119995,
                        "high": 163.169998,
                        "low": 158.460007,
                        "close": 162.880005,
                        "adjClose": 162.146454,
                        "volume": 96046400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-22T04:00:00.000Z",
                        "open": 166.460007,
                        "high": 167.869995,
                        "low": 161.5,
                        "close": 161.789993,
                        "adjClose": 161.06134,
                        "volume": 84882400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-21T04:00:00.000Z",
                        "open": 168.910004,
                        "high": 171.529999,
                        "low": 165.910004,
                        "close": 166.419998,
                        "adjClose": 165.670517,
                        "volume": 87227800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-20T04:00:00.000Z",
                        "open": 168.759995,
                        "high": 168.880005,
                        "low": 166.100006,
                        "close": 167.229996,
                        "adjClose": 166.476868,
                        "volume": 67929800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-19T04:00:00.000Z",
                        "open": 165.020004,
                        "high": 167.820007,
                        "low": 163.910004,
                        "close": 167.399994,
                        "adjClose": 166.646088,
                        "volume": 67723800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-18T04:00:00.000Z",
                        "open": 163.919998,
                        "high": 166.600006,
                        "low": 163.570007,
                        "close": 165.070007,
                        "adjClose": 164.326599,
                        "volume": 69023900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-14T04:00:00.000Z",
                        "open": 170.619995,
                        "high": 171.270004,
                        "low": 165.039993,
                        "close": 165.289993,
                        "adjClose": 164.545593,
                        "volume": 75329400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-13T04:00:00.000Z",
                        "open": 167.389999,
                        "high": 171.039993,
                        "low": 166.770004,
                        "close": 170.399994,
                        "adjClose": 169.632584,
                        "volume": 70618900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-12T04:00:00.000Z",
                        "open": 168.020004,
                        "high": 169.869995,
                        "low": 166.639999,
                        "close": 167.660004,
                        "adjClose": 166.904938,
                        "volume": 79265200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-11T04:00:00.000Z",
                        "open": 168.710007,
                        "high": 169.029999,
                        "low": 165.5,
                        "close": 165.75,
                        "adjClose": 165.003525,
                        "volume": 72246700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-08T04:00:00.000Z",
                        "open": 171.779999,
                        "high": 171.779999,
                        "low": 169.199997,
                        "close": 170.089996,
                        "adjClose": 169.32399,
                        "volume": 76575500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-07T04:00:00.000Z",
                        "open": 171.160004,
                        "high": 173.360001,
                        "low": 169.850006,
                        "close": 172.139999,
                        "adjClose": 171.364746,
                        "volume": 77594700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-06T04:00:00.000Z",
                        "open": 172.360001,
                        "high": 173.630005,
                        "low": 170.130005,
                        "close": 171.830002,
                        "adjClose": 171.056152,
                        "volume": 89058800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-05T04:00:00.000Z",
                        "open": 177.5,
                        "high": 178.300003,
                        "low": 174.419998,
                        "close": 175.059998,
                        "adjClose": 174.271591,
                        "volume": 73401800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-04T04:00:00.000Z",
                        "open": 174.570007,
                        "high": 178.490005,
                        "low": 174.440002,
                        "close": 178.440002,
                        "adjClose": 177.636383,
                        "volume": 76468400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-04-01T04:00:00.000Z",
                        "open": 174.029999,
                        "high": 174.880005,
                        "low": 171.940002,
                        "close": 174.309998,
                        "adjClose": 173.524963,
                        "volume": 78751300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-31T04:00:00.000Z",
                        "open": 177.839996,
                        "high": 178.029999,
                        "low": 174.399994,
                        "close": 174.610001,
                        "adjClose": 173.823639,
                        "volume": 103049300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-30T04:00:00.000Z",
                        "open": 178.550003,
                        "high": 179.610001,
                        "low": 176.699997,
                        "close": 177.770004,
                        "adjClose": 176.969406,
                        "volume": 92633200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-29T04:00:00.000Z",
                        "open": 176.690002,
                        "high": 179.009995,
                        "low": 176.339996,
                        "close": 178.960007,
                        "adjClose": 178.154037,
                        "volume": 100589400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-28T04:00:00.000Z",
                        "open": 172.169998,
                        "high": 175.729996,
                        "low": 172,
                        "close": 175.600006,
                        "adjClose": 174.809189,
                        "volume": 90371900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-25T04:00:00.000Z",
                        "open": 173.880005,
                        "high": 175.279999,
                        "low": 172.75,
                        "close": 174.720001,
                        "adjClose": 173.933136,
                        "volume": 80546200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-24T04:00:00.000Z",
                        "open": 171.059998,
                        "high": 174.139999,
                        "low": 170.210007,
                        "close": 174.070007,
                        "adjClose": 173.286057,
                        "volume": 90131400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-23T04:00:00.000Z",
                        "open": 167.990005,
                        "high": 172.639999,
                        "low": 167.649994,
                        "close": 170.210007,
                        "adjClose": 169.443451,
                        "volume": 98062700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-22T04:00:00.000Z",
                        "open": 165.509995,
                        "high": 169.419998,
                        "low": 164.910004,
                        "close": 168.820007,
                        "adjClose": 168.059723,
                        "volume": 81532000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-21T04:00:00.000Z",
                        "open": 163.509995,
                        "high": 166.350006,
                        "low": 163.009995,
                        "close": 165.380005,
                        "adjClose": 164.635193,
                        "volume": 95811400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-18T04:00:00.000Z",
                        "open": 160.509995,
                        "high": 164.479996,
                        "low": 159.759995,
                        "close": 163.979996,
                        "adjClose": 163.241501,
                        "volume": 123511700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-17T04:00:00.000Z",
                        "open": 158.610001,
                        "high": 161,
                        "low": 157.630005,
                        "close": 160.619995,
                        "adjClose": 159.896637,
                        "volume": 75615400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-16T04:00:00.000Z",
                        "open": 157.050003,
                        "high": 160,
                        "low": 154.460007,
                        "close": 159.589996,
                        "adjClose": 158.871262,
                        "volume": 102300200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-15T04:00:00.000Z",
                        "open": 150.899994,
                        "high": 155.570007,
                        "low": 150.380005,
                        "close": 155.089996,
                        "adjClose": 154.391541,
                        "volume": 92964300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-14T04:00:00.000Z",
                        "open": 151.449997,
                        "high": 154.119995,
                        "low": 150.100006,
                        "close": 150.619995,
                        "adjClose": 149.941666,
                        "volume": 108732100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-11T05:00:00.000Z",
                        "open": 158.929993,
                        "high": 159.279999,
                        "low": 154.5,
                        "close": 154.729996,
                        "adjClose": 154.033157,
                        "volume": 96970100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-10T05:00:00.000Z",
                        "open": 160.199997,
                        "high": 160.389999,
                        "low": 155.979996,
                        "close": 158.520004,
                        "adjClose": 157.806107,
                        "volume": 105342000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-09T05:00:00.000Z",
                        "open": 161.479996,
                        "high": 163.410004,
                        "low": 159.410004,
                        "close": 162.949997,
                        "adjClose": 162.216141,
                        "volume": 91454900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-08T05:00:00.000Z",
                        "open": 158.820007,
                        "high": 162.880005,
                        "low": 155.800003,
                        "close": 157.440002,
                        "adjClose": 156.730957,
                        "volume": 131148300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-07T05:00:00.000Z",
                        "open": 163.360001,
                        "high": 165.020004,
                        "low": 159.039993,
                        "close": 159.300003,
                        "adjClose": 158.582581,
                        "volume": 96418800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-04T05:00:00.000Z",
                        "open": 164.490005,
                        "high": 165.550003,
                        "low": 162.100006,
                        "close": 163.169998,
                        "adjClose": 162.43515,
                        "volume": 83737200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-03T05:00:00.000Z",
                        "open": 168.470001,
                        "high": 168.910004,
                        "low": 165.550003,
                        "close": 166.229996,
                        "adjClose": 165.481369,
                        "volume": 76678400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-02T05:00:00.000Z",
                        "open": 164.389999,
                        "high": 167.360001,
                        "low": 162.949997,
                        "close": 166.559998,
                        "adjClose": 165.809875,
                        "volume": 79724800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-03-01T05:00:00.000Z",
                        "open": 164.699997,
                        "high": 166.600006,
                        "low": 161.970001,
                        "close": 163.199997,
                        "adjClose": 162.465012,
                        "volume": 83474400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-28T05:00:00.000Z",
                        "open": 163.059998,
                        "high": 165.419998,
                        "low": 162.429993,
                        "close": 165.119995,
                        "adjClose": 164.376373,
                        "volume": 95056600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-25T05:00:00.000Z",
                        "open": 163.839996,
                        "high": 165.119995,
                        "low": 160.869995,
                        "close": 164.850006,
                        "adjClose": 164.10759,
                        "volume": 91974200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-24T05:00:00.000Z",
                        "open": 152.580002,
                        "high": 162.850006,
                        "low": 152,
                        "close": 162.740005,
                        "adjClose": 162.00708,
                        "volume": 141147500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-23T05:00:00.000Z",
                        "open": 165.539993,
                        "high": 166.149994,
                        "low": 159.75,
                        "close": 160.070007,
                        "adjClose": 159.349121,
                        "volume": 90009200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-22T05:00:00.000Z",
                        "open": 164.979996,
                        "high": 166.690002,
                        "low": 162.149994,
                        "close": 164.320007,
                        "adjClose": 163.579971,
                        "volume": 91162800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-18T05:00:00.000Z",
                        "open": 169.820007,
                        "high": 170.539993,
                        "low": 166.190002,
                        "close": 167.300003,
                        "adjClose": 166.546539,
                        "volume": 82772700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-17T05:00:00.000Z",
                        "open": 171.029999,
                        "high": 171.910004,
                        "low": 168.470001,
                        "close": 168.880005,
                        "adjClose": 168.119446,
                        "volume": 69589300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-16T05:00:00.000Z",
                        "open": 171.850006,
                        "high": 173.339996,
                        "low": 170.050003,
                        "close": 172.550003,
                        "adjClose": 171.772903,
                        "volume": 61177400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-15T05:00:00.000Z",
                        "open": 170.970001,
                        "high": 172.949997,
                        "low": 170.25,
                        "close": 172.789993,
                        "adjClose": 172.01181,
                        "volume": 62527400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-14T05:00:00.000Z",
                        "open": 167.369995,
                        "high": 169.580002,
                        "low": 166.559998,
                        "close": 168.880005,
                        "adjClose": 168.119446,
                        "volume": 86185500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-11T05:00:00.000Z",
                        "open": 172.330002,
                        "high": 173.080002,
                        "low": 168.039993,
                        "close": 168.639999,
                        "adjClose": 167.880524,
                        "volume": 98670700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-10T05:00:00.000Z",
                        "open": 174.139999,
                        "high": 175.479996,
                        "low": 171.550003,
                        "close": 172.119995,
                        "adjClose": 171.344833,
                        "volume": 90865900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-09T05:00:00.000Z",
                        "open": 176.050003,
                        "high": 176.649994,
                        "low": 174.899994,
                        "close": 176.279999,
                        "adjClose": 175.486099,
                        "volume": 71285000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-08T05:00:00.000Z",
                        "open": 171.729996,
                        "high": 175.350006,
                        "low": 171.429993,
                        "close": 174.830002,
                        "adjClose": 174.042633,
                        "volume": 74829200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-07T05:00:00.000Z",
                        "open": 172.860001,
                        "high": 173.949997,
                        "low": 170.949997,
                        "close": 171.660004,
                        "adjClose": 170.886917,
                        "volume": 77251200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-04T05:00:00.000Z",
                        "open": 171.679993,
                        "high": 174.100006,
                        "low": 170.679993,
                        "close": 172.389999,
                        "adjClose": 171.613632,
                        "volume": 82465400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-03T05:00:00.000Z",
                        "open": 174.479996,
                        "high": 176.240005,
                        "low": 172.119995,
                        "close": 172.899994,
                        "adjClose": 171.902313,
                        "volume": 89418100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-02T05:00:00.000Z",
                        "open": 174.75,
                        "high": 175.880005,
                        "low": 173.330002,
                        "close": 175.839996,
                        "adjClose": 174.825348,
                        "volume": 84914300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-02-01T05:00:00.000Z",
                        "open": 174.009995,
                        "high": 174.839996,
                        "low": 172.309998,
                        "close": 174.610001,
                        "adjClose": 173.602448,
                        "volume": 86213900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-31T05:00:00.000Z",
                        "open": 170.160004,
                        "high": 175,
                        "low": 169.509995,
                        "close": 174.779999,
                        "adjClose": 173.771469,
                        "volume": 115541600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-28T05:00:00.000Z",
                        "open": 165.710007,
                        "high": 170.350006,
                        "low": 162.800003,
                        "close": 170.330002,
                        "adjClose": 169.347153,
                        "volume": 179935700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-27T05:00:00.000Z",
                        "open": 162.449997,
                        "high": 163.839996,
                        "low": 158.279999,
                        "close": 159.220001,
                        "adjClose": 158.301254,
                        "volume": 121954600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-26T05:00:00.000Z",
                        "open": 163.5,
                        "high": 164.389999,
                        "low": 157.820007,
                        "close": 159.690002,
                        "adjClose": 158.768539,
                        "volume": 108275300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-25T05:00:00.000Z",
                        "open": 158.979996,
                        "high": 162.759995,
                        "low": 157.020004,
                        "close": 159.779999,
                        "adjClose": 158.858017,
                        "volume": 115798400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-24T05:00:00.000Z",
                        "open": 160.020004,
                        "high": 162.300003,
                        "low": 154.699997,
                        "close": 161.619995,
                        "adjClose": 160.687393,
                        "volume": 162294600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-21T05:00:00.000Z",
                        "open": 164.419998,
                        "high": 166.330002,
                        "low": 162.300003,
                        "close": 162.410004,
                        "adjClose": 161.472855,
                        "volume": 122848900,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-20T05:00:00.000Z",
                        "open": 166.979996,
                        "high": 169.679993,
                        "low": 164.179993,
                        "close": 164.509995,
                        "adjClose": 163.56073,
                        "volume": 91420500,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-19T05:00:00.000Z",
                        "open": 170,
                        "high": 171.080002,
                        "low": 165.940002,
                        "close": 166.229996,
                        "adjClose": 165.270798,
                        "volume": 94815000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-18T05:00:00.000Z",
                        "open": 171.509995,
                        "high": 172.539993,
                        "low": 169.410004,
                        "close": 169.800003,
                        "adjClose": 168.82019,
                        "volume": 90956700,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-14T05:00:00.000Z",
                        "open": 171.339996,
                        "high": 173.779999,
                        "low": 171.089996,
                        "close": 173.070007,
                        "adjClose": 172.071335,
                        "volume": 80440800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-13T05:00:00.000Z",
                        "open": 175.779999,
                        "high": 176.619995,
                        "low": 171.789993,
                        "close": 172.190002,
                        "adjClose": 171.196426,
                        "volume": 84505800,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-12T05:00:00.000Z",
                        "open": 176.119995,
                        "high": 177.179993,
                        "low": 174.820007,
                        "close": 175.529999,
                        "adjClose": 174.517136,
                        "volume": 74805200,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-11T05:00:00.000Z",
                        "open": 172.320007,
                        "high": 175.179993,
                        "low": 170.820007,
                        "close": 175.080002,
                        "adjClose": 174.069733,
                        "volume": 76138300,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-10T05:00:00.000Z",
                        "open": 169.080002,
                        "high": 172.5,
                        "low": 168.169998,
                        "close": 172.190002,
                        "adjClose": 171.196426,
                        "volume": 106765600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-07T05:00:00.000Z",
                        "open": 172.889999,
                        "high": 174.139999,
                        "low": 171.029999,
                        "close": 172.169998,
                        "adjClose": 171.176514,
                        "volume": 86709100,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-06T05:00:00.000Z",
                        "open": 172.699997,
                        "high": 175.300003,
                        "low": 171.639999,
                        "close": 172,
                        "adjClose": 171.007507,
                        "volume": 96904000,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-05T05:00:00.000Z",
                        "open": 179.610001,
                        "high": 180.169998,
                        "low": 174.639999,
                        "close": 174.919998,
                        "adjClose": 173.91066,
                        "volume": 94537600,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-04T05:00:00.000Z",
                        "open": 182.630005,
                        "high": 182.940002,
                        "low": 179.119995,
                        "close": 179.699997,
                        "adjClose": 178.663071,
                        "volume": 99310400,
                        "symbol": "AAPL"
                    },
                    {
                        "date": "2022-01-03T05:00:00.000Z",
                        "open": 177.830002,
                        "high": 182.880005,
                        "low": 177.710007,
                        "close": 182.009995,
                        "adjClose": 180.959732,
                        "volume": 104487900,
                        "symbol": "AAPL"
                    }
                ]
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
            },
            switchTab(tab) {
                this.tab = tab
            }
        }
    }
</script>