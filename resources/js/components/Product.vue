<template>
    <div>
        <div class="row">
            <div class="col-9">
                <div class="card">
                    <!--<div class="card-header">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-product" @click="newModal()">
                            បង្កើតមុខម្ហូបថ្មី
                        </button>

                        <div class="card-tools mt-2">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- /.card-header -->
<!--myTable-->
                    <div class="card-body table-responsive p-0" style="">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th class="w-25">មុខម្ហូប</th>
                                <th>ប្រភេទ</th>
                                <th>ពត៌មានផ្សេងៗបន្ថែម</th>
                                <th class="text-center">កែប្រែ | EDIT</th>
                                <th class="text-center">លុប | DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id">
                                <td class="products-list">
                                    <div class="product-img mask-squircle">
                                        <img :src="getImgUrl(product.photo)" alt="Product Image" class="img-size-50">
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">{{ product.name_kh }}
                                            <span v-if="product.pro_discount>0" class="badge badge-danger float-right ml-1">{{ product.price - product.pro_discount }}៛</span>
                                            <span class="badge badge-warning float-right">{{ product.price }}៛</span>
                                        </a>
                                        <span class="product-description">{{ product.name }}</span>
                                    </div>
                                </td>
                                <td class="text-gray-dark">{{ product.category.name_kh }}</td>
                                <td class="text-gray">{{ product.description }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-product" @click="editModal(product)"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteProduct(product.name, product.id, product.photo)"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults" :limit="1" align="center">
                           <!-- <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>-->
                        </pagination>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-3">
                <category ref="cate" @refreshCate="refreshCategory"></category>
            </div>
        </div>
        <!-- /.row -->

<!--myForm-->
            <!-- modal product -->
            <div class="modal fade" id="modal-product" style="display: none;" aria-hidden="true" ref="vueModal">
                <div class="modal-dialog modal-xl">
                    <form @submit.prevent="editMode ? updateProduct(form.name_kh,form.id):saveProduct(form.name_kh) ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-if="editMode"><i class="ion-android-restaurant mr-2"></i>កែប្រែព័ត៌មានមុខម្ហូប</h4>
                                <h4 class="modal-title" v-else><i class="ion-android-restaurant mr-2"></i>បង្កើតមុខម្ហូបថ្មី</h4>
                                <button type="button" class="close" data-toggle="modal" data-target="#modal-product">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="mr-2 col-5 ">
                                        <drop-zone @getFileName="updateFileName" @dbRemoveFileName="updateProduct" ref="myVueDropzone"/>
<!--                                        <img src="https://static.independent.co.uk/s3fs-public/thumbnails/image/2019/02/26/16/nikldn-692193-unsplash.jpg?width=640&auto=webp&quality=75" alt="..." class="rounded shadow" width="93%">-->
                                    </div>
                                    <div class="ml-n2 mt-n2 col-7">
                                        <div class="form-group">
                                            <label for="name_kh">ឈ្មោះមុខម្ហូប (ខ្មែរ)</label>
                                            <input type="text" class="form-control" id="name_kh" name="name_kh" placeholder="ឈ្មោះមុខម្ហូប (ខ្មែរ)" v-model="form.name_kh" :class="{ 'is-invalid': form.errors.has('name_kh') }">
                                            <has-error :form="form" field="name_kh"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <label for="name">ឈ្មោះមុខម្ហូប</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះមុខម្ហូប" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="price">តម្លៃ</label>
                                                    <!--<currency-input v-model="value" class="form-control" placeholder="តម្លៃ" :class="{ 'is-invalid': form.errors.has('price') }" v-currency="{currency: {prefix:'', suffix:'៛'}, locale: 'en'}"/>-->
                                                    <input v-currency="{
                                               currency: {prefix:'', suffix:'៛'},
                                               locale: 'en',
                                               allowNegative: false,
                                            }" class="form-control" id="price" name="price" ref="price" :placeholder='value>0?"":"តម្លៃ"'
                                                           v-model="value" :class="{ 'is-invalid': form.errors.has('price') }"/>
                                                    <has-error :form="form" field="price"></has-error>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                    <div class="form-group">
                                                        <label for="discount">បញ្ចុះតម្លៃ</label>
                                                        <!--<currency-input v-model="value" class="form-control" placeholder="តម្លៃ" :class="{ 'is-invalid': form.errors.has('price') }" v-currency="{currency: {prefix:'', suffix:'៛'}, locale: 'en'}"/>-->
                                                        <input v-currency="{
                                               currency: {prefix:'', suffix:'៛'},
                                               locale: 'en',
                                               allowNegative: false,
                                            }" class="form-control" id="discount" name="price" ref="pro_discount" :placeholder='value_discount>0?"":"បញ្ចុះតម្លៃ"'
                                                               v-model="value_discount" :class="{ 'is-invalid': form.errors.has('pro_discount') }"/>
                                                        <has-error :form="form" field="pro_discount"></has-error>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="form-group">
                                            <label>ប្រភេទ</label>
                                            <Select2 style="width: 100%;" :class="{ 'is-invalid': form.errors.has('category_id')}" v-model="form.category_id" ref="select2" @getCategory="updateCategory"/>
                                            <!--<has-error :form="form" field="category_id"></has-error>-->
                                            <div v-if="form.errors.has('category_id')" class="help-block invalid-feedback">
                                                The category field is required.
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">ពត៌មានផ្សេងៗបន្ថែម  <span class="text-info text-capitalize"> [Optional]</span></label>
                                            <textarea class="form-control" rows="3" placeholder="ពត៌មានផ្សេងៗបន្ថែម ..." id="description" name="description" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                                            <!--<input type="text" class="form-control" id="description" name="description" placeholder="ផ្សេងៗ" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }">-->
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-product">បោះបង់</button>
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

