<template>
  <div class="container mt-5">
      <div class="row">
          <div class="col-md-12">
              <div class="card border-0 rounded shadow-sm">
                  <div class="card-body">
                      <h4>DATA POST</h4>
                      <hr>
                      <div class="row">
                          <div class="col col-md-10">
                              <router-link :to="{name: 'post.create'}" class="btn btn-md btn-success">+</router-link>
                          </div>
                          <div class="col col-md-2">
                              <router-link :to="{name: 'new'}" class="btn btn-md btn-outline-light btn-primary">Menu Lain</router-link>
                          </div>
                      </div>
                      
                      <table class="table table-sripped table-bordered mt-4">
                          <thead class="thead-light"> 
                              <tr>
                                  <th scope="col">TITLE</th>
                                  <th scope="col">CONTENT</th>
                                  <th scope="col">OPTIONS</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr v-for="(post, index) in posts" :key="index">
                                  <td>{{ post.title }}</td>
                                  <td>{{ post.content}}</td>
                                  <td class="text-center">
                                      <router-link :to="{name: 'post.edit', params:{id: post.id}}" class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                                      <button class="btn btn-sm btn-danger ml-1" @click.prevent="postDelete(post.id)">DELETE</button>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios'
import {
    onMounted, ref
} from 'vue'

export default {
    setup() {
        //reactive state
        let posts = ref([])

        //mounted
        onMounted(() => {
            //get API from laravel backend
            axios.get('http://localhost:8000/api/post')
            .then(response => {

                //assign state post dengan response data
                posts.value = response.data.data
                
            }).catch(error => {
                console.log(error.response.data)
            })
        })

        //fungsi delete
        function postDelete(id) {

            //delete data berdasarkan post id
            axios.delete(`http://localhost:8000/api/post/${id}`)
            .then(() => {
                //spilce post
                posts.value.splice(posts.value.indexOf(id), 1);
            }).catch(error => {
                console.log(error.response.data)
            })
        }

        //return
        return {
            posts,
            postDelete
        }
    }
}
</script>

<style>
    body{
        background: whitesmoke;
    }
</style>