<template>
    <div class="mt-4">
        <div class="card search-block">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="col-form-label" for="inputSuccess"> What are you looking for?</label>
                        <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label">Select</label>
                        <select class="form-control">
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label">Select</label>
                        <select class="form-control">
                            <option>option 1</option>
                            <option>option 2</option>
                            <option>option 3</option>
                            <option>option 4</option>
                            <option>option 5</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="col-form-label text-white">Search...</label>
                        <button type="button" id="report" class="btn btn-primary float-right form-control">
                            ស្វែងរក
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card table-block">
                    <div class="card-header d-flex align-items-center">
                        <div class="show-page-calendar">
                            <div class="d-flex" style="width: 620px;">
                                <label for="" class="col-form-label" style="width: 115px">Show records:</label>
                                <div class="">
                                    <select v-model="pageSize" @change="handlePageSizeChange($event)" class="form-control show-per-page" style="width: 75px">
                                        <option v-for="size in pageSizes" :key="size" :value="size">
                                            {{ size }}
                                        </option>
                                    </select>
                                </div>
                                <div id="reportrange" style="background: #fff; cursor: pointer; border: 1px solid #ccc; width: 45%" class="form-control text-center ml-2">
                                    <i class="fa fa-calendar text-primary"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
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
                    <div class="card-body table-responsive p-0 vld-parent" style="">
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
                        <table class="table table-head-fixed text-nowrap sell-reports">
                            <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Location</th>
                                <th>Staff</th>
                                <th>Table</th>
                                <th>Payment</th>
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
                                <!--<td class="text-center">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-customer" @click="editModal(customer)"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteCustomer(report.name, report.id)"><i class="far fa-trash-alt"></i></button>
                                </td>-->
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div v-show="reportCount === 0">
                            <div class="sc-5kpu8c-5 dcdHhK">
                                <div class="sc-5kpu8c-6 fbNBuP mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" height="24px" width="24px" viewBox="0 0 24 24" class="sc-16r8icm-0 jZwKai">
                                        <path d="M16.4153 16.4153L20 20M18.5455 11.2727C18.5455 15.2893 15.2894 18.5454 11.2728 18.5454C7.25612 18.5454 4 15.2893 4 11.2727C4 7.2561 7.25612 4 11.2728 4C15.2894 4 18.5455 7.2561 18.5455 11.2727Z" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <h3 font-size="16px" font-weight="500" color="text" class="sc-1eb5slv-0 ddqQcN" style="text-align: center;">No results found</h3>
                                <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">We couldn't find anything matching your search.</p>
                                <p color="text2" font-size="1" class="sc-1eb5slv-0 bSDVZJ">Try again with a different term.</p></div>
                        </div>
                    </div>
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

        }
    },
    methods:{

        /*=========Axios with filter: https://www.bezkoder.com/vue-pagination-axios/========*/

        getAll(params) {
            return axios.get("/getReport", { params });
        },

        getRequestParams(searchTitle, page, pageSize, start, end) {
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
            return params;
        },

        retrieveReports() {
            const params = this.getRequestParams(
                this.searchTitle,
                this.page,
                this.pageSize,
                this.start,
                this.end,
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
    computed:{

    },

    mounted() {
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
