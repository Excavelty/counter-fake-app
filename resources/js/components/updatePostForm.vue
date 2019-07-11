<template>
    <div v-if="post">
        <form @submit="updateForm" class="formBox">
        <div class="form-group">
            <label for="title">Tytuł</label>
            <input id="title" name="title" v-model="post.title" class="form-control" type="text"/>
          </div>

          <div class="form-group">
            <label for="content">Opis</label>
            <textarea id="content" class="form-control" v-model="post.content" rows="10" name="content"></textarea>
          </div>

          <div class="form-group">
            <label for="type">Typ</label>
            <select id="type" name="type" class="form-control" v-model="post.type">
                <option value="1">First option</option>
                <option value="2">Second option</option>
            </select>
          </div>

          <input type="submit" class="btn btn-primary" value="Edytuj">
        </form>
    </div>
</template>

<script>
        export default
        {
          data() {
              return{};
          },

        props: {
            post: {
              id: null,
              authorId: null,
              title: '',
              content: '',
              upvotes: null,
              downvotes: null,
              type: '',
              created_at: '',
              updated_at: '',
            },
        },

        methods: {
            updateForm: function(e) {
                e.preventDefault();
                axios({
                    method: 'put',
                    url: '/put-post/' + this.post.id,
                    data: {
                        title: this.post.title,
                        content: this.post.content,
                        type: this.post.type,
                    }
                }).then(response => console.log(response.data.success));
            }
        },

        mounted: function() {
            console.log(this.post.title);
        }
      }

</script>

<style scoped>
  .formBox {
      background-color: #3B4F51;
      color: white;
      padding: 4vh;
  }
</style>
