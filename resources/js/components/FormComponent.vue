<template>
    <h2>Form</h2>
</template>


<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        name: 'FormComponent',
        data() {
            return {
                name: '',
                email: '',
                message: '',
                errors: []
            }
        },
        mounted() {
            this.fetchCompanies()
        },
        methods: {
            ...mapActions({
                fetchCompanies: 'company/fetchCompanies'
            })
        }
    }
</script>