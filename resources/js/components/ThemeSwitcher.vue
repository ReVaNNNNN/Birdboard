<template>
    <div class="flex items-center mr-8">
        <button class="rounded-full w-4 h-4 bg-default border border-accent mr-2" @click="selectedTheme = 'theme-light'"></button>
        <button class="rounded-full w-4 h-4 bg-default border border-accent mr-2" @click="selectedTheme = 'theme-dark'"></button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selectedTheme: 'theme-light'
            }
        },

        watch: {
            selectedTheme() {
                alert('changed');
            }
        }
    }
</script>
