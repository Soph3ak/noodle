<template>
    <div>
        <div class="row px-5">
            <div class="col-6">
                <h1 class="text-blue">{{name_kh}}</h1>
                <h6 class="text-blue mt-3">{{name}}</h6>
                <br>

                <p class="label text-gray">Email</p>
                <h4>{{email}}</h4><br/>

                <p class="label text-gray">លេខទូរសព្ទ័</p>
                <div class="test-anime">
                    <h4 v-for="(n,index) in num" :key="n.id">{{num[index]}}</h4><br>
                </div>

                <p class="label text-gray">អាសយដ្ធាន(ខ្មែរ)</p>
                <h4>{{address_kh}}</h4><br/><br/>
                <p class="label text-gray">អាសយដ្ធាន</p>
                <h5>{{address}}</h5><br/><br/>

                <a href="#" class="text-info font-weight-bolder" data-toggle="modal" data-target="#modal-shop" @click="resetForm() ;editModal()" v-if="shop.length>0">Edit Info</a>
                <a href="#" class="text-info font-weight-bolder" data-toggle="modal" data-target="#modal-shop" @click="newModal(); resetForm()" v-else>Create New Shop</a>
            </div>
            <div class="col-6 shop-img">
                <img :src="'icons/shop.png'" alt="" width="100%">
            </div>
        </div>
        <!-- /.row -->
        <!-- modal SeatTable -->
        <div class="modal fade" id="modal-shop" style="display: none;" aria-hidden="true">
                <div class="modal-dialog">
                    <form @submit.prevent="editMode ? updateShop(form.id): saveShop()">
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
                                    <label for="name">ឈ្មោះហាង(ខ្មែរ)</label>
                                    <input type="text" class="form-control" id="name_kh" name="name-kh" placeholder="ឈ្មោះហាង(ខ្មែរ)" v-model="form.name_kh" :class="{ 'is-invalid': form.errors.has('name_kh') }">
                                    <has-error :form="form" field="name_kh"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="name">ឈ្មោះហាង(EN)</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះហាង" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="email">អុីមែល</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="អុីមែល" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="">លេខទូរសព្ទ័</label>
                                    <!--<span class="badge badge-primary ml-2 p-2 add__more" @click="addMoreNumber">ADD NEW NUMBER</span>-->
                                    <div v-for="(phone,index) in form_phone.f_phones" class="form-group">
                                        <div class="input-group input-group">
                                            <input type="text" class="form-control" name="phone" placeholder="លេខទូរសព្ទ័" v-model="form_phone.f_phones[index].phone_number" :class="{ 'is-invalid': form_phone.errors.has('phone_number') }">
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-danger btn-flat" @click="removeNumber(index,form_phone.f_phones[index].id);"><i class="ion-minus"></i></button>
                                            </span>
                                            <has-error :form="form_phone" field="phone_number"></has-error>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-block btn-sm add__more" @click="addMoreNumber"><span class="d-flex justify-content-center align-items-center"><i class="gg-add mr-2"></i><p class="mb-0">Add new number</p></span></button>
                                    <!--<div v-for="(phone,index) in form_phone.f_phones" :key="phone.id" class="form-group">
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="លេខទូរសព្ទ័" v-model="form_phone.f_phones[index].phone_number" :class="{ 'is-invalid': form.errors.has('phone_number') }">
                                        <has-error :form="form_phone" field="phone_number"></has-error>
                                    </div>-->
                                </div>
                                <div class="form-group">
                                    <label for="address_kh">អាសយដ្ធាន(ខ្មែរ)</label>
                                    <input type="text" class="form-control" id="address_kh" name="description" placeholder="អាសយដ្ធាន(ខ្មែរ)" v-model="form.address_kh" :class="{ 'is-invalid': form.errors.has('address_kh') }">
                                    <has-error :form="form" field="address_kh"></has-error>
                                </div>
                                <div class="form-group">
                                    <label for="address">អាសយដ្ធាន(En)</label>
                                    <input type="text" class="form-control" id="address" name="description" placeholder="អាសយដ្ធាន(EN)" v-model="form.address" :class="{ 'is-invalid': form.errors.has('address') }">
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
            shop:[],
            phones:[],
            num:[],
            num_id:[],
            editMode : true,
            isNumRemoved:false,
            isHasNum2Delete:false ,

            id:"",
            name: "",
            name_kh: "",
            email: "",
            phone_number: "",
            address:"",
            address_kh:"",

            form_phone: new Form({
                f_phones:[],
                d_phones:[],
            }),

            form: new Form({
                id:"",
                name: "",
                name_kh:"",
                email: "",
                address:"",
                address_kh:"",
                /*_token: this.token.value*/
            })

        }
    },
    methods:{

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(){
            this.form.clear()
            this.editMode=true
            this.form.id = this.id
            this.form.name = this.name
            this.form.name_kh = this.name_kh
            this.form.email = this.email
            this.form.address = this.address
            this.form.address_kh = this.address_kh

            this.getPhones()

        },

        resetForm(){
            this.form.reset()
            this.form.clear()
            this.isHasNum2Delete = false
            this.num_id=[]
            this.form_phone.d_phones=[]
            this.form_phone.f_phones=[]
        },

        hideModal(){
            $('#modal-shop').modal('hide')
            this.form.reset()
            this.resetForm()
        },

        getShop() {
            axios.get('api/getShop')
                .then(response => {
                    this.shop = []
                    this.shop.push(response.data);
                    this.id = this.shop[0].id;
                    this.name = this.shop[0].name
                    this.name_kh = this.shop[0].name_kh
                    this.email = this.shop[0].email
                    this.address = this.shop[0].address
                    this.address_kh = this.shop[0].address_kh
                    this.getPhones()

                });
        },

        getPhones() {
            axios.get('api/getPhones')
                .then(response => {
                    this.phones = response.data;
                    this.form_phone.f_phones = this.phones
                    this.num = [];
                    for(let i=0; i<this.phones.length; i++){
                        this.num.push(this.phones[i].phone_number)
                    }

                });
        },

        updateShop(id){
            this.form.put('api/shop/'+id)
                .then(response => {
                    this.updatePhone()
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        ifHasNum2Delete(){
            let NewNum = this.form_phone.d_phones.length
            for(let i=0; i<NewNum; i++){
                let id = this.form_phone.d_phones[i].id
                let num = this.form_phone.d_phones[i].phone_number
                if (id !== '' && num !==''){
                    this.isHasNum2Delete=true
                    break
                }
                else
                    this.isHasNum2Delete=false
            }

        },

        updatePhone(){
            this.form_phone.put('api/phones')
                .then(response => {
                    if(this.isHasNum2Delete === true){
                        this.deleteNumber()
                    }
                    this.getShop()
                    this.alertSuccess('Updated successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)

        },

        saveShop(){
          alert('Save shop have nothing')
        },

        addMoreNumber(){
            this.form_phone.f_phones.push({
                "id":"",
                "phone_number":"",
                "shop_id":1,
                "created_at":"",
                "updated_at":""
            })
        },
        removeNumber(index,num_id) {
            this.form_phone.d_phones.push(this.form_phone.f_phones[index])
            this.form_phone.f_phones.splice(index, 1)
            this.ifHasNum2Delete()
        },

        deleteNumber(){
            this.form_phone.delete('api/phones')
                .then(response => {
                    /*this.getShop();
                    this.alertSuccess('Updated successfully');
                    this.hideModal();*/
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        alertSuccess(str1){
            Toast.fire({
                icon: 'success',
                title: str1
            })

        },

    },
    computed:{

    },

    mounted() {
        this.getShop();
        $('#modal-shop').modal({
            backdrop: 'static',
            show: false,
        })
    },
}
</script>
<style scoped>
.card-footer{
    padding-bottom: 0;
}
.add__more{
    cursor: pointer;
}
.gg-add{
    box-sizing: border-box;
    position: relative;
    display: block;
    width: 22px;
    height: 22px;
    border: 2px solid;
    transform: scale(var(--ggs,1));
    border-radius: 22px
}

.gg-add::after,
.gg-add::before {
    content: "";
    display: block;
    box-sizing: border-box;
    position: absolute;
    width: 10px;
    height: 2px;
    background: currentColor;
    border-radius: 5px;
    top: 8px;
    left: 4px
}

.gg-add::after {
    width: 2px;
    height: 10px;
    top: 4px;
    left: 8px
}
</style>

