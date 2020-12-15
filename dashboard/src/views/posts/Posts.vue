<template>
  <div>
      <CRow>
        <CCol col="12" sm="4">
        <CWidgetIcon
            header="$1.999,50"
            text="Income"
            color="primary"
        >
            <CIcon name="cil-settings"/>
        </CWidgetIcon>
        </CCol>
        <CCol col="12" sm="4">
        <CWidgetIcon
            header="$1.999,50"
            text="Income"
            color="info"
        >
            <CIcon name="cil-laptop"/>
        </CWidgetIcon>
        </CCol>
        <CCol col="12" sm="4">
        <CWidgetIcon
            header="$1.999,50"
            text="Income"
            color="info"
        >
            <CIcon name="cil-laptop"/>
        </CWidgetIcon>
        </CCol>
    </CRow>
    <CRow>
        <CCol col="12" xl="8">
            <CCard>
                <CCardHeader>
                Users
                </CCardHeader>
                <CCardBody>
                    <CDataTable
                        hover
                        striped
                        :items="posts"
                        :fields="fields"
                        :items-per-page="2"
                        clickable-rows
                        :active-page="activePage"
                        @row-clicked="rowClicked"
                        :pagination="{ doubleArrows: false, align: 'center'}"
                        @page-change="pageChange"
                    >
                    </CDataTable>
                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
  </div>
</template>

<script>
import axios from 'axios'
import { onMounted } from 'vue'

export default {
    name: 'Posts',
    data () {
        return {
            posts: null,
            fields: [
            { key: 'title' },
            { key: 'content' }
      ],
      activePage: 2
        }
    },
    mounted () {
        axios
        .get('http://localhost:8000/api/post')
        .then(response => {
            this.posts = response.data.data
            console.log(this.post)
        })
    },
    methods: {
    rowClicked (post, index) {
        alert(index)
      this.$router.push({path: `posts/${index + 1}`}).catch(()=>{})
    },
    pageChange (val) {
        alert(val)
      this.$router.push({ query: { page: val }}).catch(()=>{})
    }
  }
}
</script>

<style>

</style>