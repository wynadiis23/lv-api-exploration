<template>
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12">
              <div class="card border-0 rounded shadow-sm">
                  <div class="card-body">
                      <h4>TAMBAH POST</h4>
                      <hr>

                      <router-link :to="{name: 'post.index'}" class="btn btn-md btn-warning">Back</router-link>
                      <br>
                      <br>
                      <form action="" @submit.prevent="store">
                          <div class="form-group">
                              <label for="title" class="font-weight-bold">Title</label>
                              <input type="text" class="form-control" v-model="post.title" placeholder="Masukkan judul post">

                              <!-- validation -->
                              <div v-if="validation.title" class="mt-2 alert alert-danger">
                                  {{ validation.title[0] }}
                              </div>
                          </div>
                          <div class="form-group">
                              <label for="content" class="font-wight-bold">Content</label>
                              <textarea name="" id="" cols="" rows="4" class="form-control" v-model="post.content" placeholder="Masukkkan konten post"></textarea>

                              <!-- validation -->
                              <div v-if="validation.content" class="mt-2 alert alert-danger">
                                  {{ validation.content[0] }}
                              </div>
                          </div>
                          <button type="submit" class="btn btn-primary">SIMPAN</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'


export default {
    setup() {
        //state posts
        const post = reactive({
            title: '',
            content: ''
        })

        //state validation
        const validation = ref([])

        //vue router
        const router = useRouter()

        //method store
        function store() {

            let title = post.title
            let content = post.content

            axios.post('http://localhost:8000/api/post', {
                title: title,
                content: content
            }).then(() => {

                //redirect ke post index
                router.push({
                    name: 'post.index'
                })
            }).catch(error => {
                //input nilai ke variable validation ketika dia error
                validation.value = error.response.data
            })
        }

        //return
        return {
            post,
            validation,
            router,
            store
        }
    }
}
</script>

<style>
    body {
        background: whitesmoke;
    }
</style>