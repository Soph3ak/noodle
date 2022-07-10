<template>
    <div>
        <div class="container-fluid" id="sell">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-7">
                    <div class="pl-lg-5 pl-md-2">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="header pl-3">
                                        <h2>Categories</h2>
                                    </div>
                                    <!-- Gallery item -->
                                    <div @click="loadAllProducts" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3">
                                        <div class="bg-gradient-danger rounded shadow-sm sell-card d-flex flex-column">
                                            <div class="cate-text p-lg-4 p-md-2">
                                                <h4>ទំនិញគ្រប់មុខ</h4>
                                                <span>All Products</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-for="category in categories" :key="category.id" @click="loadProductsByCategory(category.id, category.name_kh)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3" id="sell-category">
                                        <div class="bg-success rounded shadow-sm sell-card d-flex flex-column">
                                            <img :src="'/icons/'+category.name+'.jpg'" class="rounded">
                                            <div class="cate-text p-lg-4 p-md-2">
                                                <h4>{{ category.name_kh }}</h4>
                                                <span>{{ category.name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End -->
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="row">
                                    <div class="header pl-3 d-flex align-items-center">
                                        <a class="mr-auto">{{currentCate}}</a>
                                        <!--<h5 class="mr-4">{{ date }}</h5>-->
                                        <!--<h5 class="mr-4">{{ time }}</h5>-->
                                        <Clock></Clock>
                                    </div>
                                    <div v-for="(product,index ) in products" :key="product.id" @click="operation(index, product.id, 'increase', 0)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3" id="sell-product">
                                        <div class="rounded shadow-sm sell-card">
                                            <img :src="'/files/'+product.photo" alt="Product Image" class="rounded" style="width: 100%; height: 100%">
                                            <img v-if="product.pro_discount>0" :src="'/icons/discount.png'" alt="Discount Image" class="rounded dis-img">
                                            <div class="pro-text position-absolute d-flex align-items-start flex-column">
                                                <h1 class="p-lg-4 p-md-3 text-gray mb-auto qty">{{ product.qty }}</h1>
                                                <span class="product-description bg-black-overlay p-lg-2 px-lg-3 p-md-2 pl-md-3 ml-2">
                                                <h6>{{product.name_kh}}</h6>
                                                <p class="">{{convertToCurrency(product.price)}}៛ <span v-if="product.pro_discount>0" class="badge badge-danger float-right ml-1 p-1">{{ product.price - product.pro_discount }}៛</span></p>

                                            </span>

                                            </div>
                                        </div>
                                    </div>
                                    <Seat v-show="showSeat" ref="seat" @closeSeat="closeSeat()" @addSeat="addSeat1" @payment="payment"></Seat>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 pr-lg-5 d-flex flex-column">
                    <div class="banner">
                        <div class="header d-flex justify-content-between align-items-center">
                            <!--<h2 style="width: 100%">Current Orders</h2>
                            <p class="">Sopheak</p>-->


                                <div class="products-list add-seat" style="padding-left: 6px">
                                    <div class="product-img">
                                        <img src="/icons/tables-white.png" class="img-size-50 rounded" alt="Image"/>
                                    </div>
                                    <div class="product-info">
                                        <a class="product-title">SEAT</a>
                                        <span class="product-description">{{ seatName }}</span>
                                    </div>
                                </div>
                            <div class="products-list add-customer" style="padding-left: 6px; border-left: 1px solid #414040;">
                                <div class="product-img">
                                    <img src="/icons/customer-white.png" class="img-size-50 rounded" alt="Image"/>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">CUSTOMER</a>
                                    <span class="product-description">General</span>
                                </div>
                            </div>
                            <div class="products-list add-cashier" style="padding-left: 10px;border-left: 1px solid #414040;">
                                <div class="product-img">
                                    <img src="/icons/cashier-white.png" class="img-size-50 rounded" alt="Image"/>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">CASHIER</a>
                                    <span class="product-description">{{ userName }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <i class="fas fa-shopping-basket order" v-show="order.length===0"></i>
                                <table class="table table-head-fixed text-nowrap">
                                    <tbody>
                                    <tr v-for="(ord, index) in order" :key="index">
                                        <td class="products-list" style="padding-left: 12px">
                                            <div class="product-img mask-squircle">
                                                <img :src="'/files/'+ord.image" alt="Product Image" class="img-size-50 rounded">
                                            </div>
                                            <div class="product-info">
                                                <a href="javascript:void(0)" class="product-title">{{ ord.name_kh }}</a>
                                                <span class="product-description">{{ ord.name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-md-0 editQty">
                                            <a type="button" @click="operation(ord.index, ord.id, 'decrease', index)" class="testbutton"><i class="ion-minus"></i></a>
                                            <span class="m-lg-2 m-md-1">{{ ord.qty }}</span>
                                            <a type="button" @click="operation(ord.index, ord.id, 'increase', index)" class="testbutton"><i class="ion-plus"></i></a>
                                        </td>
                                        <td class="text-right">
                                            {{ convertToCurrency(ord.amount) }}៛<br>
                                            <span v-if="ord.discount>0" class="badge badge-danger float-right ml-1 p-1">{{ (ord.price - ord.discount)*ord.qty }}៛</span>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer" v-show="order.length>=8"></div>
                        </div>

                        <div class="pay mt-auto d-flex flex-column clickable">
                            <div class="subtotal d-flex">
                                <h5>Subtotal</h5>
                                <h4 class="ml-auto">{{ convertToCurrency(subTotal) }}៛</h4>
                            </div>
                            <div class="discount d-flex">
                                <h5>Discount</h5>
                                <h4 class="ml-auto">{{ convertToCurrency(discount) }}៛</h4>
                            </div>
                            <div class="total d-flex style7">
                                <h5>Total</h5>
                                <h4 class="ml-auto">{{convertToCurrency(total)}}៛</h4>
                            </div>
                            <!--<button type="button" class="btn btn-block btn-info mb-3 mt-2" @click="cashIn">Charge {{convertToCurrency(total)}}.00៛</button>-->
                            <div class="btn-hold_btn-clear d-flex justify-content-between">
                                <div class="btn-hold p-3 bg-info my-2 bg-gradient-danger" @click="openSeat('hold');clickablePay()"><h5>Hold</h5></div>
                                <div class="btn-clear p-3 bg-info my-2 bg-danger" @click="clearOrder"><h5>Clear</h5></div>
                            </div>
                            <div class="btn-pay d-flex justify-content-between p-3 my-2" @click="openSeat('pay'); clickablePay()">
                                <h5>PAY</h5>
                                <h4 class="to-pay">{{convertToCurrency(total)}}.00៛</h4>
                            </div>
                            <!--<div class="small-icon d-flex justify-content-between mt-auto">
                                <a href="#" class="btn btn-outline-warning"><i class="fas fa-percent"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                            </div>-->
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal customer -->
        <div class="modal fade" id="modal-cashIn" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title text-dark"><span><i class="ion-cash mr-2"></i></span>ទូរទាត់ប្រាក់</h3>
                            <button type="button" class="close" data-toggle="modal" data-target="#modal-cashIn" @click="">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <CashIn @paySuccess="saveOrder();" @print="print" ref="cashIn" ></CashIn>
                        </div>
                        <!--<div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-cashIn" @click="">បោះបង់</button>
                            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
                        </div>-->
                    </div>
                    <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
import CashIn from "./CashIn";
import Clock from "./Clock";
import Seat from "./Seat";
    export default {
        props: ['token'],
        components:{CashIn, Clock, Seat},
        data () {
            return{
                form : new Form(),
                user: [],
                userID: 1,
                userName: 'Cashier1',
                categories:{},
                products:[],
                tmp:0,
                order: [],
                paymentID:0,

                subTotal:0,
                discount:0,
                total:0,
                currentCate:'ទំនិញគ្រប់មុខ',

                date:'',
                time:'',

                showSeat: false,
                seatID: 1,
                seatName:'Take away',
                invoice:[],

                /*file:[],*/
            }
        },
        methods:{
            showModal(){
                $('#modal-cashIn').modal('show')
                this.$refs.cashIn.setToTalToPay(this.total)
                /*this.$refs.cashIn.calculate()*/
                this.paymentID = 1
            },
            hideModal(){
                $('#modal-cashIn').modal('hide')
            },

            clear(){
                this.tmp = 0
                this.order = []
                this.subTotal = 0
                this.discount = 0
                this.total = 0
                this.seatID= 1
                this.seatName='Take away'
                this.showSeat = false
                this.paymentID = 0
                this.form = new Form()
                for(let i=0; i<this.products.length; i++){
                    this.products[i].qty = 0
                    this.changeColorQty(i,this.products[i].qty)
                }


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

            loadCategoriesSell(){
                axios.get('api/loadCategoriesSell')
                    .then(response => {
                        this.categories = response.data;
                        this.ifOrdersExist()
                    });
            },

            loadAllProducts(){
                this.currentCate = 'ទំនិញគ្រប់មុខ'
                axios.get('api/loadAllProducts')
                    .then(response => {
                        this.products = response.data;
                        this.ifOrdersExist()
                        this.tmp = 0
                    });
            },

            ifOrdersExist(){
                /*GET QTY FROM ORDERS IF EXIST, TO PREVENT USER MAKE ORDER THEN GO TO ANOTHER CATEGORY THEN QTY CHANGE TO 0*/
                    let orderLength = this.order.length
                    let proLength = this.products.length
                    if (orderLength > 0){
                        for(let i=0; i < orderLength; i++){
                            let orderProID = this.order[i].id
                            let orderProQty = this.order[i].qty
                            for(let j=0; j < proLength; j++){
                                if(this.products[j].id === orderProID){
                                    this.products[j].qty = orderProQty
                                    setTimeout(() => this.changeColorQty(j,orderProQty), 0.1); /*COZ PRODUCTS LOAD TO PAGE WAS DELAY LATE THEN CODE*/
                                    break
                                }
                            }
                        }
                    }
            },

            loadProductsByCategory(cateID, cateName){
                this.currentCate = cateName
                if(cateID !== this.tmp){
                    axios.get('api/loadProductsByCategory/'+cateID)
                        .then(response => {
                            this.products = response.data
                            this.ifOrdersExist()
                        })
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
                    this.tmp = cateID
                }

            },

            operation(productIndex, proID, oper, orderIndex){
                /*TO HANDLE USER INCREASE OR DECREASE QTY*/
                /*productIndex: to increase qty in array products[]*/
                /*orderIndex: to remove an array from array order[]*/
                let qty = 0
                let ordersLength = this.order.length
                if( ordersLength > 0){
                    for(let j=0; j<ordersLength; j++){
                        if(proID === this.order[j].id)
                            qty = this.order[j].qty;
                    }
                }

                if (oper === 'increase')
                    qty+=1
                else {
                    if (qty > 1)
                        qty-=1
                    else{
                        qty-=1
                        this.removeOrder(orderIndex)
                        }
                }
                this.updateUIProductQty(proID,qty)
                this.addOrder(productIndex,proID, oper)
                /*this.changeColorQty(productIndex, qty)*/
            },

            updateUIProductQty(proID, qty){
                let productLength = this.products.length
                if( productLength > 0){
                    for(let j=0; j<productLength; j++){
                        if(proID === this.products[j].id){
                            this.products[j].qty = qty;
                            this.changeColorQty(j,qty)
                        }
                    }
                }
                else {
                    return 0
                }

            },
            changeColorQty(productIndex, qty){
                /*THE PROBLEM WAS HAPPENED COZ PRODUCTS LOAD TO PAGE WAS DELAY LATE THEN CODE*/
                /*SO WE NEED TO USE setTimeout TO SOLVE WHEN CALL THIS METHOD*/
                let selector = $("h1.qty:eq("+productIndex+")");
                if (qty > 0)
                    selector.removeClass('text-gray');
                else
                    selector.addClass('text-gray');
            },

            addOrder (i, proID, oper) {
                /**/
                let ordersLength = this.order.length
                if( ordersLength > 0){
                    for(let j=0; j<ordersLength; j++){
                        if(proID === this.order[j].id){
                            let qty = this.order[j].qty;
                            if (oper === 'increase')
                                qty += 1;
                            else
                                qty -= 1;
                            this.order[j].qty = qty
                            this.order[j].amount = this.order[j].price * qty
                            return 0
                        }
                    }
                    if (oper === 'increase') {
                        this.order.unshift({
                            'id': this.products[i].id,
                            'index': i,
                            'name_kh': this.products[i].name_kh,
                            'name': this.products[i].name,
                            'price': this.products[i].price,
                            'discount': this.products[i].pro_discount,
                            'qty': this.products[i].qty,
                            'amount': this.products[i].price,
                            'image': this.products[i].photo,
                        })
                    }
                }
                else {
                    if (oper === 'increase') {
                        this.order.push({
                            'id': this.products[i].id,
                            'index': i,
                            'name_kh': this.products[i].name_kh,
                            'name': this.products[i].name,
                            'price': this.products[i].price,
                            'discount': this.products[i].pro_discount,
                            'qty': this.products[i].qty,
                            'amount': this.products[i].price,
                            'image': this.products[i].photo,
                        });
                    }
                }
            },

            cashIn(){
                this.showModal()
            },

            saveOrder(){
                this.form = new Form({
                    id:"",
                    user_id: this.userID,
                    customer_id: "56",
                    table_id: this.seatID,
                    shop_id: "1",
                    payment_id: this.paymentID,
                    order: this.order,
                    subtotal: this.subTotal,
                    discount: this.discount,
                    total: this.total,

                })
                this.form.post('api/save-order')
                    .then(response => {
                        if(this.paymentID===1){
                            this.hideModal()
                            this.$refs.cashIn.alertSuccess()
                            this.closeSeat()
                        }
                        else if (this.paymentID===2)
                            this.$refs.seat.alertSuccess()

                        this.invoice=response.data
                        this.clear()

                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },

            print(){
                this.form = new Form({
                    id:"",
                    user_id: this.userID,
                    customer_id: "2",
                    table_id: this.seatID,
                    shop_id: "1",
                    payment_id: this.paymentID,
                    order: this.order,
                    subtotal: this.subTotal,
                    discount: this.discount,
                    total: this.total,

                })
                this.form.post('invoice')
                    .then(response => {
                        this.invoice = response.data
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            },

            removeOrder (index) {
                /*TO REMOVE ORDER ITEM FROM CURRENT ORDER*/
                this.order.splice(index, 1);
            },

            calSubTotal(){
                let total = [];
                Object.entries(this.order).forEach(([key, val]) => {
                    total.push(val.amount) // the value of the current key.
                });
                return this.subTotal = total.reduce(function(total, num){ return total + num }, 0);
            },

            calDiscount(){
                let total = [];
                Object.entries(this.order).forEach(([key, val]) => {
                    total.push(val.discount * val.qty) // the value of the current key.
                });
                return this.discount = total.reduce(function(total, num){ return total + num }, 0);
            },

            clearOrder(){
                let orderLength = this.order.length
                if (orderLength > 0){
                    Swal.fire({
                        title: 'Are you sure?',
                        html: "តើអ្នកចង់បោះបង់ការកម្មង់នេះមែនទេ?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText:'ទេ',
                        confirmButtonText: 'បាទ/ចាស៎'/*Yes, delete it!*/
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.clear()
                            this.$refs.cashIn.clear()
                            this.$refs.seat.clearSelected()
                            let productLength = this.products.length
                            if( productLength > 0){
                                for(let j=0; j<productLength; j++){
                                    this.products[j].qty = 0;
                                    this.changeColorQty(j,0)
                                }
                            }
                            else {
                                return 0
                            }
                        }
                    })
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Order',
                        text: 'We don\'t have any order currently !',
                    })
                }
            },

            openSeat(action){
                if(this.order.length > 0){
                    this.$refs.seat.getTotal(this.total)
                    if (this.seatID === 1) {
                        //TO MAKE "TAKE AWAY" AS DEFAULT SELECTED
                        this.$refs.seat.clearSelected()
                    }
                    this.showSeat = true
                    this.$refs.seat.getActionBtn(action)

                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Empty Order',
                        text: 'We don\'t have any order currently !',
                    })
                }
            },

            holdPayment(){
                this.paymentID = 2
                this.saveOrder()
            },

            payment(variable){
                if(variable==='hold'){
                    this.holdPayment()
                }
                else {
                    this.cashIn()
                }
            },

            clickablePay(){
                let pay = $("#sell .pay")
                if (this.showSeat === false)
                    pay.addClass('clickable')
                else
                    pay.removeClass('clickable')
            },

            closeSeat(){
                this.showSeat = false
                this.clickablePay()
            },

            addSeat1(var1,var2){
                this.seatID = var1
                this.seatName = var2
            },
            loadUser(){
                axios.get('loadUser')
                    .then(response => {
                        this.user.push(response.data)
                        this.userID = this.user[0].id
                        this.userName = this.user[0].name
                    });
            },

        },
        watch: {
            subTotal(){
                this.total =  parseInt(this.subTotal) - parseInt(this.discount)
                return this.$refs.seat.getTotal(this.total)
            },

            discount(){
                this.total =  parseInt(this.subTotal) - parseInt(this.discount)
                return this.$refs.seat.getTotal(this.total)
            },

            order: {
                handler: function (val, oldVal) { this.calSubTotal(); this.calDiscount() },
                deep: true
            },

        },

        mounted() {
            this.loadUser()
            this.loadCategoriesSell()
            this.loadAllProducts()

            $('#modal-cashIn').modal({
                backdrop: 'static',
                show: false,
            })
        }
    }
</script>
<style scoped>
    .dis-img{
        width: 80px;
        position: absolute;
        top: 0;
        right: 0;
        transform: rotate(35deg);
    }
    .btn-pay{
        background-color: dodgerblue;
    }

</style>

