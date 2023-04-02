<template>
    <small class="italic text-xs text-rose-700" v-for="(error, index) in errors" :key="index"> 
        <p class="mt-1 mb-0"> &bull; {{ error[index] }} </p>
    </small>
</template>

<script>
    export default {
        name: 'ErrorMessage',
        props: {
            errors: {
                type: Object,
                required: true
            }
        }
    }
</script>