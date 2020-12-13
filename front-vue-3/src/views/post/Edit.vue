<template>
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12">
              <div class="card border-0 rounded shadow-sm">
                  <div class="card-body">
                    <h4>EDIT POST</h4>
                    <hr>

                    <router-link :to="{name: 'post.index'}" class="btn btn-md btn-success">Back</router-link>
                    <br>
                    <br>
                    <form action="" @submit.prevent="update">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold">TITLE</label>
                            <input type="text" class="form-control" name="" id="" v-model="post.title" placeholder="Masukkan judul post">

                            <!-- validation -->
                            <div v-if="validation.title" class="mt-2 alert alert-danger">
                                {{ validation.title[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="font-weight-bold">CONTENT</label>
                            <textarea name="" id="" cols="" rows="4" class="form-control" v-model="post.content" placeholder="Masukkan konten post"></textarea>

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
import { reactive, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import axios from 'axios'

export default {
    setup() {

        //state post
        const post = reactive({
            title: '',
            content: ''
        })

        //state validation
        const validation = ref([])

        //vue router
        const router = useRouter()

        //vue router
        const route = useRoute()

        //mounted
        onMounted(() => {

            //get API from laravel backend
            axios.get(`http://localhost:8000/api/post/${route.params.id}`)
            .then(response => {

                //masukkan nilai dari API ke variable state
                post.title = response.data.data.title
                post.content = response.data.data.content

            }).catch(error => {
                console.log(error.response.data)
            })
        })

        //update method
        function update() {
            
            let title = post.title
            let content = post.content

            axios.put(`http://localhost:8000/api/post/${route.params.id}`, {
                title: title,
                content: content
            }).then(() => {

                // redirect ke post index
                router.push({
                    name: 'post.index'
                })
            }).catch(error => {
                //masukkan nilai error ke validation
                validation.value = error.response.data
            })
        }

        //return nilai
        return {
            post,
            validation,
            router,
            route,
            update
        }
    }
}
</script>

<style>

</style>