import {getValue, setValue} from "vue-currency-input";
/*https://vuejsexamples.com/easy-input-of-currency-formatted-numbers-for-vue-js/*/
import DropZone from "./DropZone";
import Select2 from "./Select2";
import Category from "./Category";

export default {
    props: ['token'],
    components:{DropZone, Select2, Category},
    data () {
        return {
            currentPage:'1',    /*PAGINATION*/
            value: '',           /*CURRENCY*/
            value_discount: 0,
            products:{},
            editMode : false,
            form: new Form({
                id:"",
                name: "",
                name_kh: "",
                price: '',
                pro_discount: 0,
                photo: 'NO IMAGE.jpg',
                description:"",
                category_id: "",
                _token: this.token.value,

            }),

        }
    },

    methods:{

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(product){
            this.resetForm()
            this.editMode=true
            this.form.fill(product)
            this.value = this.form.price
            this.value_discount = this.form.pro_discount
            this.updateCurrency(this.value,this.value_discount)
            this.$refs.select2.updateSelect2(this.form.category_id)
            this.$refs.myVueDropzone.isEditImage(this.form.photo)

        },

        resetForm(){
            this.form.reset()
            this.value=''
            this.value_discount=0
            this.resetCurrency()
            this.photo= 'NO IMAGE.jpg'
            this.form.clear()
            this.$refs.myVueDropzone.clearDropZone()
            this.$refs.select2.clearSelect2()
        },

        hideModal(){
            this.resetForm()
            $('#modal-product').modal('hide')
        },

        getResults(page = 1) {
            axios.get('getProduct?page=' + page)
                .then(response => {
                    this.products = response.data;
                    this.currentPage = page;
                });
        },

        saveProduct(name){
            this.form.post('product')
            .then(response => {
                this.getResults(this.currentPage)
                this.alertSuccess('មុខម្ហូបឈ្មោះ',name,'បង្កើតបានជោគជ័យ!');
                this.hideModal();
            })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        updateProduct(name,id){
            this.form.put('product/'+id)
                .then(response => {
                    this.getResults(this.currentPage)
                    this.alertSuccess('មុខម្ហូបឈ្មោះ',name,'កែប្រែបានជោគជ័យ!')
                    this.hideModal();
                    this.$refs.myVueDropzone.oldFileRemoveAfterUpdatedOrDeleted('oldFile')
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        deleteProduct(name,id, photo){
            Swal.fire({
                title: 'Are you sure?',
                html: "តើអ្នកចង់លុបមុខម្ហូបឈ្មោះ <strong>" + name +" </strong>មែនទេ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'បោះបង់',
                confirmButtonText: 'បាទ/ចាស៎'/*Yes, delete it!*/
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('product/'+id)
                        .then(response => {
                            this.getResults(this.currentPage);
                            this.$refs.myVueDropzone.oldFileRemoveAfterUpdatedOrDeleted(photo)
                            Swal.fire(
                                'Deleted!',
                                "មុខម្ហូបឈ្មោះ <strong>" + name  +" </strong>ត្រូវបានលុបដោយជោគជ័យ!",
                                'success'
                            )
                        })
                        .catch(err => console.log(err))
                        .finally(() => this.loading = false)
                }
            })
        },

        alertSuccess(str1,name,str2){
            Toast.fire({
                icon: 'success',
                title: str1 +' '+ name +' '+ str2
            })

        },
        updateFileName(variable){
            this.form.photo=variable;
        },

        removeFileIfNotSave(){
            var photo = this.form.photo
            if (photo !=='' && photo!=='No IMAGE.jpg'){
                this.$refs.myVueDropzone.fileRemovedWithoutSave(photo)
            }
            else{
                this.$refs.myVueDropzone.oldFileRemoveAfterUpdatedOrDeleted('oldFile')
            }
        },

        getImgUrl(img) {
            return '/files/' + img
        },

        updateCurrency(val,val_discount) {
            setValue(this.$refs.price, val);
            setValue(this.$refs.pro_discount, val_discount);
        },

        resetCurrency() {
            setValue(this.$refs.price, null);
            setValue(this.$refs.pro_discount, null);
        },

        updateCategory(val){
            this.form.category_id = val
        },

        refreshCategory(){
            this.getResults();
            this.$refs.select2.getCategories();
        }
    },
    watch: {
        value() {
            this.form.price = getValue(this.$refs.price)
        },
        value_discount() {
            if(getValue(this.$refs.pro_discount)>0)
                this.form.pro_discount = getValue(this.$refs.pro_discount)
            else
                this.form.pro_discount = 0

        },
    },

    mounted() {
        this.getResults();

        var vm = this; /*TO CALL VUE methods INSIDE JQUERY*/
        $('#modal-product').on('hidden.bs.modal', function () {
            vm.removeFileIfNotSave()
            vm.resetForm()
        })

        $("#new-product").on('click',function (){
            vm.newModal()
        })
    },
    computed:{

    }

}

</script>
<style scoped>
.card-footer{
    padding-bottom: 0;
}
</style>
