<template>
    <div>
                <div v-if="success" class="alert alert-success">
                    {{success}}
                      <button v-on:click="closeMessage" class="btn btn-primary closeButton">Zamknij</button>
                </div>

                <div v-if="error" class="alert alert-danger">
                    {{error}}
                    <button v-on:click="closeMessage" class="btn btn-primary closeButton">Zamknij</button>
                </div>

                <div v-for="errs in errorsList" class="alert alert-danger">
                      {{errs[0]}}
                      <button v-on:click="closeMessage" class="btn btn-primary closeButton">Zamknij</button>
                </div>

        <button class="btn btn-primary collapseButton" v-on:click="changeValue" type="button" data-toggle="collapse" data-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">Dodaj ostrzeżenie</button>
        <div class="collapse" id="collapseForm">
        <form @submit="runSubmit" method="post">
        <div class="form-group">
            <label for="title">Tytuł</label>
            <input id="title" name="title" @keyup.native="getSimiliarTitles => e" v-model="title" class="form-control" type="text"/>
          </div>

          <div class="form-group">
            <label for="content">Opis</label>
            <textarea id="content" class="form-control" v-model="content" rows="10" name="content"></textarea>
          </div>

          <div class="form-group">
            <label for="type">Typ</label>
            <select id="type" name="type" class="form-control" v-model="type">
                <option value="1">First option</option>
                <option value="2">Second option</option>
            </select>
          </div>

          <input type="submit" class="btn btn-primary" value="Dodaj">

          <div>
          Sprawdź czy nie istnieją już podobne tematy:
          <ul v-for="similiar in similiarList">
              <li><a :href="'/show-post/' + similiar.id" target="_blank">{{similiar.title}}</a></li>
          </ul>
          </div>
        </form>
    </div>
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
            error: null,
            similiarList: [],
        };
      },

      methods: {
        runSubmit(e)
        {
            e.preventDefault();
            this.success = null;
            this.errorsList = null;
            this.error = null;
            axios.post('/add-post', {
                title: this.title,
                content: this.content,
                type: this.type,
            }).then(response => response.data.success? this.success = response.data.success :
            this.error = response.data.error).catch(error => this.errorsList = error.response.data.errors);
        },

        changeValue(e) {
            let handle = document.querySelector(".collapseButton");
            if(handle.textContent === 'Dodaj ostrzeżenie')
                handle.textContent = 'Zwiń formularz';
            else
                handle.textContent = 'Dodaj ostrzeżenie';
        },
      },

      mounted: function() {
          const titleHandle = document.getElementById("title");
          titleHandle.addEventListener('keyup', () => axios.get('/search-posts', {
              params: {
                  title: this.title
              }
          }).then(response => this.similiarList = response.data.posts));
    }
  }
</script>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
  opacity: 0;
}
.alert, .closeButton {
  font-size: 20px;
}
.closeButton{
  float: right;
  padding: 2px;
}
</style>
