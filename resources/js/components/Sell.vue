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
                                        <h5 class="mr-4">June 19,2021</h5>
                                        <h5 class="mr-4">14:19</h5>
                                    </div>
                                    <div v-for="(product,index ) in products" :key="product.id" @click="operation(index, product.id, 'increase', 0)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3" id="sell-product">
                                        <div class="rounded shadow-sm sell-card">
                                            <img :src="'/files/'+product.photo" alt="Product Image" class="rounded" style="width: 100%; height: 100%">
                                            <div class="pro-text position-absolute d-flex align-items-start flex-column">
                                                <h1 class="p-lg-4 p-md-3 text-gray mb-auto qty">{{ product.qty }}</h1>
                                                <span class="product-description bg-black-overlay p-lg-2 px-lg-3 p-md-2 pl-md-3 ml-2">
                                                <h6>{{product.name_kh}}</h6>
                                                <p class="">{{convertToCurrency(product.price)}}៛</p>
                                            </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 pr-lg-5 d-flex flex-column">
                    <div class="banner">
                        <div class="header d-flex">
                            <h2 style="width: 100%">Current Orders</h2>
                            <p class="">Sopheak</p>
                        </div>
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <i class="fas fa-shopping-basket order" v-show="order.length===0"></i>
                                <table class="table table-head-fixed text-nowrap">
                                    <tbody>
                                    <tr v-for="(ord, index) in order" :key="index">
                                        <td class="products-list" style="padding-left: 12px">
                                            <div class="product-img">
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
                                            {{ convertToCurrency(ord.amount) }}៛
                                        </td>

                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer" v-show="order.length>=8"></div>
                        </div>

                        <div class="pay mt-auto d-flex flex-column">
                            <div class="subtotal d-flex">
                                <h5>Subtotal</h5>
                                <h4 class="ml-auto">{{ convertToCurrency(subTotal) }}.00៛</h4>
                            </div>
                            <div class="discount d-flex">
                                <h5>Discount</h5>
                                <h4 class="ml-auto">{{ convertToCurrency(discount) }}.00៛</h4>
                            </div>
                            <div class="total d-flex style7">
                                <h5>Total</h5>
                                <h4 class="ml-auto">{{convertToCurrency(total)}}.00៛</h4>
                            </div>
                            <button type="button" class="btn btn-block btn-info mb-3 mt-2" @click="cashIn">Charge {{convertToCurrency(total)}}.00៛</button>
                            <div class="small-icon d-flex justify-content-between mt-auto">
                                <a href="#" class="btn btn-outline-warning"><i class="fas fa-percent"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                                <a href="#" class="btn btn-outline-warning"><i class="ion-beer"></i></a>
                            </div>
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
                            <CashIn ref="cashIn"></CashIn>
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
    export default {
        components:{CashIn},
        data () {
            return{
                categories:{},
                products:[],
                tmp:0,
                order: [],

                subTotal:0,
                discount:0,
                total:0,
                currentCate:'ទំនិញគ្រប់មុខ',
                form : new Form(),

            }
        },
        methods:{
            showModal(){
                $('#modal-cashIn').modal('show')
                this.$refs.cashIn.setToTalToPay(this.total)
                this.$refs.cashIn.calculate()
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
                return converted = formatter.format(price)
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
                    console.log('Product Length: '+proLength)
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

            operation(index, proID, oper, orderIndex){
                /*TO HANDLE USER INCREASE OR DECREASE QTY*/
                let qty = this.products[index].qty
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
                this.products[index].qty = qty
                this.addOrder(index,proID, oper)
                this.changeColorQty(index, qty)
            },

            changeColorQty(index, qty){
                /*THE PROBLEM WAS HAPPENED COZ PRODUCTS LOAD TO PAGE WAS DELAY LATE THEN CODE*/
                /*SO WE NEED TO USE setTimeout TO SOLVE WHEN CALL THIS METHOD*/
                let selector = $("h1.qty:eq("+index+")");
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
                            'qty': this.products[i].qty,
                            'amount': this.products[i].price,
                            'image': this.products[i].photo,
                        });
                    }
                }
            },
            cashIn(){
                if(this.order.length > 0){
                    this.showModal()
                }
                else alert('Please make order!')
            },
            saveOrder(){
                this.form = new Form({
                    id:"",
                    user_id: "1",
                    customer_id: "2",
                    table_id: "1",
                    shop_id: "1",
                    payment_id: "1",
                    order: this.order,
                    subTotal: this.subTotal,
                    discount: this.discount,
                    total: this.total,

                })

                this.form.post('api/save-order')
                    .then(response => {
                        this.clear()
                    })
                    .catch(err => console.log(err))
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

        },
        watch: {
            subTotal(){
                return this.total =  parseInt(this.subTotal) - parseInt(this.discount)
            },

            order: {
                handler: function (val, oldVal) { this.calSubTotal() },
                deep: true
            },

        },

        mounted() {
            this.loadCategoriesSell()
            this.loadAllProducts()
        }
    }
</script>


