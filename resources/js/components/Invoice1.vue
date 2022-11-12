<template>
    <div class="container-fluid invoice1">
        <div class="row">
            <div class="col col-12">
                <div class="invoice-header text-center">
                    <h1>{{shop_name_kh}}</h1>
                    <h3>{{shop_name_en}}</h3>
                    <p>{{ shop_address_kh }}</p>
                    <p>ទូរស័ព្ទលេខ 069 505 169 / 097 323 4431 / 060 309 977</p>
                    <p>Address: {{shop_address}}</p>
                </div>
                <span class="break-line d-block"></span>

                <div class="invoice-content">
                    <h3 class="mt-3 text-center">វិក្កយបត្រ / Invoice</h3>
                    <div class="d-flex justify-content-between">
                        <div class="w-50">
                            <table>
                                <tr>
                                    <td>អតិថិជន / Customer:</td>
                                    <td class="pl-3">{{customer_name}}</td>
                                </tr>
                                <tr>
                                    <td align="top">អាសយដ្ធាន / Address:</td>
                                    <td class="pl-3">{{customer_address}}</td>
                                </tr>
                                <tr>
                                    <td>លេខទូរសព័្ទ / Tel:</td>
                                    <td class="pl-3">{{customer_phone}}</td>
                                </tr>
                                <tr>
                                    <td>លេខតុ / Table:</td>
                                    <td class="pl-3 text-bold">{{table}}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="w-25">
                            <table>
                                <tr>
                                    <td>លេខវិក័យបត្រ / Invoice No#:</td>
                                    <td class="pl-3 text-bold">{{invoiceNo}}</td>
                                </tr>
                                <tr>
                                    <td>កាលបរិច្ឆេត / Date:</td>
                                    <td class="pl-3">{{dateTime}}</td>
                                </tr>
                                <tr>
                                    <td>អ្នកលក់ / Seller:</td>
                                    <td class="pl-3">{{seller}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="mt-5">
                        <table class="table w-100">
                            <tr class="bg-gray-light">
                                <th>
                                    <p >ល.រ</p>
                                    <p >#</p>
                                </th>
                                <th>
                                    <p >បរិយាយមុខទំនិញ</p>
                                    <p>items Description</p>
                                </th>
                                <th class="text-center">
                                    <p >បរិមាណ</p>
                                    <p>Qty</p>
                                </th>
                                <th class="text-center">
                                    <p >តម្លៃរាយ</p>
                                    <p>Unit price</p>
                                </th>
                                <th class="text-center">
                                    <p >បញ្ចុះតម្លៃ</p>
                                    <p>Discount</p>
                                </th>
                                <th class="text-right">
                                    <p >តម្លៃសរុប</p>
                                    <p>Amount</p>
                                </th>
                            </tr>
                            <tr v-for="(product,index) in products" :key="product.id">
                                <td>{{index+1}}</td>
                                <td>{{product.name}}</td>
                                <td class="text-center">{{product.pivot.quantity}}</td>
                                <td class="text-center">{{convertToCurrency(product.price)}} <span class="h5">៛</span></td>
                                <td class="text-center">{{convertToCurrency(product.pro_discount * product.pivot.quantity)}} <span class="h5">៛</span></td>
                                <td class="text-right">{{ convertToCurrency((product.price * product.pivot.quantity))}} <span class="h5">៛</span></td>
                            </tr>


                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-between">
                        <div class="w-50">
                            <p class="text-bold">Payment Term</p>
                            <p>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner. P.O. Box 183, 2717 Nunc Avenue
                                Bacon ipsum dolor sit amet salami venison chicken flank fatback doner. P.O. Box 183, 2717 Nunc Avenue
                            </p>
                        </div>
                        <div class="w-25">
                            <table class="w-100 text-bold">
                                <tr>
                                    <td>សរុបបឋម / Sub.(R):</td>
                                    <td class="pl-3" align="right">{{convertToCurrency(subtotal)}} <span class="h4">៛</span></td>
                                </tr>
                                <tr>
                                    <td>បញ្ចុះតម្លៃ / Dis.(R):</td>
                                    <td class="pl-3" align="right">{{convertToCurrency(discount)}} <span class="h4">៛</span></td>
                                </tr>
                            </table>

                            <hr>

                            <table class="w-100 text-bold">
                                <tr>
                                    <td>សរុប / Total(R):</td>
                                    <td class="pl-3" align="right">{{convertToCurrency(total)}} <span class="h4">៛</span></td>
                                </tr>
                                <tr>
                                    <td>សរុប / Total($):</td>
                                    <td class="pl-3" align="right">{{convertToCurrency(total / 4100)}} $</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <div class="mt-5 pb-5 d-flex justify-content-between">
                        <div class="w-50 text-center">
                            <p class="">ហត្ថលេខា និង ឈ្មោះអ្នកទិញ</p>
                            <p class="mb-5">Customer's Signature & Name</p>
                            <p class="break-line1px w-50 m-auto mt-5 pt-5"></p>
                        </div>
                        <div class="w-50 text-center">
                            <p class="">ហត្ថលេខា និង ឈ្មោះអ្នកលក់</p>
                            <p class="mb-5">Seller's Signature & Name</p>
                            <p class="break-line1px w-50 m-auto mt-5 pt-5"></p>
                        </div>
                    </div>
                    <div class="footer w-100 mt-5 text-center">
                        <p class="pt-5">សូមអរគុណ! សូមអញ្ចើញមកម្តងទៀត</p>
                        <p>Thanks you! See You Again.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['invoice',],
    data () {
        return{
            inv: JSON.parse(this.invoice),
            shop_name_kh: '',
            shop_name_en: '',
            shop_address: '',
            shop_address_kh: '',

            customer_name: '',
            customer_address: '',
            customer_phone: '',
            customer_email: '',

            table: '',

            invoiceNo: '',
            dateTime: '',
            seller: '',

            products: [],

            subtotal: '',
            discount: '',
            total: '',

            test: [],

        }
    },

    methods:{
        retrieveReport() {

                    let report = this.inv[0];

                    this.shop_name_kh = report[0].shop.name_kh;
                    this.shop_name_en = report[0].shop.name;
                    this.shop_address = report[0].shop.address;
                    this.shop_address_kh = report[0].shop.address_kh;

                    this.customer_name = report[0].customer.name
                    this.customer_address = report[0].customer.address
                    this.customer_phone = report[0].customer.phone
                    this.customer_email = report[0].customer.phone

                    this.table = report[0].table.name

                    this.invoiceNo = report[0].id
                    this.dateTime = this.formatDate(report[0].created_at)
                    this.seller = report[0].user.name_kh

                    this.products = report[0].products

                    this.subtotal = report[0].subtotal
                    this.total = report[0].total
                    this.discount = report[0].discount


                    setTimeout(() => window.print(), 0.1); /*COZ DATA LOAD TO PAGE WAS DELAY LATE THEN CODE*/

        },

        formatDate(value){
            return moment(value).format('LLL');
        },

        convertToCurrency(price){
            /*https://flaviocopes.com/how-to-format-number-as-currency-javascript/*/
            let converted
            const formatter = new Intl.NumberFormat('en-US', {
                /*style: 'currency',
                currency: 'USD',*/
                minimumFractionDigits: 0
            })
            if(price > 0){
                return converted = formatter.format(price)
            }
            else return converted = '0.00'

        },

    },

    mounted() {
        this.retrieveReport()
    }
}
</script>
<style scoped>
.invoice1{
    color: black;
}

