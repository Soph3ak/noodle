<template>
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
                                <div v-for="category in categories" :key="category.id" @click="loadProductsByCategory(category.id)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3" id="sell-category">
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
                                    <a href="#" @click="loadAllProducts" class="mr-auto active">All Products</a>
                                    <a href="#" class="mr-4">Tables</a>
                                    <a href="#" class="mr-4">Customers</a>
                                </div>
                                <div v-for="(product,index ) in products" :key="product.id" @click="operation(index, product.id, 'increase', 0)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3" id="sell-product">
                                    <div class="rounded shadow-sm sell-card">
                                        <img :src="'/files/'+product.photo" alt="Product Image" class="rounded" style="width: 100%; height: 100%">
                                        <div class="cate-text position-absolute d-flex align-items-start flex-column">
                                            <h1 class="p-lg-4 p-md-3 text-gray mb-auto qty">{{ product.qty }}</h1>
                                            <span class="product-description bg-success p-lg-3 pl-lg-4 p-md-2 pl-md-3">
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
            <div class="col-lg-3 col-md-5 col-sm-5 banner pr-lg-5 d-flex flex-column">
                <div class="header">
                    <h2>Current Orders</h2>
                </div>
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                            <tr v-for="(order, index) in orders" :key="index">
                                <td class="products-list" style="padding-left: 12px">
                                    <div class="product-img">
                                        <img :src="'/files/'+order.image" alt="Product Image" class="img-size-50 rounded">

                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">{{ order.name_kh }}</a>
                                        <span class="product-description">{{ order.name }}</span>
                                    </div>
                                </td>
                                <td class="px-md-0 editQty">
                                    <a type="button" @click="operation(order.index, order.id, 'decrease', index)" class="testbutton"><i class="ion-minus"></i></a>
                                    <span class="m-lg-2 m-md-1">{{ order.qty }}</span>
                                    <a type="button" @click="operation(order.index, order.id, 'increase', index)" class="testbutton"><i class="ion-plus"></i></a>
                                </td>
                                <td class="text-right">
                                    {{ convertToCurrency(order.amount) }}៛
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
                <div class="pay mt-auto d-flex flex-column">
                    <div class="subtotal d-flex">
                        <h5>Subtotal</h5>
                        <h4 class="ml-auto">{{ convertToCurrency(subTotal) }}៛</h4>
                    </div>
                    <div class="discount d-flex">
                        <h5>Discount</h5>
                        <h4 class="ml-auto">{{ convertToCurrency(discount) }}៛</h4>
                    </div>
                    <div class="total d-flex">
                        <h5>Total</h5>
                        <h4 class="ml-auto">{{convertToCurrency(total)}}៛</h4>
                    </div>
                    <button class="btn btn-block btn-success mb-3 mt-2">Pay</button>
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
</template>

<script>

    export default {

        data () {
            return{
                categories:{},
                products:[],
                tmp:0,
                orders: [],

                subTotal:0,
                discount:0,
                total:0,
            }
        },
        methods:{

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
                axios.get('api/loadAllProducts')
                    .then(response => {
                        this.products = response.data;
                        this.ifOrdersExist()
                        this.tmp = 0
                    });
            },

            ifOrdersExist(){
                /*GET QTY FROM ORDERS IF EXIST, TO PREVENT USER MAKE ORDER THEN GO TO ANOTHER CATEGORY THEN QTY CHANGE TO 0*/
                    let orderLength = this.orders.length
                    let proLength = this.products.length
                    console.log('Product Length: '+proLength)
                    if (orderLength > 0){
                        for(let i=0; i < orderLength; i++){
                            let orderProID = this.orders[i].id
                            let orderProQty = this.orders[i].qty
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

            loadProductsByCategory(cateID){
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
                let ordersLength = this.orders.length
                if( ordersLength > 0){
                    for(let j=0; j<ordersLength; j++){
                        if(proID === this.orders[j].id){
                            let qty = this.orders[j].qty;
                            if (oper === 'increase')
                                qty += 1;
                            else
                                qty -= 1;
                            this.orders[j].qty = qty
                            this.orders[j].amount = this.orders[j].price * qty
                            return 0
                        }
                    }
                    if (oper === 'increase') {
                        this.orders.push({
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
                        this.orders.push({
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

            removeOrder (index) {
                /*TO REMOVE ORDER ITEM FROM CURRENT ORDER*/
                this.orders.splice(index, 1);
            },

            calSubTotal(){
                let total = [];
                Object.entries(this.orders).forEach(([key, val]) => {
                    total.push(val.amount) // the value of the current key.
                });
                return this.subTotal = total.reduce(function(total, num){ return total + num }, 0);
            },

        },
        watch: {
            subTotal(){
                return this.total =  parseInt(this.subTotal) - parseInt(this.discount)
            },

            orders: {
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


