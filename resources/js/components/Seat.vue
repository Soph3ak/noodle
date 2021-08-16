<template>
    <div class="container seat" ref="seat">
        <div class="row justify-content-center">
            <div v-for="(seat,index ) in seats" :key="seat.id" class="col-xl-3 col-lg-3 col-md-6 mb-lg-4 mb-md-3" @click="addSeat(seat.id, seat.name, index)">
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
        <div class="btn-pay d-flex justify-content-between p-3 my-2" @click="pay()">
            <h5>PAY</h5>
            <h4 class="to-pay">{{convertToCurrency(total)}}.00៛</h4>
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
                total:0,
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

            addSeat(seat_id, seat_name, index){
                this.setSelected(index)
                this.$emit("addSeat", seat_id, seat_name)
            },

            setSelected(index){
                let selectedSeat = $(".seat-card:eq("+index+")")
                let allSeat = $(".seat-card")
                allSeat.removeClass('selected')
                selectedSeat.addClass('selected')
            },

            clearSelected(){
                let takeAwaySeat = $(".seat-card:eq(0)")
                let allSeat = $(".seat-card")
                allSeat.removeClass('selected')
                takeAwaySeat.addClass('selected')
            },

            pay(){
                this.$emit("pay")
            },

            getTotal(total){
                this.total=total
            },

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
        opacity: 1;
        animation: mymove .3s linear;
    }
    @keyframes mymove {
        0%   {width: 0; opacity: 0}
        25%   {width: 0; opacity: 0}
        100% {width: 100%;}
    }

    .seat-card{
        width: 160px;
        background-color: red;
        padding: 15px;
        cursor: pointer;
    }
    .seat-card.selected{
        background-color: darkred;
    }
    /*.btn-close{
        width: 50px;
        height: 50px;
        border-radius: 50%;
        text-align: center;
        line-height: 50px;
        font-size: 1.5rem;
        position: absolute;
        right: 30px;
        bottom: 50px;
        opacity: 1;
        background-color: dodgerblue;
        cursor: pointer;
        animation: btnClose .5s linear;
    }*/
    .btn-close{
        animation-duration: 1.5s;
        transform-origin: bottom;
        width: 60px;
        height: 60px;
        border-radius: 6px;
        text-align: center;
        line-height: 60px;
        font-size: 1.5rem;
        position: absolute;
        right: 20px;
        bottom: 58px;
        background-color: dodgerblue;
        cursor: pointer;
        animation-name: bounce-5;
        animation-timing-function: ease;
        opacity: 1;
    }

    .btn-pay{
        border-radius: 6px;
        width: 70%;
        height: 60px;
        position: absolute;
        margin: 0 auto;
        bottom: 50px;
        opacity: 1;
        left: 50%;
        cursor: pointer;
        animation: btnPay .5s linear;
        transform: translateX(-50%);
        background-color: dodgerblue;
    }
    /*@keyframes btnClose {
        0%   {opacity:0; bottom: 0px;}
        100% {opacity:1; bottom: 80px;}
    }*/

    @keyframes bounce-5 {
        0%   { transform: scale(1,1)    translateY(0); bottom: -15px; opacity: 0}
        10%  { transform: scale(1.1,.9) translateY(0); }
        30%  { transform: scale(.9,1.1) translateY(-100px);}
        50%  { transform: scale(1,1)    translateY(0);  bottom: 58px;}
        57%  { transform: scale(1,1)    translateY(-10px);  opacity: 1;}
        64%  { transform: scale(1,1)    translateY(0); }
        100% { transform: scale(1,1)    translateY(0); }
    }
</style>


