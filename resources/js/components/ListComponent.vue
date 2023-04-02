<template>
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-10">
        <thead class="bg-gray-50 dark:bg-gray-800">
            <tr>      
                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    #
                </th>             
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
                        <h2 class="font-medium text-gray-700 dark:text-white ">{{ index + 1 }}</h2>
                    </div>
                </td>
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
</template>

<script>

    export default {
        name: 'ListComponent',
        props: {
            data: {
                required: true,
                type: Array,
                default: []
            }
        },
        mounted() {
            console.log(this.data)
        }
    }

</script>