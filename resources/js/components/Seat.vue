<template>
    <div class="container seat" ref="seat">
        <div class="row justify-content-center">
            <div v-for="(seat,index ) in seats" :key="seat.id" class="col-xl-3 col-lg-3 col-md-6 mb-lg-4 mb-md-3" @click="addSeat(seat.id, seat.name)">
                <div class="rounded shadow-sm seat-card">
                    <img :src="'/icons/tables-white.png'" alt="Seat image" class="rounded" style="width: 100%; height: 100%" v-if="seat.id !==1">
                    <img :src="'/icons/take-away1.png'" alt="Seat image" class="rounded" style="width: 100%; height: 100%" v-else>
                    <div class="d-flex align-items-center flex-column">
                        <span class="">
                             <h6 class="text-uppercase">{{seat.name}}</h6>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-close" @click="closeSeat()">
            <i class="ion-close"></i>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return{
                seats:[],
            }
        },
        methods:{
            loadAllSeats(){
                axios.get('api/loadSeats')
                    .then(response => {
                        this.seats = response.data;
                    });
            },
            closeSeat(){
                this.$emit('closeSeat')
            },
            /*addSeat(seat_id, seat_name){
                this.$emit('addSeat', {
                    seat_id,
                    seat_name
                })
            },*/
            addSeat(seat_id, seat_name){
                this.$emit("addSeat", seat_id, seat_name)
            },
        },
        mounted() {
            this.loadAllSeats()
        }
    }
</script>
<style scoped>
    .seat{
        position: absolute;
        top: 120px;
        width: 100%;
        height: 100%;
        background-color: #000000f2;
        overflow: hidden;
        right: 0;
        animation: mymove .2s linear;

    }
    @keyframes mymove {
        0%   {width: 0px;}
        100% {width: 100%;}
    }

    .seat-card{
        width: 160px;
        background-color: red;
        padding: 15px;
        cursor: pointer;
    }
    .btn-close{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        font-size: 1.5rem;
        position: absolute;
        right: 30px;
        bottom: 80px;
        opacity: 1;
        background-color: dodgerblue;
        cursor: pointer;
        animation: btnClose .5s linear;
    }
    @keyframes btnClose {
        0%   {opacity:0; bottom: 0px;}
        100% {opacity:1; bottom: 80px;}
    }
</style>


