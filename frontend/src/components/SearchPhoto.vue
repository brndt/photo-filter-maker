<template>
    <div id="app">
        <v-app id="inspire">
            <v-container>
                <v-row>
                    <v-col cols="12" md="8">
                        <v-card color="teal" dark>
                            <v-card-text>
                                <v-combobox
                                        v-model="selectedPhotos"
                                        :items="photos"
                                        :loading="isUpdating"
                                        :search-input.sync="search"
                                        autocomplete="off"
                                        item-text="description"
                                        label="Start writing your description"
                                        return-object
                                ></v-combobox>
                            </v-card-text>
                        </v-card>
                        <v-row>
                            <div v-for="item in items" v-bind:key="item.id" class="col-lg-3">
                                <v-card>
                                    <img class="card-img-top" :src="'http://localhost:8080/uploads/' + item.nameURL"
                                         alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{item.nameURL}}</h5>
                                        <p class="card-text">{{item.description}}</p>
                                        <span v-if="item.tags.length">
                                            <span
                                                    v-for="(tag, index) in item.tags"
                                                    :key="index"
                                                    class="mr-1">
                                                #{{tag}}
                                            </span>
                                        </span>
                                    </div>
                                </v-card>
                            </div>
                        </v-row>
                    </v-col>
                    <v-col
                            cols="6"
                            md="4"
                    >
                        <v-card
                                class="pa-2"
                                outlined
                                tile
                        >
                            <v-combobox
                                    v-model="selectedTags"
                                    label="Write your tags to search"
                                    @change="callServer()"
                                    multiple
                                    chips
                            ></v-combobox>
                            <v-combobox
                                    v-model="selectedFilters"
                                    label="Write your filters to search"
                                    @change="callServer()"

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
    import Vuetify from 'vuetify'
    import 'vuetify/dist/vuetify.min.css'

    Vue.use(Vuetify)

    export default {

        vuetify: new Vuetify(),
        data: () => ({
            descriptionLimit: 60,
            photos: [],
            selectedPhotos: null,
            selectedTags: null,
            selectedFilters: null,
            isUpdating: false,
            search: null,
            queryTerm: ""
        }),

        computed: {
            items() {
                return this.photos.map(entry => {
                    const filter = entry.filter.length > this.descriptionLimit
                        ? entry.filter.slice(0, this.descriptionLimit) + '...'
                        : entry.filter
                    return Object.assign({}, entry, {filter})
                })
            },
        },
        methods: {
            callServer() {
                console.log('im here')
                if (this.isUpdating) return

                if (0 === this.queryTerm.length) return

                this.isUpdating = true

                let url = 'http://localhost:8080/photo?filters[description]=' + this.queryTerm

                if (this.selectedTags) {
                    url += '&filters[tags]=' + this.selectedTags
                }
                if (this.selectedFilters) {
                    url += '&filters[filter]=' + this.selectedFilters
                }
                fetch(url)
                    .then(res => res.json())
                    .then(res => {
                        this.photos = res
                    })
                    .catch(err => {
                        console.log(err)
                    })
                    .finally(() => (this.isUpdating = false))
            }
        },
        watch: {
            search(val) {
                this.queryTerm = val
                this.callServer()
            },
            isUpdating(val) {
                if (val) {
                    setTimeout(() => (this.isUpdating = false), 3000)
                }
            },
        },

    }
</script>
