<template>
  <div>
  <CRow>
    <CCol col="12" sm="4">
      <CWidgetIcon
        :header=countActor()
        text="Actors"
        color="primary"
      >
        <CIcon name="cil-people"/>
      </CWidgetIcon>
    </CCol>
    <CCol col="12" sm="4">
      <CWidgetIcon
        :header=countCustomer
        text="Customer"
        color="success"
      >
        <CIcon name="cil-people"/>
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
    <CCol col="12" sm="6">
      <CWidgetIcon
        header="$1.999,50"
        text="Income"
        color="primary"
      >
        <CIcon name="cil-settings"/>
      </CWidgetIcon>
    </CCol>
  </CRow>
  
    <CCard>
      <CCardBody>
        <CRow>
          <CCol sm="5">
            <h4 id="traffic" class="card-title mb-0">Traffic</h4>
            <div class="small text-muted">November 2017</div>
          </CCol>
          <CCol sm="7" class="d-none d-md-block">
            <CButton color="primary" class="float-right">
              <CIcon name="cil-cloud-download"/>
            </CButton>
            <CButtonGroup class="float-right mr-3">
              <CButton
                color="outline-secondary"
                v-for="(value, key) in ['Day', 'Month', 'Year']"
                :key="key"
                class="mx-0"
                :pressed="value === selected ? true : false"
                @click="selected = value"
              >
                {{value}}
              </CButton>
            </CButtonGroup>
          </CCol>
        </CRow>
      </CCardBody>
      <CCardFooter>
        <CRow class="text-center">
          <CCol md sm="12" class="mb-sm-2 mb-0">
            <div class="text-muted">Visits</div>
            <strong>29.703 Users (40%)</strong>
            <CProgress
              class="progress-xs mt-2"
              :precision="1"
              color="success"
              :value="40"
            />
          </CCol>
          <CCol md sm="12" class="mb-sm-2 mb-0 d-md-down-none">
            <div class="text-muted">Unique</div>
            <strong>24.093 Users (20%)</strong>
            <CProgress
              class="progress-xs mt-2"
              :precision="1"
              color="info"
              :value="20"
            />
          </CCol>
          <CCol md sm="12" class="mb-sm-2 mb-0">
            <div class="text-muted">Pageviews</div>
            <strong>78.706 Views (60%)</strong>
            <CProgress
              class="progress-xs mt-2"
              :precision="1"
              color="warning"
              :value="60"
            />
          </CCol>
          <CCol md sm="12" class="mb-sm-2 mb-0">
            <div class="text-muted">New Users</div>
            <strong>22.123 Users (80%)</strong>
            <CProgress
              class="progress-xs mt-2"
              :precision="1"
              color="danger"
              :value="80"
            />
          </CCol>
          <CCol md sm="12" class="mb-sm-2 mb-0 d-md-down-none">
            <div class="text-muted">Bounce Rate</div>
            <strong>Average Rate (40.15%)</strong>
            <CProgress
              class="progress-xs mt-2"
              :precision="1"
              :value="40"
            />
          </CCol>
        </CRow>
      </CCardFooter>
    </CCard>
    <CCard>
      <CCardBody>
        <CRow>
          <CCol sm="5">
            <h4 id="traffic" class="card-title mb-0">List of Film's Length</h4>
            <div class="small text-muted">November 2017</div>
          </CCol>
          <CCol sm="12">
              <CChartBar
                style="height:500px"
                :datasets="[
                  {
                    data:getCountLengthOnly(),
                    backgroundColor: '#FFB2B2',
                    label: 'Film Length',
                  }
                ]"
                :labels=getLengthOnly()
                :options="{ maintainAspectRatio: false }"
              />
          </CCol>
        </CRow>
      </CCardBody>
    </CCard>
    
  </div>
</template>

<script>


//import untuk get data dari api
import axios from 'axios'
import Vue from 'vue'

//importing Vue plugin
import CoreuiVueCharts from '@coreui/vue-chartjs'
Vue.use(CoreuiVueCharts)

import MainChartExample from './charts/MainChartExample'
import WidgetsDropdown from './widgets/WidgetsDropdown'
import WidgetsBrand from './widgets/WidgetsBrand'

let listLengRaw = null
export default {
  //fungsi get data dari api
  setup () {

  },
  name: 'Dashboard',
  components: {
    MainChartExample,
    WidgetsDropdown,
    WidgetsBrand
  },
  data () {
    return {
      actors: null,
      countCustomer: null,
      
    }
  },
  
  mounted () {
    // axios
    // .get('http://localhost:8000/api/actor')
    // .then(response => {
      
    //   this.actors = response.data.data
    //   console.log(this.actors.length)
    // })
    //chart

    axios.all([
      axios.get('http://localhost:8000/api/actor'),
      axios.get('http://localhost:8000/api/customer'),
      axios.get('http://localhost:8000/api/lengthList')
    ])
    .then(axios.spread((actorsRes, customerRes, lenghList) => {
      this.actors = actorsRes.data.data,
      this.countCustomer = customerRes.data.data.length
      this.listLengRaw = lenghList.data.data
      console.log(this.listLengRaw.length)

      //console.log(this.listLengRaw[0]['count'])
    }))
    
  },
  methods: {
    color (value) {
      let $color
      if (value <= 25) {
        $color = 'info'
      } else if (value > 25 && value <= 50) {
        $color = 'success'
      } else if (value > 50 && value <= 75) {
        $color = 'warning'
      } else if (value > 75 && value <= 100) {
        $color = 'danger'
      }
      return $color
    },
    countActor (){
      let count
      return count = this.actors.length
    },
    ///////////////from film length api
    //get from object
    getLengthOnly() {
      let onlyLength = []
      let i = 0
      for (i = 0; i < this.listLengRaw.length; i++) {
        onlyLength.push(this.listLengRaw[i]['length'])
      }
      console.log(onlyLength)
      return onlyLength
    },
    getCountLengthOnly() {
      let onlyCountLength = []
      let i = 0
      for (i = 0; i < this.listLengRaw.length; i++) {
        onlyCountLength.push(this.listLengRaw[i]['count'])
      }
      return onlyCountLength
    }
  },
  
  
}
</script>
