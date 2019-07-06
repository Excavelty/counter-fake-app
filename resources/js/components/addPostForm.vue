<template>
    <div>
        <form @submit="runSubmit" method="post">
            <div v-if="success" transtion="expand" class="alert alert-success">
                {{success}}
                <button v-on:click="closeMessage" class="btn btn-primary closeButton">Zamknij</button>
            </div>
        <div v-if="error" class="alert alert-danger">
            {{error}}
        </div>
        <div v-if="errorsList" v-for="errs in errorsList" class="alert alert-danger">
            {{errs[0]}}
        </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input id="title" name="title" v-model="title" class="form-control" type="text"/>
          </div>
          <div class="form-group">
            <label for="content">Description</label>
            <textarea id="content" class="form-control" v-model="content" rows="10" name="content"></textarea>
          </div>
          <div class="form-group">
            <label for="type">Type</label>
            <select id="type" name="type" class="form-control" v-model="type">
                <option value="1">First option</option>
                <option value="2">Second option</option>
            </select>
          </div>
          <input type="submit" class="btn btn-primary" value="Add">
        </form>
    </div>
</template>

<script>
    export default {
      data() {
        return {
            title: '',
            content: '',
            type: '',
            success: null,
            errorsList: null,
            error: null
        };
      },

      methods: {
        runSubmit(e)
        {
            e.preventDefault();
            axios.post('/add-post', {
                title: this.title,
                content: this.content,
                type: this.type,
            }).then(response => response.data.success? this.success = response.data.success :
            this.error = response.data.error).catch(error => this.errorsList = error.response.data.errors);
        },

        closeMessage(e)
        {
            document.querySelector(".closeButton").parentNode.remove();
        }
      }
    }
</script>

<style>
/* always present */
.expand-transition {
  transition: all 3s ease;
  height: 30px;
  padding: 10px;
  background-color: #eee;
  overflow: hidden;
}
/* .expand-enter defines the starting state for entering */
/* .expand-leave defines the ending state for leaving */
.expand-enter, .expand-leave {
  height: 0;
  padding: 0 10px;
  opacity: 0;
}
</style>
