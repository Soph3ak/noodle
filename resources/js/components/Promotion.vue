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
                                <th>ឈ្មោះតុ</th>
                                <th>តុកក់</th>
                                <th>ពត៌មានផ្សេងៗបន្ថែម</th>
                                <th class="text-center">កែប្រែ | EDIT</th>
                                <th class="text-center">លុប | DELETE</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="seatTable in seatTables.data" :key="seatTable.id">
                                <td>{{ seatTable.id }}</td>
                                <td>{{ seatTable.name }}</td>
                                <td v-if="seatTable.available === 0">កក់</td>
                                <td v-else>ទំនេរ</td>
                                <td>{{ seatTable.description }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modal-seatTable" @click="editModal(seatTable)"><i class="fas fa-pencil-alt"></i></button>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger" @click="deleteSeatTable(seatTable.name, seatTable.id)"><i class="far fa-trash-alt"></i></button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="seatTables" @pagination-change-page="getResults" :limit="1" align="center">
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
        <!-- modal SeatTable -->
        <div class="modal fade" id="modal-seatTable" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <form @submit.prevent="editMode ? updateSeatTable(form.name,form.id):saveSeatTable(form.name) ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-if="editMode"><span><i class="fas fa-chair mr-2"></i></span>កែប្រែព័ត៌មានតុ</h4>
                            <h4 class="modal-title" v-else><span><i class="fas fa-chair mr-2"></i></span>បញ្ចូលព័ត៌មានតុថ្មី</h4>
                            <button type="button" class="close" data-toggle="modal" data-target="#modal-seatTable" @click="resetForm">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ឈ្មោះតុ</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="ឈ្មោះតុ" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="available">តុកក់</label>
                                <select class="custom-select" v-model="form.available"  name="available" id="available">
                                    <option value="0">កក់</option>
                                    <option value="1">ទំនេរ</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="description">ពត៌មានផ្សេងៗបន្ថែម</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder="ពត៌មានផ្សេងៗបន្ថែម" v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="address"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#modal-seatTable" @click="resetForm">បោះបង់</button>
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
            seatTables:{},
            editMode : false,
            form: new Form({
                id:"",
                name: "",
                available: "1",
                description: "",
                _token: this.token.value
            })
        }
    },
    methods:{

        newModal(){
            this.editMode=false
            this.resetForm()
        },

        editModal(seatTable){
            this.form.clear()
            this.editMode=true
            this.form.fill(seatTable)
        },

        resetForm(){
            this.form.reset()
            this.form.clear()
        },

        hideModal(){
            $('#modal-seatTable').modal('hide')
            this.form.reset()
        },

        getResults(page = 1) {
            axios.get('api/getSeatTable?page=' + page)
                .then(response => {
                    this.seatTables = response.data;
                    this.currentPage = page;
                });
        },

        saveSeatTable(name){
            this.form.post('api/seat')
                .then(response => {
                    this.getResults(this.currentPage)
                    this.alertSuccess(name,'saved successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        updateSeatTable(name,id){
            this.form.put('api/seat/'+id)
                .then(response => {
                    this.getResults(this.currentPage)
                    this.alertSuccess(name,'updated successfully');
                    this.hideModal();
                })
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },

        deleteSeatTable(name,id){
            Swal.fire({
                title: 'Are you sure?',
                html: "តើអ្នកចង់លុបតុឈ្មោះ <strong>" + name +" </strong>មែនទេ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                allowOutsideClick: false,
                cancelButtonText:'Cancel',
                confirmButtonText: 'បាទ/ចាស៎'/*Yes, delete it!*/
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete('api/seat/'+id)
                        .then(response => {
                            this.getResults(this.currentPage);
                            Swal.fire({
                                    title: 'Deleted!',
                                    html: "តុឈ្មោះ <strong>" + name  +" </strong>ត្រូវបានលុបដោយជោគជ័យ!",
                                    icon: 'success',
                                    allowOutsideClick: false,
                                }



                            )
                        })
                        .catch(err => console.log(err))
                        .finally(() => this.loading = false)
                }
            })
        },

        alertSuccess(name,str){
            Toast.fire({
                icon: 'success',
                title: name +' '+ str
            })

        },

    },
    computed:{

    },

    mounted() {
        this.getResults();
        const vm = this

        let modal_seatTable = $("#modal-seatTable");
        modal_seatTable.modal({
            backdrop: 'static',
            show: false,
        })

        $("#new-table").on('click',function (){
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
