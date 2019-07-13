<template>
<div class="container">
    <div class="form-group">
      <label for="selectHowMany">Najlepiej oceniane media: </label>
      <select class="form-control" v-model="howMany">
          <option value="10" selected>Top 10</option>
          <option value="50">Top 50</option>
          <option value="100">Top 100</option>
          <option value="all">Wszystkie</option>
      </select>
    </div>
    <div v-for="(med, iter) in media" class="list-group">
        <a href="/media-show/" class="list-group-item list-group-item-active">
        {{++iter}}.{{med.brand}}
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
              howMany: null,
            }
        },

        methods: {
            getMediaRank: function(howMany) {
                axios.get('/get-media-rank', {

                    params: {
                        'howMany': howMany,
                    }

                }).then(response => response.data.media? this.media = response.data.media :
                  this.error = response.data.error).
                  catch(error => this.error = error.response.data.errors);
            },
        },

        mounted: function() {
            this.getMediaRank(10);
        },

        watch: {
            howMany: function(newHowMany, oldHowMany) {
                this.getMediaRank(newHowMany);
            }
        }
    }
</script>

<style scoped>
.list-group-item {
    margin-bottom: 1vh;
    text-decoration: none;
    background-color: #3B4F51;
    border-radius: 1vw;
    padding: 3vh;
    color: white;
}
</style>
