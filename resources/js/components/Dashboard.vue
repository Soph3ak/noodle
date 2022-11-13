<template>
    <div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-info">
                    <div class="inner">
                        <h3>150</h3>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-gradient-danger">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
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
