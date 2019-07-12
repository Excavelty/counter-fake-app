<template>
    <div>
        <button v-on:click="getComments" class="btn btn-primary showButton">Wyświetl komentarze</button>

        <h3>Komentarze: </h3>

        <div v-for="comment in comments">
                <div class="card">
                    <div class="card-header commentHeader">
                        Autor: {{comment.authorName}}
                    </div>
                    <div class="card-body">
                        {{comment.content}}
                    </div>
                    <div class="card-footer commentFooter">
                        Dodano: {{comment.created_at}}, ostatnio edytowano: {{comment.updated_at}}
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                comments: [],
                commentError: ''
            }
        },

        props: {
            postId: null,
        },

        methods: {
            getComments: function() {
                axios({
                    method: 'get',
                    url: '/get-comments/' + this.postId,
                }).then(response => {
                    if(response.data.comments)
                        this.comments = response.data.comments;
                    else
                        this.commentError = response.data.error;
                }).catch(error => console.log(error));

                //this.removeShowButton();
            },

            removeShowButton: function() {
                document.querySelector('.showButton').remove();
            }
        },


    }

</script>
<style scoped>
    .commentHeader, .commentFooter {
        background-color: #59C6D1;
    }
    .card {
        margin-bottom: 2vh;
    }
</style>
