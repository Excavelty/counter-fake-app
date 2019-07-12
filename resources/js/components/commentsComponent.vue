<template>
    <div>
        <button class="btn btn-primary"  data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseExample">Dodaj komentarz</button>
        </br></br>
        <div class="collapse" id="collapseForm">
            <form @submit="runSubmit" method="post" class="formBox">
              <div class="form-group">
                <label for="content">Treść komentarza:</label>
                <textarea id="content" class="form-control" v-model="content" rows="10" name="content"></textarea>
              </div>

              <input type="submit" class="btn btn-primary" value="Dodaj">
              </form>
        </div>
        </br></br>

            <div v-if="success" class="alert alert-success">
                {{success}}
            </div>
            <div v-if="error" class="alert alert-danger">
                {{error}}
            </div>
            <div v-for="errs in errorsList" class="alert-danger">
                {{errs[0]}}
            </div>
        </br></br>
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
                commentError: '',
                content: '',
                success: '',
                errorsList: [],
                error: '',
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
            },

            removeShowButton: function() {
                document.querySelector('.showButton').remove();
            },

            runSubmit: function(e) {//think of csrf protection
                e.preventDefault();
                this.success = this.error = '';
                this.errorsList = [];
                axios.post('/add-comment/' + this.postId, {content: this.content}).then(response =>
                  {
                    response.data.success? this.success = response.data.success : this.error
                    = response.data.error;
                    this.getComments();//maybe optimize it somehow
                }).catch(error => this.errorsList = error.response.data.errors);
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

    .formBox {
        background-color: #3B4F51;
        color: white;
        padding: 4vh;
    }
</style>
