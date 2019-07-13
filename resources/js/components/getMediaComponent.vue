<template>
<div>
    <div v-for="med in media" class="list-group">
        <a href="/media-show/" class="link-group-item list-group-item-active">
        {{med.name}}
        </a>
    </div>
</div>
</template>
<script>
    export default {
        data: function()
        {
            return {
              media: [],
              error: [],
            }
        },

        methods: {
            getMediaRank: function(howMuch) {
                axios.get('/get-media-rank', {
                    'howMuch': howMuch,
                }).then(response => response.data.media? this.media = response.data.media :
                  this.error = response.data.error).
                  catch(error => this.error = error.response.data.errors);
            },
        },

        mounted: function() {
            this.getMediaRank(10);
        },
    }
</script>

<style scoped>
</style>
