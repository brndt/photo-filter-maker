<template>
    <div class="container">
        <ul>
            <li>
                <v-link href="/search" class="mr-3">Search</v-link>
                <v-link href="/upload">Upload</v-link>
            </li>
        </ul>

        <slot></slot>
    </div>
</template>

<script>
    import VLink from '../components/VLink.vue'
    export default {
        components: {
            VLink
        }
    }
</script>

<style scoped>
    .container {
        max-width: 600px;
        min-width:100%;
        margin: 0 20px;
        padding: 15px 30px;
        background: #fff;
    }
</style>