.invoice-header{
    width: 50%;
    margin: 0 auto;

}

.break-line{
    width: 100%;
    border: 1px solid black;
}
.break-line1px{
    width: 100%;
    border-bottom: 1px solid black;
}
th p{
    margin: 0;
}

</style>



































<!--<template>-->
<!--    <div class="container-fluid invoice1">-->
<!--        <div class="row">-->
<!--            <div class="col col-12">-->
<!--                <div class="invoice-header text-center">-->
<!--                    <h1>{{shop_name_kh}}</h1>-->
<!--                    <h3>{{shop_name_en}}</h3>-->
<!--                    <p>{{ shop_address_kh }}</p>-->
<!--                    <p>ទូរស័ព្ទលេខ 069 505 169 / 097 323 4431 / 060 309 977</p>-->
<!--                    <p>Address: {{shop_address}}</p>-->
<!--                </div>-->
<!--                <span class="break-line d-block"></span>-->

<!--                <div class="invoice-content">-->
<!--                    <h3 class="mt-3 text-center">វិក្កយបត្រ / Invoice</h3>-->
<!--                    <div class="d-flex justify-content-between">-->
<!--                        <div class="w-50">-->
<!--                            <table>-->
<!--                                <tr>-->
<!--                                    <td>អតិថិជន / Customer:</td>-->
<!--                                    <td class="pl-3">{{customer_name}}</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td align="top">អាសយដ្ធាន / Address:</td>-->
<!--                                    <td class="pl-3">{{customer_address}}</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>លេខទូរសព័្ទ / Tel:</td>-->
<!--                                    <td class="pl-3">{{customer_phone}}</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>លេខតុ / Table:</td>-->
<!--                                    <td class="pl-3 text-bold">{{table}}</td>-->
<!--                                </tr>-->
<!--                            </table>-->
<!--                        </div>-->

