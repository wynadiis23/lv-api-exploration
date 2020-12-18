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
        :header=totalPayment
        text="Total Payment"
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
                  label: 'Film Length (minutes)',
                }
              ]"
              :labels=getLengthOnly()
              :options="{ maintainAspectRatio: false }"
            />
        </CCol>
      </CRow>
    </CCardBody>
  </CCard>
  <CRow>
    <CCol sm="6">
      <CCard>
        <CCardBody>
          <CRow>
            <CCol sm="5">
              <h4 id="" class="card-title mb-0">Chart of Film's Category</h4>
              <div class="small text-muted">November 2017</div>
            </CCol>
            <CCol sm="12">
                <CChartDoughnut
                  style="height:300px"
                  :datasets="[
                    {
                      data:getOnlyCatCount(),
                      backgroundColor: '#FFB2B2',
                      label: 'Film Lengtxxh (minutes)',
                    }
                  ]"
                  :labels=getOnlyCatName()
                  :options="{ maintainAspectRatio: false }"
                />
            </CCol>
          </CRow>
        </CCardBody>
      </CCard>
    </CCol>
    <CCol sm="6">
      <CCard>
        <CCardBody>
          <CRow>
            <CCol sm="12">
              <CRow>
                <CCol sm="5">
                  <h4 id="" class="card-title mb-0">List of Most Payment Customer</h4>
                  <div class="small text-muted">November 2017</div>
                </CCol>
                <CCol sm="7">
                  <CLink
                    class="text-white bg-info px-2"
                    to="/customers"
                    target="_blank"
                  >
                    List Customers
                  </CLink>
                </CCol>
              </CRow>
              
              
            </CCol>
            <CCol sm="12">
                <CDataTable
                  style="height:300px"
                  :items="listTotalAmountPerId"
                >
                </CDataTable>
            </CCol>
          </CRow>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
    
  </div>
</template>

<script>


//import untuk get data dari api
import axios from 'axios'
import Vue from 'vue'

//importing Vue plugin for charts
import CoreuiVueCharts from '@coreui/vue-chartjs'
Vue.use(CoreuiVueCharts)

import WidgetsDropdown from './widgets/WidgetsDropdown'
import WidgetsBrand from './widgets/WidgetsBrand'

//length film
let listLengRaw = null

//list of film category with counting
let listCountCategory = null

export default {
  name: 'Dashboard',
  components: {
    WidgetsDropdown,
    WidgetsBrand
  },
  data () {
    return {
      actors: null,
      countCustomer: null,
      totalPayment: null
      
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
      axios.get('http://localhost:8000/api/lengthList'),
      //get category list and count
      axios.get('http://localhost:8000/api/getListCountCategory'),

      //get total payment
      axios.get('http://localhost:8000/api/getTotalPayment'),

      //total amount perID
      axios.get('http://localhost:8000/api/getTotalMostAmountPerId')
    ])
    .then(axios.spread((actorsRes, customerRes, lenghList, listCountCategory, getTotalPayment, getListTotalAmountPerId) => {
      this.actors = actorsRes.data.data,
      this.countCustomer = customerRes.data.data.length
      //list film length 
      this.listLengRaw = lenghList.data.data

      //list film category and count
      this.listCountCategory = listCountCategory.data.data
      // console.log(this.listLengRaw.length)

      //console.log(this.listLengRaw[0]['count'])

      //total payment
      this.totalPayment = getTotalPayment.data.data[0].sum

      //totla amount per id
      this.listTotalAmountPerId = getListTotalAmountPerId.data.data
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
    },
    //////////from film category count api
    //get film category and count
    getOnlyCatName() {
      let catName = []
      let i = 0
      for (i = 0; i< this.listCountCategory.length; i++) {
        catName.push(this.listCountCategory[i]['name'])
      }
      console.log(catName)
      return catName
    },
    getOnlyCatCount() {
      let catCount = []
      let i = 0
      for(i = 0; i < this.listCountCategory.length; i++) {
        catCount.push(this.listCountCategory[i]['count'])
      }
      return catCount
    },
    
  },
  
  
}
</script>
