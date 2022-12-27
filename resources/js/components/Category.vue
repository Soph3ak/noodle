<template>
    <div id="category" ref="cate">
        <div class="card bg-gradient-info collapsed-card">
            <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                    <i class="fas fa-sitemap mr-1"></i>
                    CATEGORY
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                    <!--<button type="button" class="btn btn-primary btn-sm daterange" data-toggle="tooltip" title="Date range">
                        <i class="far fa-calendar-alt"></i>
                    </button>-->
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse" @click="newCategory">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
<!--my-form-->
            <div class="card-body" style="display: none;">
                <form @submit.prevent="editMode ? updateCategory(form.name_kh,form.id):saveCategory(form.name_kh) ">
                    <div class="form-group">
                        <label for="categoryNameKh">ឈ្មោះប្រភេទ(ខ្មែរ)</label>
                        <input type="text" class="form-control" id="categoryNameKh" placeholder="ឈ្មោះប្រភេទ (ខ្មែរ)" v-model="form.name_kh" :class="{ 'is-invalid': form.errors.has('name_kh') }">
                        <has-error :form="form" field="name_kh"></has-error>
                    </div>

                    <div class="form-group">
                        <label for="categoryName">ឈ្មោះប្រភេទ</label>
                        <input type="text" class="form-control" id="categoryName" placeholder="ឈ្មោះប្រភេទ" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                        <label for="categoryDescription">ពត៌មានផ្សេងៗបន្ថែម  <span class="text-info text-capitalize"> [Optional]</span></label>
                        <textarea class="form-control" rows="3" placeholder="ពត៌មានផ្សេងៗបន្ថែម ..." id="categoryDescription" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                        <!--<input type="text" class="form-control" id="description" name="description" placeholder="ផ្សេងៗ" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }">-->
                        <has-error :form="form" field="description"></has-error>
                    </div>
                    <button type="button" class="btn btn-danger float-left" @click="resetFormCategory">បោះបង់</button>
                    <button type="submit" class="btn btn-primary float-right" v-if="this.editMode">កែប្រែ</button>
                    <button type="submit" class="btn btn-primary float-right" v-else>រក្សារទុក</button>
                </form>
            </div>
        </div>
<!--my-table-->
        <div class="card">
            <div class="card-body table-responsive p-0" style="">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>ប្រភេទ</th>
                            <th>ពត៌មានផ្សេងៗបន្ថែម</th>
                            <th class="text-center w-25">កែប្រែ | EDIT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories.data">
                            <td class="products-list">
                                <!--<div class="product-img">
                                    <img src="/files/1617328706.99823.តុងយាំបង្កង.jpg" alt="Product Image" class="img-size-50">
                                </div> -->
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{category.name_kh}}</a>
                                    <span class="product-description">{{category.name}}</span>
                                </div>
                            </td>
                            <td>{{category.description}}</td>
                            <td class="text-center">
                                <button class="btn btn-warning editCategory" @click="editCategory(category)"><i class="fas fa-pencil-alt"></i></button>
                            </td>
                        </tr>
                        </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <pagination :data="categories" @pagination-change-page="getResults" :limit="1" align="center">
                    <!-- <span slot="prev-nav">&lt; Previous</span>
                     <span slot="next-nav">Next &gt;</span>-->
                </pagination>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</template>

<script>
    import {getValue} from "vue-currency-input";

    export default {
        data () {
            return {
                currentPage:'1',
                categories:{},
                editMode : false,
                form: new Form({
                    id:"",
                    name: "",
                    name_kh: "",
                    description:"",
                })
            }
        },
        methods:{
            resetFormCategory(){
                this.form.reset()
                this.form.clear()
                this.editMode = false
            },

            newCategory(){
                this.editMode=false
                this.resetFormCategory()
            },

            saveCategory(name){
                this.form.post('api/category')
                    .then(response => {
                        this.getResults(this.currentPage)
                        this.refreshProCate()
                        this.alertSuccess('Category',name,'saved successfully');
                        this.resetFormCategory()
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },

            editCategory(category){
                this.form.clear()
                this.editMode=true
                this.form.fill(category)
            },

            updateCategory(name,id){
                this.form.put('api/category/'+id)
                    .then(response => {
                        this.getResults(this.currentPage)
                        this.refreshProCate()
                        this.alertSuccess('Category',name,'updated successfully');
                        this.resetFormCategory()
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },

            getResults(page = 1) {
                axios.get('api/category?page=' + page)
                    .then(response => {
                        this.categories = response.data;
                        this.currentPage = page;
                    });
            },

            alertSuccess(str1,name,str2){
                Toast.fire({
                    icon: 'success',
                    title: str1 +' '+ name +' '+ str2
                })

            },

            refreshProCate(){
                this.$emit("refreshCate");
            },

        },

        mounted() {
            this.getResults();

            $("#category table tbody").on("click","button.editCategory",function (){
                $("#category .card").removeClass('collapsed-card')
                $("#category .card-header i").removeClass('fa-plus').addClass('fa-minus')
                $("#category .card-body").slideDown()

            })

        }
    }
</script>


