<template>
    <div>
        <div v-if="Number.isInteger(upvotes)">
            <i class="icon-plus-squared"></i>{{upvotes}}
        </div>
        <div v-if="Number.isInteger(downvotes)">
            <i class="icon-minus-squared"></i>{{downvotes}}
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                upvotes: null,
                downvotes: null,
            }
        },

        props: {
            postId: null
        },

        methods: {

        },

        mounted: function() {
            axios.get('/get-post-votes/', {
              params: {
                  postId: this.postId
              },
            }).then(response =>
              {this.upvotes = response.data.upvotes; this.downvotes = response.data.downvotes;}
            ).catch(error => console.log(error));
        }
    }
</script>

<style scoped>
</style>
