<template>
        <div id="app">
            <img alt="Vue logo" src="./../assets/logo.png">
            <vue-dropzone
                    ref="myVueDropzone"
                    id="dropzone"
                    class="row"
                    :options="dropzoneOptions"
                    v-on:vdropzone-sending="sendingEvent"
                    v-on:vdropzone-success="onSent"
            >

            </vue-dropzone>
            <br/>
            <button type="button" class="btn btn-primary" v-on:click="processFiles">Send images</button>
        </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        name: 'app',
        components: {
            vueDropzone: vue2Dropzone,
        },
        methods: {
            'processFiles': function () {
                this.$refs.myVueDropzone.processQueue()
            },
            'onSent': function (response) {
                //console.log('123');
                console.log(response)
            },
            sendingEvent(file, xhr, formData) {
                const description = file.previewElement.querySelector('#description').value;
                const tags = file.previewElement.querySelector('#tags').value;
                const filters = Array.from(file.previewElement.querySelector('#filters').selectedOptions).map(o => o.value);
                formData.append('description', description);
                formData.append('tags', tags);
                formData.append('filters', filters);

            },
            template: function () {
                return `
                  <div class="col-lg-4">
                    <div class="card">
                        <img class="card-img-top" data-dz-thumbnail />
                        <span class="card-body">
                            <h5 class="card-title"><span data-dz-name></span></h5>
                            <p class="card-text"><textarea class="form-control" id="description" rows="2" placeholder="Put your description here"></textarea></p>
                            <p class="card-text"><input class="form-control" id="tags" placeholder="Put your tags here, separated by comma"></p>
                              <div class="form-group">
                                <label for="filters">Select filters</label>
                                <select multiple class="form-control" id="filters">
                                  <option>desaturate</option>
                                  <option>sepia</option>
                                </select>
                              </div>
                        </div>
                    </div>
                  </div>
        `;
            },
        },
        data: function () {
            return {
                dropzoneOptions: {
                    url: 'http://localhost:8080/photo',
                    headers: {"My-Awesome-Header": "header value"},
                    thumbnailWidth: 350,
                    maxFilesize: 0.5,
                    autoProcessQueue: false,
                    previewTemplate: this.template()
                },
            }
        }
    }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
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
