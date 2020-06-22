<template>
    <div>
        <v-app>
            <main-layout></main-layout>
            <v-container>
                <v-row>
                    <v-col cols="12" md="8">
                        <v-card color="teal" dark>
                            <v-card-text>
                                <v-combobox
                                        v-model="selectedPhotos"
                                        :items="photos"
                                        :loading="isMakingRequest"
                                        :search-input.sync="search"
                                        autocomplete="off"
                                        item-text="description"
                                        label="Start writing your description"
                                        return-object
                                ></v-combobox>
                            </v-card-text>
                        </v-card>
                        <v-row>
                            <v-col cols="12" md="3" v-for="item in photos" v-bind:key="item.id">
                                <v-card>
                                    <v-img
                                            :src="'http://localhost:8080/uploads/' + item.nameURL"
                                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                                            class="white--text align-end">
                                        <v-card-title>{{item.filter}}</v-card-title>
                                    </v-img>
                                    <v-card-text>{{item.description}}</v-card-text>
                                    <v-chip-group selection active-class="deep-purple accent-4 white--text"
                                                  v-if="item.tags.length">
                                        <v-chip text v-for="(tag, index) in item.tags" :key="index">#{{tag}}</v-chip>
                                    </v-chip-group>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="6" md="4">
                        <v-card class="pa-2" outlined tile>
                            <v-combobox
                                    v-model="selectedTags"
                                    label="Write your tags to search"
                                    @change="getPhotosFromBackend()"
                                    multiple
                                    chips>
                            </v-combobox>
                            <v-combobox
                                    v-model="selectedFilters"
                                    label="Write your filters to search"
                                    @change="getPhotosFromBackend()"
                                    multiple
                                    chips
                            ></v-combobox>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    import Vue from 'vue'
    import '@mdi/font/css/materialdesignicons.css'
    import 'vuetify/dist/vuetify.min.css'
    import Vuetify from 'vuetify'
    import MainLayout from '../layouts/Main.vue'

    Vue.use(Vuetify)

    export default {
        vuetify: new Vuetify(),
        components: {
            MainLayout,
        },
        data: () => ({
            photos: [],
            selectedPhotos: null,
            selectedTags: null,
            selectedFilters: null,
            isMakingRequest: false,
            search: null,
            queryDescriptionTerm: ""
        }),
        methods: {
            getPhotosFromBackend() {
                if (true === this.isMakingRequest) return

                if (null === this.queryDescriptionTerm || '' === this.queryDescriptionTerm) return

                this.isMakingRequest = true

                let url = 'http://localhost:8080/photo?filters[description]=' + this.queryDescriptionTerm

                if (null !== this.selectedTags && '' !== this.selectedTags) {
                    url += '&filters[tags]=' + this.selectedTags
                }
                if (null !== this.selectedFilters && '' !== this.selectedFilters) {
                    url += '&filters[filter]=' + this.selectedFilters
                }
                fetch(url)
                    .then(responseFromServer => responseFromServer.json())
                    .then(res => {
                        this.photos = res
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => (this.isMakingRequest = false))
            }
        },
        watch: {
            search(val) {
                this.queryDescriptionTerm = val
                this.getPhotosFromBackend()
            },
            isUpdating(val) {
                if (val) {
                    setTimeout(() => (this.isMakingRequest = false), 3000)
                }
            },
        },

    }
</script>

<style>

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
