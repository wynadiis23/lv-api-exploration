<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard>
        <CCardHeader>
          Post id:  {{ $route.params.id }}
        </CCardHeader>
        <CCardBody>
          <CDataTable
            striped
            small
            fixed
            :items="visibleData"
            :fields="fields"
          />
        </CCardBody>
        <CCardFooter>
          <CButton color="primary" @click="goBack">Back</CButton>
        </CCardFooter>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
//let post = ([])
export default {
    name: 'Post',
    
    beforeRouteEnter(to, from, next) {
        next(vm => {
            vm.postsOpened = from.fullPath.includes('posts')
        })
    },
    mounted (){
        // let post = null
        axios
        .get('http://localhost:8000/api/post')
        .then(response => {
            this.post = response.data.data
            // console.log(this.post)
            //console.log(post)
        })
    },
    data (){
        return {
            postsOpened: null,
            post: []
        }
    },
    computed: {
        
        fields (){
            return [
                { key: 'key', label: this.title },
                { key: 'value', label:''}
            ]
        },
        postData (){
            const id = this.$route.params.id
            // console.log(this.post)
            const in_post = this.post.find((in_post, index) => index + 1 == id) 
            // console.log(in_post)
            //console.log(post.find((in_post, index) => index + 1 == id))
            const postDetails = in_post ? Object.entries(in_post) : [['id', 'Not Found']]
            console.log(postDetails)
            return postDetails.map(([key, value]) => {
                return { key, value }
                // console.log(value)
            })
        },
        visibleData (){
            
            return this.postData.filter(param => param.key !== 'title')
            // console.log(param.key)
        },
        title () {
            return this.postData.filter(param => param.key === 'title')[0].value
        }
        
    },
    methods: {
        goBack() {
        this.postsOpened ? this.$router.go(-1) : this.$router.push({path: '/posts'})
        }
    }
}
</script>

<style>

</style>