<template>
    <div>
        <div class="row px-5">
            <div class="col-6">
                <p class="label text-gray">ឈ្មោះហាង</p>
                <h4>ម្ហូបស្រុកស្រែ</h4><br/>

                <p class="label text-gray">Email</p>
                <h4>sounsophek7@gmail.com</h4><br/>

                <p class="label text-gray">លេខទូរសព្ទ័</p>
                <h4>069 50 51 69</h4>
                <h4>060 30 99 77</h4><br/>

                <p class="label text-gray">អាសយដ្ធាន</p>
                <h4>Phum Kbal Spean, Sangkat Poipet, O’Chrov District, Banteay Meanchey Province, Kingdom Of Cambodia Poipet, Cambodia 01407</h4><br/>

                <a href="#" class="text-info font-weight-bolder" data-toggle="modal" data-target="#modal-shop">Edit Info</a>
            </div>
            <div class="col-6 shop-img">
                <img :src="'icons/shop.png'" alt="" width="100%">
            </div>
        </div>
        <!-- /.row -->
        <!-- modal SeatTable -->
        <div class="modal fade" id="modal-shop" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <form @submit.prevent="editMode ? updateShop(form.name,form.id):saveShop(form.name) ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" v-if="editMode"><span><i class="fas fa-store mr-2"></i></span>កែប្រែព័ត៌មានអំពីហាង</h4>
                                <h4 class="modal-title" v-else><span><i class="fas fa-store-alt mr-2"></i></span>បញ្ចូលព័ត៌មានអំពីហាង</h4>
                                <button type="button" class="close" data-toggle="modal" data-target="#modal-shop" @click="resetForm">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">ឈ្មោះហាង</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះហាង" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">អុីមែល</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="អុីមែល" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="phone">លេខទូរសព្ទ័</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="លេខទូរសព្ទ័" v-model="form.phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                                    <has-error :form="form" field="phone_number"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="address">អាសយដ្ធាន</label>
                                    <input type="text" class="form-control" id="address" name="description" placeholder="អាសយដ្ធាន" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }">
                                    <has-error :form="form" field="address"></has-error>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-shop" @click="resetForm">បោះបង់</button>
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

export default {

    props: ['token'],
    data () {
        return {
            currentPage:'1',
            shop:{},
            editMode : false,
            form: new Form({
                id:"",
                name: "",
                email: "",
                phone_number: "",
                address:"",
                _token: this.token.value
            })
        }
    },
    methods:{

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(shop){
            this.form.clear()
            this.editMode=true
            this.form.fill(shop)
        },

        resetForm(){
            this.form.reset()
            this.form.clear()
        },

        hideModal(){
            $('#modal-shop').modal('hide')
            this.form.reset()
        },

        getResults(page = 1) {
            axios.get('getShop?page=' + page)
                .then(response => {
                    this.shop = response.data;
                    this.currentPage = page;
                });
        },

        saveShop(name){
            this.form.post('shop')
            .then(response => {
                this.getResults(this.currentPage)
                this.alertSuccess('Table',name,'saved successfully');
                this.hideModal();
            })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        updateShop(name,id){
            this.form.put('shop/'+id)
                .then(response => {
                    this.getResults(this.currentPage)
                    this.alertSuccess('Table',name,'updated successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        deleteShop(name,id){
            Swal.fire({
                title: 'Are you sure?',
                html: "តើអ្នកចង់លុបតុឈ្មោះ <strong>" + name +" </strong>មែនទេ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'បោះបង់',
                confirmButtonText: 'បាទ/ចាស៎'/*Yes, delete it!*/
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('shop/'+id)
                        .then(response => {
                            this.getResults(this.currentPage);
                            Swal.fire(
                                'Deleted!',
                                "តុឈ្មោះ <strong>" + name  +" </strong>ត្រូវបានលុបដោយជោគជ័យ!",
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

    },
    computed:{

    },

    mounted() {
        this.getResults();
        const vm = this
        $("#new-shop").on('click',function (){
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