<!--                        <div class="w-25">-->
<!--                            <table>-->
<!--                                <tr>-->
<!--                                    <td>លេខវិក័យបត្រ / Invoice No#:</td>-->
<!--                                    <td class="pl-3 text-bold">{{invoiceNo}}</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>កាលបរិច្ឆេត / Date:</td>-->
<!--                                    <td class="pl-3">{{dateTime}}</td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>អ្នកលក់ / Seller:</td>-->
<!--                                    <td class="pl-3">{{seller}}</td>-->
<!--                                </tr>-->
<!--                            </table>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="mt-5">-->
<!--                        <table class="table w-100">-->
<!--                            <tr class="bg-gray-light">-->
<!--                                <th>-->
<!--                                    <p >ល.រ</p>-->
<!--                                    <p >#</p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p >បរិយាយមុខទំនិញ</p>-->
<!--                                    <p>items Description</p>-->
<!--                                </th>-->
<!--                                <th class="text-center">-->
<!--                                    <p >បរិមាណ</p>-->
<!--                                    <p>Qty</p>-->
<!--                                </th>-->
<!--                                <th class="text-center">-->
<!--                                    <p >តម្លៃរាយ</p>-->
<!--                                    <p>Unit price</p>-->
<!--                                </th>-->
<!--                                <th class="text-center">-->
<!--                                    <p >បញ្ចុះតម្លៃ</p>-->
<!--                                    <p>Discount</p>-->
<!--                                </th>-->
<!--                                <th class="text-right">-->
<!--                                    <p >តម្លៃសរុប</p>-->
<!--                                    <p>Amount</p>-->
<!--                                </th>-->
<!--                            </tr>-->
<!--                            <tr v-for="(product,index) in products" :key="product.id">-->
<!--                                <td>{{index+1}}</td>-->
<!--                                <td>{{product.name}}</td>-->
<!--                                <td class="text-center">{{product.pivot.quantity}}</td>-->
<!--                                <td class="text-center">{{convertToCurrency(product.price)}} <span class="h5">៛</span></td>-->
<!--                                <td class="text-center">{{convertToCurrency(product.pro_discount * product.pivot.quantity)}} <span class="h5">៛</span></td>-->
<!--                                <td class="text-right">{{ convertToCurrency((product.price * product.pivot.quantity))}} <span class="h5">៛</span></td>-->
<!--                            </tr>-->


<!--                        </table>-->
<!--                    </div>-->
<!--                    <div class="mt-4 d-flex justify-content-between">-->
<!--                        <div class="w-50">-->
<!--                            <p class="text-bold">Payment Term</p>-->
<!--                            <p>Bacon ipsum dolor sit amet salami venison chicken flank fatback doner. P.O. Box 183, 2717 Nunc Avenue-->
<!--                                Bacon ipsum dolor sit amet salami venison chicken flank fatback doner. P.O. Box 183, 2717 Nunc Avenue-->
<!--                            </p>-->
<!--                        </div>-->
<!--                        <div class="w-25">-->
<!--                            <table class="w-100 text-bold">-->
<!--                                <tr>-->
<!--                                    <td>សរុបបឋម / Sub.(R):</td>-->
<!--                                    <td class="pl-3" align="right">{{convertToCurrency(subtotal)}} <span class="h4">៛</span></td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>បញ្ចុះតម្លៃ / Dis.(R):</td>-->
<!--                                    <td class="pl-3" align="right">{{convertToCurrency(discount)}} <span class="h4">៛</span></td>-->
<!--                                </tr>-->
<!--                            </table>-->

<!--                            <hr>-->

<!--                            <table class="w-100 text-bold">-->
<!--                                <tr>-->
<!--                                    <td>សរុប / Total(R):</td>-->
<!--                                    <td class="pl-3" align="right">{{convertToCurrency(total)}} <span class="h4">៛</span></td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>សរុប / Total($):</td>-->
<!--                                    <td class="pl-3" align="right">{{convertToCurrency(total / 4100)}} $</td>-->
<!--                                </tr>-->

