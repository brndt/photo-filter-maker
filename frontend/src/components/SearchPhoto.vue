<template>
    <div id="app">
        <vue-instant :suggestOnAllWords="true"
                     :suggestion-attribute="suggestionAttribute" v-model="value" :disabled="false" @input="changed"
                     :show-autocomplete="true" :autofocus="false" :suggestions="suggestions" name="customName"
                     placeholder="custom placeholder" type="google"></vue-instant>
        <div class="row">
            <div v-for="item in photos" v-bind:key="item.id" class="col-lg-3">
                <div class="card">
                    <img class="card-img-top" :src="'http://localhost:8080/uploads/' + item.nameURL"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{item.nameURL}}</h5>
                        <p class="card-text">{{item.description}}</p>
                        <span v-if="item.tags.length"><span v-for="(tag, index) in item.tags" :key="index"
                                                                class="mr-1">#{{tag}}</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import VueInstant from 'vue-instant'
    import 'vue-instant/dist/vue-instant.css'
    import axios from 'axios'

    Vue.use(VueInstant)
    export default {
        name: 'app',
        data() {
            return {
                value: '',
                suggestionAttribute: 'filter',
                suggestions: [],
                selectedEvent: "",
                photos: []
            }
        },
        methods: {
            changed: function () {
                var that = this
                this.suggestions = []
                axios.get('http://localhost:8080/photo?filters[filter]=' + this.value)
                    .then(function (photoResponse) {
                        that.photos = []
                        photoResponse.data.forEach(function (a) {
                            that.suggestions.push(a)
                            that.photos.push(a)
                        })
                    })
            }
        }
    }
</script>
