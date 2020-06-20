<template>
    <div id="app">
        <v-app id="inspire">
            <v-card color="blue-grey darken-1" dark>
                <v-card-text>
                    <v-combobox
                            v-model="selectedTags"
                            :items="tags"
                            label="Write your tags to search"
                            @change="callServer()"
                            multiple
                            chips
                    ></v-combobox>
                    <v-combobox
                            v-model="selectedFilters"
                            :items="filters"
                            label="Write your filters to search"
                            multiple
                            chips
                    ></v-combobox>
                    <v-combobox
                            v-model="selectedPhotos"
                            :items="photos"
                            :loading="isUpdating"
                            :search-input.sync="search"
                            color="white"
                            hide-no-data
                            hide-selected
                            item-text="description"
                            label="Public APIs"
                            no-filter
                            placeholder="Start typing to Search"
                            return-object
                    ></v-combobox>
                </v-card-text>
            </v-card>
            <div class="row">
                <div v-for="item in items" v-bind:key="item.id" class="col-lg-3">
                    <div class="card">
                        <img class="card-img-top" :src="'http://localhost:8080/uploads/' + item.nameURL"
                             alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{item.nameURL}}</h5>
                            <p class="card-text">{{item.description}}</p>
                            <span v-if="item.tags.length"><span v-for="(tag, index) in item.tags" :key="index" class="mr-1">#{{tag}}</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </v-app>
    </div>
</template>

<script>
    import Vue from 'vue'
    import Vuetify from 'vuetify'
    Vue.use(Vuetify)

    export default {

        vuetify: new Vuetify(),
        data: () => ({
            descriptionLimit: 60,
            tags: [],
            filters: [],
            photos: [],
            selectedPhotos: null,
            selectedTags: null,
            selectedFilters: null,
            isUpdating: false,
            search: null,
            queryTerm: ""
        }),

        computed: {
            items () {
                return this.photos.map(entry => {
                    const filter = entry.filter.length > this.descriptionLimit
                        ? entry.filter.slice(0, this.descriptionLimit) + '...'
                        : entry.filter
                    return Object.assign({}, entry, { filter })
                })
            },
        },
        methods: {
            callServer() {
                if (this.isUpdating) return

                if (0 === this.queryTerm.length) return

                this.isUpdating = true

                let url = 'http://localhost:8080/photo?filters[description]='+ this.queryTerm

                if (this.selectedTags) {
                    url += '&filters[tags]='+ this.selectedTags
                }
                if (this.selectedFilters) {
                    url += '&filters[filter]='+ this.selectedFilters
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
            isUpdating (val) {
                if (val) {
                    setTimeout(() => (this.isUpdating = false), 3000)
                }
            },
        },

    }
</script>
