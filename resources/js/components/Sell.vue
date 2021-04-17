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
                                <div v-for="category in categories" :key="category.id" @click="loadProductsByCategory(category.id)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3">
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
                                    <a href="#" class="mr-auto active">Desserts</a>
                                    <a href="#" class="mr-4">Tables</a>
                                    <a href="#" class="mr-4">Customers</a>
                                </div>
                                <div v-for="(product,index ) in products" :key="product.id" @click="increase(index)" class="col-xl-4 col-lg-4 col-md-6 mb-lg-4 mb-md-3">
                                    <div class="rounded shadow-sm sell-card">
                                        <img src="/files/1617893850.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50 rounded">
                                        <div class="cate-text position-absolute d-flex align-items-start flex-column">
                                            <h1 class="p-lg-4 p-md-3 text-gray mb-auto qty">{{ qtys[index].qty }}</h1>
                                            <h5 class="p-lg-3 pl-lg-4 p-md-2 pl-md-3">{{product.price}}៛</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="px-3 product">
                    <div class="row">
                        <div class="header pl-3">
                            <h2>FUCK</h2>
                        </div>
                        &lt;!&ndash; Gallery item &ndash;&gt;
                        <div class="col-4 mb-2">
                            <div class="bg-white rounded shadow-sm sell-card">
                                &lt;!&ndash;<img src="https://res.cloudinary.com/mhmd/image/upload/v1556294929/matthew-hamilton-351641-unsplash_zmvozs.jpg" alt="" class="img-fluid card-img-top">&ndash;&gt;
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class=" col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        <div class="col-4 mb-4">
                            <div class="bg-white rounded shadow-sm sell-card">
                            </div>
                        </div>
                        &lt;!&ndash; End &ndash;&gt;

                    </div>
                </div>-->
            </div>
            <div class="col-lg-3 col-md-5 col-sm-5 banner pr-lg-5 d-flex flex-column">
                <div class="header">
                    <h2>Current Orders</h2>
                </div>
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table class="table table-head-fixed text-nowrap">
                            <tbody>
                            <tr>
                                <td class="products-list" style="padding-left: 12px">
                                    <div class="product-img">
                                        <img src="/files/1617893850.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50 rounded">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">តុំយុាំគ្រឿងបង្កង</a>
                                        <span data-v-7e94e6d4="" class="product-description">តុំយុាំគ្រឿងបង្កង</span>
                                    </div>
                                </td>
                                <td class="px-md-0">
                                    <a type="button" class="testbutton"><i class="ion-minus"></i></a>
                                    <span class="m-lg-2 m-md-1">2</span>
                                    <a type="button" class="testbutton"><i class="ion-plus"></i></a>
                                </td>
                                <td class="text-right">
                                    20,000៛
                                </td>
                            </tr>
                            <tr>
                                <td class="products-list" style="padding-left: 12px">
                                    <div class="product-img">
                                        <img src="/files/1617893850.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50 rounded">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">តុំយុាំគ្រឿងបង្កង</a>
                                        <span data-v-7e94e6d4="" class="product-description">តុំយុាំគ្រឿងបង្កង</span>
                                    </div>
                                </td>
                                <td class="px-md-0">
                                    <a type="button" class="testbutton"><i class="ion-minus"></i></a>
                                    <span class="m-lg-2 m-md-1">2</span>
                                    <a type="button" class="testbutton"><i class="ion-plus"></i></a>
                                </td>
                                <td class="text-right">
                                    20,000៛
                                </td>
                            </tr>
                            <tr>
                                <td class="products-list" style="padding-left: 12px">
                                    <div class="product-img">
                                        <img src="/files/1617893850.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50 rounded">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">តុំយុាំគ្រឿងបង្កង</a>
                                        <span data-v-7e94e6d4="" class="product-description">តុំយុាំគ្រឿងបង្កង</span>
                                    </div>
                                </td>
                                <td class="px-md-0">
                                    <a type="button" class="testbutton"><i class="ion-minus"></i></a>
                                    <span class="m-lg-2 m-md-1">2</span>
                                    <a type="button" class="testbutton"><i class="ion-plus"></i></a>
                                </td>
                                <td class="text-right">
                                    20,000៛
                                </td>
                            </tr>
                            <tr>
                                <td class="products-list" style="padding-left: 12px">
                                    <div class="product-img">
                                        <img src="/files/1617893850.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50 rounded">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">តុំយុាំគ្រឿងបង្កង</a>
                                        <span data-v-7e94e6d4="" class="product-description">តុំយុាំគ្រឿងបង្កង</span>
                                    </div>
                                </td>
                                <td class="px-md-0">
                                    <a type="button" class="testbutton"><i class="ion-minus"></i></a>
                                    <span class="m-lg-2 m-md-1">2</span>
                                    <a type="button" class="testbutton"><i class="ion-plus"></i></a>
                                </td>
                                <td class="text-right">
                                    20,000៛
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
                        <h4 class="ml-auto">80,000៛</h4>
                    </div>
                    <div class="discount d-flex">
                        <h5>Discount</h5>
                        <h4 class="ml-auto">0.00៛</h4>
                    </div>
                    <div class="total d-flex">
                        <h5>Total</h5>
                        <h4 class="ml-auto">80,000៛</h4>
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
                products:{},
                qtys: [],
                tmp:0,
            }
        },
        methods:{
            loadCategoriesSell(){
                axios.get('api/loadCategoriesSell')
                    .then(response => {
                        this.categories = response.data;
                    });
            },

            loadProductsByCategory(cate){
                console.log('category_id: '+cate)
                if(cate !== this.tmp){
                    axios.get('api/loadProductsByCategory/'+cate)
                        .then(response => {
                            this.products = response.data;

                            this.qtys = []
                            for (let pro in this.products){
                                this.qtys.push({
                                    qty: 0,
                                });
                            }
                        });
                    this.tmp = cate
                }
            },

            increase(i){
                this.qtys[i].qty++
                let qty = this.qtys[i].qty
                let selector = $("h1.qty:eq("+i+")");
                if (qty > 0){
                    selector.removeClass('text-gray');
                }
            },

        },

        mounted() {
            console.log('mounted')
           this.loadCategoriesSell()

            /*let card_text = $(".card-text");
            card_text.hover(function (){
                $(this).hide()
                let img = $(".card-text ~ img");
                img.hide()
            })*/

            $(document).ready(function(){
                $("h1").hover(function(){

                    $(this).css("background-color", "yellow");
                }, function(){
                    $(this).css("background-color", "pink");
                });
            });

        }
    }
</script>