<!--                            </table>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="mt-5 pb-5 d-flex justify-content-between">-->
<!--                        <div class="w-50 text-center">-->
<!--                            <p class="">ហត្ថលេខា និង ឈ្មោះអ្នកទិញ</p>-->
<!--                            <p class="mb-5">Customer's Signature & Name</p>-->
<!--                            <p class="break-line1px w-50 m-auto mt-5 pt-5"></p>-->
<!--                        </div>-->
<!--                        <div class="w-50 text-center">-->
<!--                            <p class="">ហត្ថលេខា និង ឈ្មោះអ្នកលក់</p>-->
<!--                            <p class="mb-5">Seller's Signature & Name</p>-->
<!--                            <p class="break-line1px w-50 m-auto mt-5 pt-5"></p>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="footer w-100 mt-5 text-center">-->
<!--                        <p class="pt-5">សូមអរគុណ! សូមអញ្ចើញមកម្តងទៀត</p>-->
<!--                        <p>Thanks you! See You Again.</p>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--export default {-->
<!--    data () {-->
<!--        return{-->
<!--            reports: [],-->
<!--            shop_name_kh: '',-->
<!--            shop_name_en: '',-->
<!--            shop_address: '',-->
<!--            shop_address_kh: '',-->

<!--            customer_name: '',-->
<!--            customer_address: '',-->
<!--            customer_phone: '',-->
<!--            customer_email: '',-->

<!--            table: '',-->

<!--            invoiceNo: '',-->
<!--            dateTime: '',-->
<!--            seller: '',-->

<!--            products: [],-->

<!--            subtotal: '',-->
<!--            discount: '',-->
<!--            total: '',-->

<!--        }-->
<!--    },-->

<!--    methods:{-->
<!--        retrieveReport() {-->
<!--            axios.get("/loadReport/"+189)-->
<!--                .then((response) => {-->
<!--                    this.reports = response.data;-->
<!--                    const report = this.reports[0];-->

<!--                    this.shop_name_kh = report.shop.name_kh;-->
<!--                    this.shop_name_en = report.shop.name;-->
<!--                    this.shop_address = report.shop.address;-->
<!--                    this.shop_address_kh = report.shop.address_kh;-->

<!--                    this.customer_name = report.customer.name-->
<!--                    this.customer_address = report.customer.address-->
<!--                    this.customer_phone = report.customer.phone-->
<!--                    this.customer_email = report.customer.phone-->

<!--                    this.table = report.table.name-->

<!--                    this.invoiceNo = report.id-->
<!--                    this.dateTime = this.formatDate(report.created_at)-->
<!--                    this.seller = report.user.name_kh-->

<!--                    this.products = report.products-->

<!--                    this.subtotal = report.subtotal-->
<!--                    this.total = report.total-->
<!--                    this.discount = report.discount-->




<!--                    setTimeout(() => window.print(), 0.1); /*COZ DATA LOAD TO PAGE WAS DELAY LATE THEN CODE*/-->
<!--                })-->
<!--                .catch((e) => {-->
<!--                    console.log(e);-->
<!--                });-->
<!--        },-->

<!--        formatDate(value){-->
<!--            return moment(value).format('LLL');-->
<!--        },-->

<!--        convertToCurrency(price){-->
<!--            /*https://flaviocopes.com/how-to-format-number-as-currency-javascript/*/-->
<!--            let converted-->
<!--            const formatter = new Intl.NumberFormat('en-US', {-->
<!--                /*style: 'currency',-->
<!--                currency: 'USD',*/-->
<!--                minimumFractionDigits: 0-->
<!--            })-->
<!--            if(price > 0){-->
<!--                return converted = formatter.format(price)-->
<!--            }-->
<!--            else return converted = '0.00'-->

<!--        },-->

<!--    },-->

<!--    mounted() {-->
<!--        this.retrieveReport()-->
<!--    }-->
<!--}-->
<!--</script>-->
<!--<style scoped>-->
<!--    .invoice1{-->
<!--        color: black;-->
<!--    }-->

<!--    .invoice-header{-->
<!--        width: 50%;-->
<!--        margin: 0 auto;-->

<!--    }-->

<!--    .break-line{-->
<!--        width: 100%;-->
<!--        border: 1px solid black;-->
<!--    }-->
<!--    .break-line1px{-->
<!--        width: 100%;-->
<!--        border-bottom: 1px solid black;-->
<!--    }-->
<!--    th p{-->
<!--        margin: 0;-->
<!--    }-->

<!--</style>-->


