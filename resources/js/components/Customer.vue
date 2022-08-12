<template>
    <div class="mt-1 customer">
        <div class="search-block d-flex">
            <div class="form-group">
                <input type="text" class="form-control search" id="search" placeholder="Search customer's name here ..." v-model="searchTitle" @keyup.enter="page = 1; retrieveCustomers()">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0" style="max-height: 76vh; min-height: 76vh;">
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
                        <table class="table table-head-fixed text-nowrap customer-reports">
                            <thead>
                            <tr>
                                <th>
                                    <span class="gg pointer"  @click="sortBy('id')" id="column_id">
                                        លេខរៀង
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer"  @click="sortBy('name')" id="column_name">
                                        ឈ្មោះអតិថិជន
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer"  @click="sortBy('gender')" id="column_gender">
                                        ភេទ
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer"  @click="sortBy('phone')" id="column_phone">
                                        លេខទូរសព័្ទ
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>
                                    <span class="gg pointer"  @click="sortBy('address')" id="column_address">
                                        អាសយដ្ធាន
                                        <span class="sort sort-default ml-1"></span>
                                    </span>
                                </th>
                                <th>Last order</th>
                                <th class="text-center">កែប្រែ | EDIT</th>
                                <th class="text-center">លុប | DELETE</th>
                                <th class="text-center reset-table">
                                    <span v-show="showingBtnResetTable === true"  @click="resetTable" class="text-danger pointer text-xs animate__animated animate__bounceIn">
                                        <i v-if="btnResetTableLoading === true" class="fas fa-spinner mr-2 fa-spin"></i>
                                        <i v-else class="fas fa-undo mr-2s mr-2"></i>
                                        Reset table
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody v-for="customer in customers.data" :key="customer.id" :id="'customer'+customer.id">
                            <tr class="tr-show-sub" @click="customer.latest_order !== null ? toggleSlideTable(customer.id) : ''">
                                <td>{{ customer.id }}</td>
                                <td>{{ customer.name }}</td>
                                <td v-if="customer.gender === 0">ស្រី</td>
                                <td v-else>ប្រុស</td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.address }}</td>
                                <td v-if="customer.latest_order !== null">{{convertToCurrency(customer.latest_order.total)}}៛ <br> <small class="text-success">{{ getLatestOrder(customer.latest_order.created_at) }}</small></td>
                                <td v-else></td>
                                <td class="text-center">
                                    <button class="btn btn-primary" @click="editModal(customer); $event.stopPropagation();"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteCustomer(customer.name, customer.id); $event.stopPropagation();"><i class="far fa-trash-alt"></i></button>
                                </td>
                                <td class="text-right toggle-detail">
                                    <span v-show="customer.latest_order !== null">
                                        <a type="button" class="btn btn-detail">
                                            <i class="ion-chevron-down text-cyan"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                            <tr class="tr-sub" :id="'detail'+customer.id">
                                <td colspan="11" class="abc">
                                    <div class="row div-sub">
                                        <div class="col-md-12">
                                            <!-- The time line -->
                                            <div class="timeline">
                                                <div>
                                                    <i class="fas fa-shopping-cart bg-green"></i>
                                                    <div class="timeline-item">
                                                        <h3 v-if="customer.latest_order !== null" class="timeline-header"><a href="#">Last {{customer.orders.length-1}} orders</a></h3>
                                                        <h3 v-else class="timeline-header"><a href="#">Don't has any orders yet</a></h3>
                                                        <!--<span class="text-xs ml-2 text-success">Showing 5 of 9 orders</span>-->
                                                        <table class="table table-hover table-borderless table-valign-middle">
                                                            <tbody v-if="loadingOrders === true && customer.orders.length<=0" class="skeleton">
                                                            <tr v-for="i in 3">
                                                                <td>
                                                                    <span class="mask-squircle mr-2 placeholder avatar mr-2"> </span>
                                                                    <span class="placeholder line"></span>
                                                                </td>

                                                                <td v-for="j in 4">
                                                                    <span class="placeholder line"></span>
                                                                </td>
                                                            </tr>


                                                            </tbody>

                                                            <tr v-for="(order,index) in customer.orders" :key="order.id" v-if="index < customer.orders.length-1" class="fade-in">

                                                                <td class="text-gray">
                                                                    Order#{{order.id}}
                                                                </td>

                                                                <td>
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Date
                                                                    </span>
                                                                    {{formatDate(order.created_at)}}
                                                                </td>

                                                                <td>
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Table
                                                                    </span>
                                                                    {{order.table.name}}
                                                                </td>
                                                                <td>
                                                                    <!--<div class="position-relative p-0">
                                                                        <img :src="getImgUrl(order.user.photo)" alt="Staff Image" class="img-circle staff-image">
                                                                    </div>-->
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Seller
                                                                    </span>
                                                                    {{order.user.name_kh}}
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-new-primary" v-if="order.payment.payment === 'UNPAID'">UNPAID</span>
                                                                    <span class="badge badge-new-success" v-else-if="order.payment.payment === 'PAID'">PAID</span>
                                                                    <span class="badge badge-new-danger" v-else>VOID</span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Subtotal
                                                                    </span>
                                                                    {{convertToCurrency(order.subtotal)}}<span class="kh-currency"><span class="kh-currency">៛</span></span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Discount
                                                                    </span>
                                                                    <span class="text-danger">
                                                                            -{{convertToCurrency(order.discount)}}<span class="kh-currency">៛</span>
                                                                        </span>
                                                                </td>
                                                                <td>
                                                                    <span class="text-success mr-1 text-xs">
                                                                        Total
                                                                    </span>
                                                                    {{convertToCurrency(order.total)}}<span class="kh-currency"><span class="kh-currency">៛</span></span>
                                                                </td>
                                                            </tr>


                                                        </table>
                                                        <div class="timeline-footer ml-2">
                                                            <a class="text-primary pointer" v-if="loadingButton === true && customer.id === cusID">
                                                                <i class="fas fa-spinner mr-2 fa-spin"></i> Loading
                                                            </a>

                                                            <a class="text-primary pointer"
                                                               @click="showAllOrders(customer.id ,customer.orders[customer.orders.length-1])"
                                                               v-else-if="customer.orders[customer.orders.length-1] > customer.orders.length-1">
                                                                Show all {{customer.orders[customer.orders.length-1]}} orders
                                                            </a>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END timeline item -->

                                                <div>
                                                    <i class="fas fa-ban bg-gray" v-if="customer.orders[customer.orders.length-1] <= 5 || customer.orders.length-1 > 5"></i>
                                                    <i class="fas fa-angle-double-down bg-gray animated-down" :id="'ban'+customer.id" v-else></i>
                                                    <span class="text-xs ml-5 pl-3 text-lightgray">
                                                        Showing {{customer.orders.length-1}} of {{customer.orders[customer.orders.length-1]}}
                                                        {{customer.orders[customer.orders.length-1]>1 ? 'orders':'order'}}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </td>
                            </tr>
                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <div class="paginate ml-auto">
                            <pagination :data="customers"
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
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        <!-- modal customer -->
        <div class="modal fade" id="modal-customer" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <form @submit.prevent="editMode ? updateCustomer(form.name,form.id):saveCustomer(form.name) ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-if="editMode"><span><i class="fas fa-user-edit mr-2"></i></span>កែប្រែព័ត៌មានអតិថិជន</h4>
                            <h4 class="modal-title" v-else><span><i class="fas fa-user-plus mr-2"></i></span>បញ្ចូលព័ត៌មានអតិថិជនថ្មី</h4>
                            <button type="button" class="close" data-toggle="modal" data-target="#modal-customer" @click="resetForm">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ឈ្មោះអតិថិជន</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះអតិថិជន" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="gender">ភេទ</label>
                                <select class="custom-select" v-model="form.gender"  name="gender" id="gender">
                                    <option value="0">ស្រី</option>
                                    <option value="1">ប្រុស</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phone">លេខទូរសព្ទ័</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="លេខទូរសព្ទ័" v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="address">អាសយដ្ធាន</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="អាសយដ្ធាន" v-model="form.address" :class="{ 'is-invalid': form.errors.has('phone') }">
                                <has-error :form="form" field="address"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-customer" @click="resetForm">បោះបង់</button>
                            <button type="submit" class="btn btn-primary" v-if="editMode">កែប្រែ</button>
                            <button type="submit" class="btn btn-primary" v-else>រក្សាទុក</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </form>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
