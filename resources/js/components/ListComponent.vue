<template>  
    <div>
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-10">
            <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>                 
                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        Date
                    </th>

                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        Open
                    </th>

                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        High
                    </th>

                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        Low
                    </th>

                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        Close
                    </th>

                    <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        Volume
                    </th>
                </tr>
            </thead>
            
            <tbody v-if="data" class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                <tr v-for="({date, open, high, low, close, volume}, index) in data" :key="index">
                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ date }}</h2>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ open }}</h2>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ high }}</h2>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ low }}</h2>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ close }}</h2>
                        </div>
                    </td>

                    <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">{{ volume }}</h2>
                        </div>
                    </td>
                </tr>
            </tbody>


            <tbody v-if=" !data" class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                <tr>
                    <td colspan="11" class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                        <div>
                            <h2 class="font-medium text-gray-700 dark:text-white ">No Data Found</h2>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6 sm:flex sm:items-center sm:justify-between ">
          <div class="text-sm text-gray-500 dark:text-gray-400">
              Page <span class="font-medium text-gray-700 dark:text-gray-100">{{ this.page }} out of {{ this.total_data }}</span> 
          </div>

          <div class="flex items-center mt-4 gap-x-4 sm:mt-0">
                <button type="button" class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800" @click="previousPage()" id="previous">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>

                    <span>
                        previous
                    </span>
                </button>

                <button class="flex items-center justify-center w-1/2 px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md sm:w-auto gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800" @click="nextPage()" id="next">
                    <span>
                        Next
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </button>
          </div>
      </div>
    </div>
</template>

<script>

    export default {
        name: 'ListComponent',
        props: {
            data: {
                required: true,
                type: Array
            },
            total_data: {
                required: true,
                type: Number
            }
        },
        data() {
            return {
                page: 1,
                size: 10
            }
        },
        // mounted() {
        //     console.log(this.data)
        // },
        methods: {
            previousPage() {
                if (this.page > 1) {
                    this.page = this.page - 1
                    this.$emit('updateData', {
                        page: this.page,
                        size: this.size
                    })
                }
            },
            nextPage() {
                if (this.page < this.data.length) {
                    this.page = this.page + 1
                    this.$emit('updateData', {
                        page: this.page,
                        size: this.size
                    })
                }
            }
        }
    }

</script>