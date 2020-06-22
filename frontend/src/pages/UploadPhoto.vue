<template>
    <div>
        <v-app>
        <main-layout></main-layout>
            <v-container>
                <vue-dropzone
                        ref="myVueDropzone"
                        id="dropzone"
                        class="row mb-2"
                        :options="dropzoneOptions"
                        v-on:vdropzone-sending="sendingEvent">
                </vue-dropzone>
                <v-btn type="button" v-on:click="processFiles">Send images</v-btn>

                <v-text-field
                        v-model="description"
                        placeholder="Write your description"
                ></v-text-field>
                <v-combobox
                        v-model="selectedTags"
                        label="Write your tags"
                        multiple
                        chips>
                </v-combobox>
                <v-select
                        v-model="selectedFilters"
                        :items="filters"
                        attach
                        chips
                        label="Select filters"
                        multiple
                ></v-select>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    import Vue from 'vue'
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import '@mdi/font/css/materialdesignicons.css'
    import 'vuetify/dist/vuetify.min.css'
    import Vuetify from 'vuetify'
    import MainLayout from '../layouts/Main.vue'

    Vue.use(Vuetify)

    export default {
        vuetify: new Vuetify(),
        components: {
            MainLayout,
            vueDropzone: vue2Dropzone,
        },
        data: () => ({
            filters: ['sepia', 'desaturate'],
            selectedFilters: [],
            selectedTags: [],
            description: null,
            dropzoneOptions: {
                url: 'http://localhost:8080/photo',
                thumbnailWidth: 350,
                maxFilesize: 3,
                autoProcessQueue: false,
            },
        }),
        methods: {
            'processFiles': function () {
                this.$refs.myVueDropzone.processQueue()
            },
            sendingEvent(file, xhr, formData) {
                const description = this.description
                const tags = this.selectedTags
                const filters = this.selectedFilters
                formData.append('description', description);
                formData.append('tags', tags);
                formData.append('filters', filters);

            },
        },
    }
</script>

<style>
    .vue-dropzone > .dz-preview .dz-image {
        height: auto;
    }

    .vue-dropzone .dz-preview.dz-success .dz-success-mark {
        color: #fff;
        opacity: 1;
        -webkit-animation: none;
        animation: none;
    }

    .vue-dropzone > .dz-preview .dz-error-mark {
        color: #fff;
    }

    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 30px;
    }

    h3 {
        margin: 40px 0 0;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>