/*https://github.com/ankurk91/vue-loading-overlay/tree/v3.x*/
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {
    props: ['token'],
    components:{Loading },
    data () {
        return {
            currentPage:'1',
            customers:{},
            editMode : false,
            form: new Form({
                id:"",
                name: "",
                gender: "0",
                phone: "",
                address:"",
                _token: this.token.value
            }),


            searchTitle: "",
            page : 1,
            pageSize: 10,
            pageSizes: [10, 25, 50, 100],
            count: 0,
            customerCount:1,
            totalRecords: 0,

            cusID : 0, //let row click can retrieve orders again
            detailLimit: 5,

            isLoading: false,
            loadingOrders: false,
            loadingButton: false,

            fullPage: false,
            canCancel: true,
            loader: 'dots',
            color: '#007bff',
            bgColor: '#ffffff',
            height: 70,
            width: 70,

            orderBy: ['id', 'desc'],    // For sort in server // default sort
            sort_by_column: '',         // Help in condition
            sort_direction: 'asc',      //Help in condition

            showingBtnResetTable: false,
            btnResetTableLoading: false,

        }
    },
    methods:{

        getAll(params) {
            return axios.get("api/getCustomers", {params});
        },

        getRequestParams(searchTitle, page, pageSize, orderBy) {
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

            if (orderBy) {
                params["orderBy"] = orderBy;
            }

            return params;

        },

        retrieveCustomers() {
            this.closeOpenedRows()
            const params = this.getRequestParams(
                this.searchTitle,
                this.page,
                this.pageSize,
                this.orderBy,
            );
            this.isLoading = true;
            setTimeout(() => {
                this.getAll(params)
                    .then((response) => {
                        this.isLoading = false
                        this.customers = response.data;
                        this.customerCount = (this.customers.data).length
                        this.totalRecords = this.customers.total
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }, 1)
        },

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(customer){
            $('#modal-customer').modal('show')
            this.form.clear()
            this.editMode=true
            this.form.fill(customer)
        },

        resetForm(){
            this.form.reset()
            this.form.clear()
        },

        hideModal(){
            $('#modal-customer').modal('hide')
            this.form.reset()
        },

        saveCustomer(name){
            this.form.post('api/customer')
                .then(response => {
                    this.retrieveCustomers(this.currentPage)
                    this.alertSuccess('Customer',name,'saved successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        updateCustomer(name,id){
            this.form.put('api/customer/'+id)
                .then(response => {
                    this.retrieveCustomers(this.currentPage)
                    this.alertSuccess('Customer',name,'updated successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        deleteCustomer(name,id){
            Swal.fire({
                title: 'Are you sure?',
                html: "តើអ្នកចង់លុបអតិថិជនឈ្មោះ <strong>" + name +" </strong>មែនទេ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText:'Cancel',
                allowOutsideClick: false,
                confirmButtonText: '<i class="far fa-trash-alt mr-2"></i>បាទ/ចាស៎'/*Yes, delete it!*/
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('api/customer/'+id)
                        .then(response => {
                            this.retrieveCustomers(this.currentPage);
                            Swal.fire({
                                title: 'Deleted!',
                                html: "អតិថិជនឈ្មោះ <strong>" + name  +" </strong>ត្រូវបានលុបដោយជោគជ័យ!",
                                icon: 'success',
                                allowOutsideClick: false,
                            })
                        })
                        .catch(err => console.log(err))
                        .finally(() => this.loading = false)
                }
            })
        },

        getLatestOrder(date){
            return moment(date).calendar();
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

        alertSuccess(str1,name,str2){
            Toast.fire({
                icon: 'success',
                title: str1 +' '+ name +' '+ str2
            })

        },

        handlePageChange(value) {
            if (this.page !== value){
                this.page = value;
                this.retrieveCustomers();
            }
        },

        toggleSlideTable(rowID){
            const selector = $("#detail"+rowID);
            const div_sub = selector.find('div.div-sub')
            div_sub.slideToggle(350)
            selector.toggleClass('shadowed')
            let btn_detail = selector.parent('tbody').find('a.btn-detail')
            btn_detail.toggleClass('rotate_up')

            this.showDetail(rowID)
        },

        showDetail(cusID, limit){
            if (limit) {
                this.detailLimit = limit
            }

            if (cusID !== this.cusID) {//THIS IF() TO PREVENT FROM FAST DOUBLE CLICK (CUZ PULL REQUEST TWO TIMES)
                this.customers.data.forEach((value1, index1) => {
                    if (value1.orders.length <= 0) { //Prevent Error,
                        if (value1.id === cusID) { //CHECK TO PUSH TO CORRECT ORDER ID
                            this.loadingOrders= true
                            this.cusID = cusID
                            let params = this.getParamsDetailOrders(
                                this.cusID,
                                this.detailLimit,
                            );
                            setTimeout(() => {
                                axios.get("api/getCustomerOrders", {params})
                                    .then((response) => {
                                        this.loadingOrders = false
                                        let arr = [];
                                        arr = response.data[0]
                                        //value1.orders = []
                                        arr.forEach((value, index) => {
                                            value1.orders.push(arr[index])
                                        })
                                        value1.orders.push(response.data['total']);
                                    })
                                    .catch((e) => {
                                        console.log(e);
                                    });
                            }, 250);
                        }
                    }
                })
            }
        },

        showAllOrders(orderID, limit){
            if (limit) {
                this.detailLimit = limit
            }

            this.customers.data.forEach((value1, index1) => {
                if (value1.id === orderID) { //CHECK TO PUSH TO CORRECT ORDER ID
                    this.loadingButton = true
                    this.ordID = orderID
                    let params = this.getParamsDetailOrders(
                        this.ordID,
                        this.detailLimit,
                    );
                    setTimeout(() => {
                        axios.get("api/getCustomerOrders", {params})
                            .then((response) => {
                                this.loadingButton = false
                                //this.changeToBanIcon(orderID) //Later will do
                                let arr = [];
                                arr = response.data[0]
                                value1.orders = []
                                arr.forEach((value, index) => {
                                    value1.orders.push(arr[index])
                                })
                                value1.orders.push(response.data['total']);
                            })
                            .catch((e) => {
                                console.log(e);
                            });
                    }, 250);
                }

            })
            this.detailLimit = 5; //reset limit
        },

        getParamsDetailOrders(orderID, limit){
            let params = {};
            if (orderID) {
                params["cusID"] = orderID;
            }

            if (limit) {
                params["limit"] = limit;
            }

            return params;
        },

        closeOpenedRows(){
            this.cusID = 0 //let row click can retrieve orders again

            const selector = $(".shadowed");
            selector.find('div.div-sub').slideUp(0)
            selector.removeClass('shadowed')

            let btn_detail = selector.parent('tbody').find('a.btn-detail')
            btn_detail.removeClass('rotate_up')

        },

        resetTable(){
            this.btnResetTableLoading = true
            setTimeout(()=>{
                this.page = 1
                this.orderBy = ['id','desc']
                this.sort_by_column = ''
                this.sort_direction = 'asc'
                this.switchSortIcon('id', 'default')
                this.btnResetTableLoading = false
                this.showingBtnResetTable = false
            },250)

        },

        switchSortIcon(byColumn, direction){
            let selector = $("#column_"+byColumn)
            let selectorActiveIcon = $("span.sort.active")
            let sort = selector.find('span.sort')

            selectorActiveIcon.addClass('default')
            selectorActiveIcon.removeClass('active sort-asc sort-desc')

            if (direction === 'asc')
                sort.addClass('sort-asc active')
            else if (direction === 'desc')
                sort.addClass('sort-desc active')
        },

        sortBy(byColumn){
            this.page = 1
            this.showingBtnResetTable = true
            if(this.sort_direction === 'asc' || this.sort_by_column !== byColumn){
                this.sort_direction = 'desc'
                this.switchSortIcon(byColumn, 'desc')
            }
            else
            {
                this.sort_direction = 'asc'
                this.switchSortIcon(byColumn,'asc')
            }

            this.sort_by_column = byColumn

            this.orderBy=[]
            this.orderBy[0] = byColumn
            this.orderBy[1] = this.sort_direction
            this.retrieveCustomers();

        },

        formatDate(value){
            return moment(value).format("LL");
        },

        getImgUrl(img) {
            return '/files/' + img
        },


    },
    computed:{

    },

    mounted() {
        this.retrieveCustomers();
        const vm = this

        let new_cus =  $('#new-customer');
        let cus_modal = $('#modal-customer');
        cus_modal.modal({
            backdrop: 'static',
            show: false,
        })

        new_cus.on('click',function (){
            vm.newModal()
        })
    },
}
</script>
<style scoped>
.card-footer{
    padding-bottom: 0;
}
</style>
