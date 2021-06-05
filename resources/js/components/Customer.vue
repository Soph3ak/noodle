<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive p-0" style="">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>លេខរៀង</th>
                                <th>ឈ្មោះអតិថិជន</th>
                                <th>ភេទ</th>
                                <th>លេខទូរសព័្ទ</th>
                                <th>អាសយដ្ធាន</th>
                                <th class="text-center">កែប្រែ | EDIT</th>
                                <th class="text-center">លុប | DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="customer in customers.data" :key="customer.id">
                                <td>{{ customer.id }}</td>
                                <td>{{ customer.name }}</td>
                                <td v-if="customer.gender === 0">ស្រី</td>
                                <td v-else>ប្រុស</td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.address }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-customer" @click="editModal(customer)"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteCustomer(customer.name, customer.id)"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="customers" @pagination-change-page="getResults" :limit="1" align="center">
                           <!-- <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>-->
                        </pagination>
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

export default {

    props: ['token'],
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
            })
        }
    },
    methods:{

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(customer){
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

        getResults(page = 1) {
            axios.get('getCustomer?page=' + page)
                .then(response => {
                    this.customers = response.data;
                    this.currentPage = page;
                });
        },

        saveCustomer(name){
            this.form.post('customer')
            .then(response => {
                this.getResults(this.currentPage)
                this.alertSuccess('Customer',name,'saved successfully');
                this.hideModal();
            })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        updateCustomer(name,id){
            this.form.put('customer/'+id)
                .then(response => {
                    this.getResults(this.currentPage)
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
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'បោះបង់',
                confirmButtonText: 'បាទ/ចាស៎'/*Yes, delete it!*/
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('customer/'+id)
                        .then(response => {
                            this.getResults(this.currentPage);
                            Swal.fire(
                                'Deleted!',
                                "អតិថិជនឈ្មោះ <strong>" + name  +" </strong>ត្រូវបានលុបដោយជោគជ័យ!",
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
        $("#new-customer").on('click',function (){
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
