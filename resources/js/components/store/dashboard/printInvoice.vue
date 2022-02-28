<template>

    <div id="invoice-POS">

        <center id="top">
            <div class="logo"></div>
            <div class="info mt-2">
                <h2 class="bold "> {{store.name}} </h2>
            </div><!--End Info-->
        </center><!--End InvoiceTop-->

        <div id="mid">
            <div class="info">
                <h4 class="h4 mt-2"> {{lang.contact_info}} </h4>
                <p class="contact-info">
                    {{lang.location}} :  {{store.location}} </br>
                    {{lang.email}}   :  {{store.email}} </br>
                    {{lang.phone}}   :  {{store.phone}} </br>
                </p>
            </div>
        </div><!--End Invoice Mid-->

        <div id="bot">
            <div id="table">
                <table>
                    <tr class="tabletitle">
                        <td class="item"><h2> {{lang.item}} </h2></td>
                        <td class="Hours text-center"><h2>{{lang.qty}}</h2></td>
                        <td class="Rate text-center"><h2> {{lang.sub_total}} </h2></td>
                    </tr>

                    <tr class="service" v-for="(details, index) in invoice.invoicedets" :key="index">
                        <td class="tableitem"><p class="itemtext"> {{details.name}} </p></td>
                        <td class="tableitem"><p class="itemtext text-center"> {{details.quantity}} </p></td>
                        <td class="tableitem"><p class="itemtext text-center"> {{details.price}} </p></td>
                    </tr>

                    <tr  v-if="invoice_s.tax" class="tabletitle">
                        <td class="Rate text-center"><h2> {{lang.tax}} </h2></td>
                        <td></td>
                        <td class="payment text-center"><h2> {{invoice_s.tax}} </h2></td>
                    </tr>
                    <tr v-if="invoice.discount" class="tabletitle">
                        <td class="Rate text-center"><h2> {{lang.total_be_discount}} </h2></td>
                        <td></td>
                        <td class="payment text-center"><h2> {{invoice.total}} </h2></td>
                    </tr>
                    <tr v-if="invoice.discount" class="tabletitle">
                        <td class="Rate text-center"><h2> {{lang.discount}} %</h2></td>
                        <td></td>
                        <td class="payment text-center"><h2> {{invoice.discount}}% </h2></td>
                    </tr>

                    <tr class="tabletitle">
                        <td class="Rate text-center"><h2> {{lang.total}} </h2></td>
                        <td></td>
                        <td class="payment text-center"><h2> {{invoice.paid}} {{store.currency}} </h2></td>
                    </tr>

                </table>
            </div><!--End Table-->

            <div id="mt-3" v-if="invoice.user.name">
                <h4 class="h4 p-1 m-0"> {{lang.casher}} {{invoice.user.name}}
                </h4>
            </div>

            <div id="mt-3">
                <h4 class="h4 p-1 m-0"> {{invoice_s.message}}
                </h4>
            </div>
            <hr class="m-0 mt-1">
            <div id="mt-3">
                <h4 class="h4 p-1 m-0"> {{store.fb}}
                </h4>
            </div>
            <hr class="m-0 mt-1">
            <div id="mt-3">
                <h4 class="h4 p-1 m-0"> {{invoice.created_at}}
                </h4>
            </div>

        </div><!--End InvoiceBot-->
    </div><!--End Invoice-->

</template>

<style scoped>
#invoice-POS {
  box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
  padding: 2mm;
  margin: 0 auto;
  width: 44mm;
  background: #fff;
}
.contact-info {
    font-size: 0.5em !important;
}
.h4 {
        font-size: 0.5em;
}
  ::selection {
    background: #f31544;
    color: #fff;
  }
  ::moz-selection {
    background: #f31544;
    color: #fff;
  }
  h1 {
    font-size: 1.5em;
    color: #222;
  }
  h2 {
    font-size: 0.9em;
  }
  h3 {
    font-size: 1.2em;
    font-weight: 300;
    line-height: 2em;
  }
  p {
    font-size: 0.7em;
    color: #666;
    line-height: 1.5em;
    margin-bottom: 8px !important;
  }

  #top,
  #mid,
  #bot {
    /* Targets all id with 'col-' */
    border-bottom: 1px solid #eee;
  }

  #top {
    min-height: 100px;
  }
  #mid {
    min-height: 80px;
  }
  #bot {
    min-height: 50px;
  }

  #top .logo {
    /* //float: left; */
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
    background-size: 60px 60px;
  }
  .clientlogo {
    float: left;
    height: 60px;
    width: 60px;
    background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
    background-size: 60px 60px;
    border-radius: 50px;
  }
  .info {
    display: block;
    /* //float:left; */
    margin-left: 0;
  }
  .title {
    float: right;
  }
  .title p {
    text-align: right;
  }
  table {
    width: 100%;
    border-collapse: collapse;
  }
  td {
    /* //padding: 5px 0 5px 15px;
    //border: 1px solid #EEE */
  }
  .tabletitle {
    /* //padding: 5px; */
    font-size: 0.5em;
    background: #eee;
  }
  .service {
    border-bottom: 1px solid #eee;
  }
  .item {
    width: 24mm;
  }
  .itemtext {
    font-size: 0.5em;
  }

  #legalcopy {
    margin-top: 5mm;
  }

</style>

<script>
export default {
    name:"PrintInvoice",
    props: ['store_id', 'invoice_id'],
    data: function () {
        return {
            lang: this.getLang(),
            locale: this.getLocale(),
            store: {},
            invoice: {},
            invoice_s: {},
        }
    },
    mounted() {
        this.getStoreInfo(this.store_id);
        this.getInvoiceDetails();
        this.getInvoiceSettings(this.store_id, this.locale)
    },
    methods: {
        getStoreInfo: function (store_id) {
            axios
                .get(`/api/storeinfo?store_id=${store_id}`)
                .then((res) => {
                    // console.log(res.data);
                    this.store = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getInvoiceDetails: function () {
            axios
                .get(
                    `/api/invoicedetails?invoice_id=${this.invoice_id}&store_id=${this.store_id}`
                )
                .then((res) => {
                    // console.log(res.data);
                    this.invoice = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getInvoiceSettings: function (store_id, locale) {
            axios
                .get(`/api/invoice/settings?store_id=${this.store_id}&locale=${locale}`)
                .then((res) => {
                    // console.log(res.data);
                    this.invoice_s = res.data;
                })
                .catch((err) => {
                    // console.log(err);
                    this.notification(
                        this.getType("error"),
                        this.lang.error,
                        this.lang.please_check_the_data
                    );
                });
        },
    }
}
</script>
