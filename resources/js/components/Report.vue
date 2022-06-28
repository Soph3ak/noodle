<template>
    <div class="mt-3 report">
        <div class="search-block d-flex">
            <div class="form-group">
                <input type="text" class="form-control search" id="search" placeholder="Search invoice number here ..." v-model="searchTitle" @keyup.enter="page = 1; retrieveReports()">
                <!--<button type="button" class="btn btn-primary float-right form-control btn-search d-none" @click="page = 1; retrieveReports()">
                    ស្វែងរក
                </button>-->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card table-block">
                    <div class="card-header d-flex align-items-center">
                        <div class="show-page-calendar">
                            <div class="d-flex" style="width: 1050px;">
                                <label for="" class="col-form-label" style="width: 115px">Show records:</label>
                                <div class="">
                                    <select v-model="pageSize" @change="handlePageSizeChange($event)" class="form-control show-per-page" style="width: 75px">
                                        <option v-for="size in pageSizes" :key="size" :value="size">
                                            {{ size }}
                                        </option>
                                    </select>
                                </div>
                                <div id="reportrange" style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 296px" class="form-control text-center ml-2 mr-2">
                                    <i class="fa fa-calendar text-primary"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-warning badge-filter text-primary pr-2 animate__animated animate__bounceIn" v-show="selected.filters.length>0">
                                        <i class="fas fa-filter ml-1 mr-1"></i> Filter
                                    </span>
                                    <span class="badge badge-filter selected-filter ml-1 pointer animate__animated animate__bounceIn" :id="f+'-filter'" v-for="f in selected.filters" :key="f.id">
                                        <span class="text-lowercase" @click="toggleFilter(f+'-filter'); previousSelect(f+'-filter'); closeOtherFilter(f+'-filter');"><i class="fas fa-filter ml-1 mr-1"></i> {{f}}</span>
                                        <button @click="btnRemoveBadgeFilter(f+'-filter'); " type="button" class="btn btn-tool"><i class="fas fa-times"></i></button>
                                    </span>
                                    <span class="badge badge-filter text-danger pr-2 pointer animate__animated animate__bounceIn" v-show="selected.filters.length>1">
                                        <span @click="btnRemoveBadgeFilter('all')"><i class="fas fa-broom ml-1 mr-1"></i>Clear all filter</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="paginate ml-auto">
                            <pagination :data="reports"
                                        @pagination-change-page="handlePageChange"
                                        :limit="1"
                                        :show-disabled="true"
                                        :total-rows="count"
                                        :per-page="pageSize"
                                        align="center">
                                <span slot="prev-nav" class="p-2">Previous</span>
                                <span slot="next-nav" class="p-2">Next</span>
                            </pagination>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0 vld-parent" style="max-height: 76vh; min-height: 76vh;">
                        <div class="">
                            <loading :active.sync="isLoading"
                                     :can-cancel="true"
                                     :is-full-page="fullPage"
                                     :height="height"
                                     :width="width"
                                     :color="color"
                                     :loader="loader"
                                     :background-color="bgColor"></loading>
                        </div>
                        <table class="table table-head-fixed table-striped text-nowrap sell-reports">
                            <thead>
                            <tr class="w-100">
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Location</th>
                                <th>Seller</th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        Table
                                        <div class="ml-2 position-relative pointer d-inline-block">
                                            <span class="gg">
                                                <span class="text-gray" @click="sort('table')"><i class="gg-swap-vertical"></i></span>
                                                <span class="btn-filter text-gray btn-table-filter" @click="toggleFilter('table-filter'); previousSelect('table-filter'); closeOtherFilter('table-filter');"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter table-filter px-2 py-4 d-none">
                                                <span class="p-2 pointer text-primary" @click="selectAll('table-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('table-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group px-2">
                                                    <div class="custom-control custom-checkbox py-2" v-for="t in tables" :key="t.id">
                                                        <input class="custom-control-input" type="checkbox" v-model="selected.tables" :id="'table' + t.id" :value="t"/>
                                                        <label :for="'table' + t.id" class="custom-control-label pointer">{{t.name}}</label>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('table-filter'); previousSelect('table-filter')" type="button" id="close-table-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('table-filter'); saveSelect('table-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex align-items-center">
                                        Payment
                                        <div class="ml-2 position-relative pointer d-inline-block">
                                            <span class="gg">
                                                <span class="text-gray" @click="sort('table')"><i class="gg-swap-vertical"></i></span>
                                                <span class="btn-filter text-gray btn-payment-filter" @click="toggleFilter('payment-filter'); previousSelect('payment-filter'); closeOtherFilter('payment-filter')"><i class="gg-sort-az"></i></span>
                                            </span>
                                            <div class="filter payment-filter px-2 py-4 d-none">
                                                <!--<span class="px-2 pointer"><i class="ion-android-close mr-2"></i>Close</span>-->
                                                <span class="p-2 pointer text-primary" @click="selectAll('payment-filter')"><i class="ion-android-done-all mr-2"></i>Select all</span>
                                                <span class="p-2 pointer text-danger" @click="clearSelect('payment-filter')"><i class="ion-android-close mr-2"></i>Clear</span>
                                                <hr>
                                                <div class="form-group px-2">
                                                    <div class="custom-control custom-checkbox py-2" v-for="p in paymentTypes" :key="p.id">
                                                        <input class="custom-control-input" type="checkbox" v-model="selected.paymentTypes" :id="'payment' + p.id" :value="p"/>
                                                        <label :for="'payment' + p.id" class="custom-control-label pointer">{{p.payment}}</label>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="filter_footer d-flex justify-content-end">
                                                    <button @click="closeFilter('payment-filter'); previousSelect('payment-filter')" type="button" id="close-payment-filter" class="btn btn-sm btn-default mr-2">Cancel</button>
                                                    <button @click="applyFilter('payment-filter'); saveSelect('payment-filter')" type="button" class="btn btn-sm btn-success">Apply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="report in reports.data" :key="report.id">
                                <td><a href="#">{{ report.id }}</a></td>
                                <td>{{ formatDate(report.created_at) }}</td>
                                <td>{{ report.customer.name }}</td>
                                <td>{{ report.shop.name }}</td>
                                <!--<td>{{ report.user.name_kh }}</td>-->
                                <td>
                                    <div class="position-relative p-0">
                                        <img :src="getImgUrl(report.user.photo)" alt="Staff Image" class="img-circle staff-image">
                                    </div>
                                </td>
                                <td>{{ report.table.name }}</td>
                                <td>
                                    <span class="badge badge-new-primary" v-if="report.payment.payment === 'UNPAID'">{{report.payment.payment}}</span>
                                    <span class="badge badge-new-success" v-else-if="report.payment.payment === 'PAID'">{{report.payment.payment}}</span>
                                    <span class="badge badge-new-danger" v-else>{{report.payment.payment}}</span>
                                </td>
                                <td>{{ convertToCurrency(report.subtotal) }}៛</td>
                                <td>{{ convertToCurrency(report.discount) }}៛</td>
                                <td>{{ convertToCurrency(report.total) }}៛</td>
                            </tr>
                            <tr v-show="reportCount === 0" class="bg-white">
                                <td class="" colspan="10">
                                    <div class="sc-5kpu8c-5 dcdHhK">
                                        <div class="sc-5kpu8c-6 fbNBuP mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="24px" width="24px" viewBox="0 0 24 24" class="sc-16r8icm-0 jZwKai">
                                                <path d="M16.4153 16.4153L20 20M18.5455 11.2727C18.5455 15.2893 15.2894 18.5454 11.2728 18.5454C7.25612 18.5454 4 15.2893 4 11.2727C4 7.2561 7.25612 4 11.2728 4C15.2894 4 18.5455 7.2561 18.5455 11.2727Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </div>
                                        <h3 font-size="16px" font-weight="500" color="text" class="sc-1eb5slv-0 ddqQcN" style="text-align: center;">No results found</h3>
                                        <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">We couldn't find anything matching your search.</p>
                                        <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">Try again with a different term.</p></div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <!--<div class="card-footer bg-white"></div>-->
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->

            </div>
        </div>
        <!-- /.row -->
    </div>
</template>

<script>
/*https://github.com/ankurk91/vue-loading-overlay/tree/v3.x*/
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    props: ['token'],
    components:{Loading},
    data () {
        return {
            currentPage:'1',
            reports:{},
            reportCount:1,

            currentIndex: -1,
            searchTitle: "",
            page: 1,
            count: 0,
            pageSize: 10,
            pageSizes: [10, 25, 50, 100],
            start: null,
            end: null,

            isLoading: false,
            fullPage: false,
            canCancel: true,
            loader: 'spinner',
            color: '#007bff',
            bgColor: '#ffffff',
            height: 70,
            width: 70,

            tables:[],
            tablesCount : 0,
            selected: {
                tables: [],
                tempTables: [],
                filters: [],

                paymentTypes: [],
                tempPaymentTypes: [],
            },
            tblID:{
                tablesID: ['all']
            },

            paymentTypes:[],
            paymentCount : 0,
            paymentID:{
                paymentsID: ['all']
            }


        }
    },
    methods:{

        /*=========Axios with filter: https://www.bezkoder.com/vue-pagination-axios/========*/

        getAll(params) {
            return axios.get("/getReport", {params});
        },

        getRequestParams(searchTitle, page, pageSize, start, end, paymentTypes, tables) {
            let params = {};
            if (searchTitle) {
                params["title"] = searchTitle;
            }

            if (page) {
                params["page"] = page;
            }

            if (pageSize) {
                params["size"] = pageSize;
            }

            if (start) {
                params["start"] = start;
            }
            if (end) {
                params["end"] = end;
            }
            if (paymentTypes) {
                params["paymentTypes"] = paymentTypes;
            }
            if (tables) {
                params["tables"] = tables;
            }

            return params;

        },

        retrieveReports() {
            const params = this.getRequestParams(
                this.searchTitle,
                this.page,
                this.pageSize,
                this.start,
                this.end,
                this.paymentID.paymentsID,
                this.tblID.tablesID,
            );
            this.isLoading = true;
            setTimeout(() => {
                this.getAll(params)
                    .then((response) => {
                        this.isLoading = false
                        this.reports = response.data;
                        this.reportCount = (this.reports.data).length
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }, 1)

        },

        handlePageChange(value) {
            if (this.page !== value){
                this.page = value;
                this.retrieveReports();
            }

        },

        handlePageSizeChange(event) {
            this.pageSize = event.target.value;
            this.page = 1;
            this.retrieveReports();
        },

        handlePaymentChange(event){
            this.paymentType = event.target.value;
            this.page = 1;
            this.retrieveReports();
        },

        handleTableChange(event){
            this.table = event.target.value;
            this.retrieveReports();
        },

        formatDate(value){
            return moment(value).format("LL");
        },

        getImgUrl(img) {
            return '/files/' + img
        },

        alertSuccess(str1,name,str2){
            Toast.fire({
                icon: 'success',
                title: str1 +' '+ name +' '+ str2
            })
        },

        retrieveTables(){
            axios.get("api/loadSeats")
                .then((response) => {
                    this.tables = response.data;
                    this.tablesCount = this.tables.length
                    this.selected.tables = this.tables;
                    this.selected.tempTables = this.tables;

                })
                .catch((e) => {
                    console.log(e);
                });
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

        toggleFilter(filter){
            if(filter!=='all'){ //this if() to skip from btn "Clear all filter"
                let filterClass = '.'+filter;
                let fil = $(filterClass);
                fil.toggleClass('d-none');
            }
        },

        closeFilter(filter){
                if (filter!=='all'){ //this if() to skip from btn "Clear all filter"
                let filterClass = '.'+filter;
                let fil = $(filterClass);
                fil.addClass('d-none');
            }
        },

        btnRemoveBadgeFilter(filter){
            this.selectAll(filter);
            this.applyFilter(filter);
            this.saveSelect(filter);
            this.closeFilter(filter);
            this.closeOtherFilter(filter);
        },

        removeBadgeFilter(current){
            this.selected.filters.splice(current,1);
        },

        closeOtherFilter(filter){
            switch (filter) {
                case 'table-filter':
                    let closePaymentFilter = $('#close-payment-filter');
                    closePaymentFilter.trigger('click');
                    break;
                case 'payment-filter':
                    let closeTableFilter = $('#close-table-filter');
                    closeTableFilter.trigger('click');
                    break;
                case  'seller-filter':

                    break;
                case  'all':
                    let closeAllFilter = $('div.filter');
                    closeAllFilter.addClass('d-none');
                    break;
                default:

            }
        },

        clearSelect(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = [];

                    break;
                case 'payment-filter':
                    this.selected.paymentTypes = [];

                    break;
                case  'seller-filter':

                    break;
                default:

            }

        },

        selectAll(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = this.tables;
                    break;

                case 'payment-filter':
                    this.selected.paymentTypes = this.paymentTypes;
                    break;

                case  'seller-filter':
                    break;

                case  'all':
                    this.selected.tables = this.tables;
                    this.selected.paymentTypes = this.paymentTypes;
                    break;
                default:

            }

        },

        previousSelect(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tables = this.selected.tempTables;
                    break;
                case 'payment-filter':
                    this.selected.paymentTypes = this.selected.tempPaymentTypes;
                    break;
                case  'seller-filter':

                    break;
                default:

            }

        },

        saveSelect(filter){
            switch (filter) {
                case 'table-filter':
                    this.selected.tempTables = this.selected.tables;
                    break;
                case 'payment-filter':
                    this.selected.tempPaymentTypes = this.selected.paymentTypes;
                    break;
                case  'seller-filter':

                    break;

                case  'all':
                    this.selected.tempTables = this.selected.tables;
                    this.selected.tempPaymentTypes = this.selected.paymentTypes;
                    break;
                default:

            }

        },

        getSelectedID(filter){
            switch (filter) {
                case 'table-filter':
                    this.tblID.tablesID=[];
                    if (this.selected.tables.length === this.tablesCount)
                        this.tblID.tablesID = ['all'];
                    else
                    this.selected.tables.forEach((value, index) => {
                        this.tblID.tablesID.push(value.id);
                    });

                    break;

                case 'payment-filter':
                    this.paymentID.paymentsID=[];
                    if (this.selected.paymentTypes.length === this.paymentCount)
                        this.paymentID.paymentsID = ['all'];
                    else
                        this.selected.paymentTypes.forEach((value, index) => {
                            this.paymentID.paymentsID.push(value.id);
                    });
                    break;

                case  'seller-filter':

                    break;
                case  'all':
                        this.tblID.tablesID = ['all'];
                        this.paymentID.paymentsID = ['all'];
                    break;
                default:


            }

        },

        styling_BtnFilter_BadgeFilter(filter){
            let selectedFilterLength = 0;
            let selectedFilterCount = 0;
            let text = '';
            switch (filter) {
                case 'table-filter':
                    selectedFilterLength = this.selected.tables.length;
                    selectedFilterCount = this.tablesCount;
                    text = 'table';
                    this.stylingCurrentFilter(filter, selectedFilterLength, selectedFilterCount, text)
                    break;
                case 'payment-filter':
                    selectedFilterLength = this.selected.paymentTypes.length;
                    selectedFilterCount = this.paymentCount;
                    text = 'payment';
                    this.stylingCurrentFilter(filter, selectedFilterLength, selectedFilterCount, text)
                    break;
                case  'seller-filter':

                    break;
                case  'all':
                    let allBtnFilter = $('.btn-filter');
                    allBtnFilter.removeClass('visited');
                    this.selected.filters = [];
                    break;
                default:

            }
        },

        stylingCurrentFilter(filter, length, count, badgeText){
            let currentFilter ='';
            let selectedBtnFilter = $('.btn-'+filter);
            if (length !== count){
                selectedBtnFilter.addClass('visited');

                if (this.selected.filters.length === 0){
                    this.selected.filters.push(badgeText);
                }
                else
                {
                    currentFilter = '';
                    for (let i = 0; i < this.selected.filters.length; i++) {
                        currentFilter = this.selected.filters[i];
                        if (currentFilter === badgeText)
                            break; //This break in not working (Why javascript??)
                    }
                    if (currentFilter !== badgeText)  //this if() to fix not working break
                        this.selected.filters.push(badgeText);
                }
            }
            else
            {
                selectedBtnFilter.removeClass('visited');
                this.selected.filters.forEach((value, index) => {
                    if (value === badgeText){
                        this.removeBadgeFilter(index,1)
                    }
                })

            }

        },

        applyFilter(filter){
            this.getSelectedID(filter) //get only for retrieveReports()
            this.retrieveReports()
            this.toggleFilter(filter)
            this.styling_BtnFilter_BadgeFilter(filter);
        },

        sort(column){




            /*let toggleSort = 'AZ';
            if (toggleSort === 'AZ'){

            }*/

        },

        retrievePaymentType(){
            axios.get("getPaymentType")
                .then((response) => {
                    this.paymentTypes = response.data;
                    this.paymentCount = this.paymentTypes.length
                    this.selected.paymentTypes = this.paymentTypes;
                    this.selected.tempPaymentTypes = this.paymentTypes;
                })
                .catch((e) => {
                    console.log(e);
                });
        },
        test(){
            alert('closed')
        }

    },
    computed:{

    },

    watch:{
        /*selected: {
            handler: function (val, oldVal) {
                this.getSelectedTablesID()
            },
            deep: true
        },*/
    },

    mounted() {
        this.retrieveTables()
        this.retrievePaymentType()
        const vm = this


        /*=========Date Time Picker=========*/
        /*http://www.daterangepicker.com/*/
        $(function() {
            /* var start = moment().subtract(29, 'days');*/
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
                /*vm.getResults(vm.currentPage,(start.format('MMMM D, YYYY')), (end.format('MMMM D, YYYY')));*/
                vm.start = start.format('MMMM D, YYYY');
                vm.end = end.format('MMMM D, YYYY');
                console.log(vm.start + ' - ' + vm.end);
                vm.page = 1;
                vm.retrieveReports();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                },
                "showCustomRangeLabel": false,
                "alwaysShowCalendars": true,
                "opens": "right"
            }, cb);

            cb(start, end);
        });
        /*=========End of Date Time Picker=========*/

    },
}
</script>
<style scoped>
.card-footer{
    padding-bottom: 0;
}

</style>
