<template>
    <div class="cash-in" ref="cashIn">
        <div class="row justify-content-between">
            <div class="col-3 pr-3">
                <div class="sidebar__display p-3 mb-3 text-right total-to-pay">
                    <h6 class="mb-3">តម្លៃសរុប</h6>
                    <h1 class="text-cyan text-bold">៛{{convertToCurrency(toTalToPay)}}</h1>
                    <h5 class="text-cyan text-bold" v-if="currencyText==='USD'">${{convertToCurrency2Digit(toTalToPay/usdRate)}}</h5>
                    <h5 class="text-cyan text-bold" v-else-if="currencyText==='THB'">฿{{convertToCurrency2Digit(toTalToPay/thbRate)}}</h5>
                    <h5 class="text-cyan text-bold" v-else-if="currencyText==='CNY'">¥{{convertToCurrency2Digit(toTalToPay/cnyRate)}}</h5>
                    <h5 class="text-cyan text-bold" v-else>${{convertToCurrency2Digit(toTalToPay/usdRate)}}</h5>
                    <!--<h5 class="text-cyan text-bold">${{convertToCurrency2Digit(toTalToPay/usdRate)}}</h5>
                    <h5 class="text-cyan text-bold">฿{{convertToCurrency2Digit(toTalToPay/thbRate)}}</h5>
                    <h5 class="text-cyan text-bold">¥{{convertToCurrency2Digit(toTalToPay/cnyRate)}}</h5>-->
                </div>
                <div class="sidebar__display p-3 mb-3 text-right received-money">
                    <div class="mr-1 flag"><img :src="getCurrencyImage()" alt="" width="32px" height="20px" class="mr-2">{{currencyText}}</div>
                    <h6 class="mb-3">ប្រាក់ទទួល</h6>
                    <h1 class="text-dark text-bold" v-if="currencyText==='USD'">${{convertToCurrency(USD)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='THB'">฿{{convertToCurrency(THB)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='CNY'">¥{{convertToCurrency(CNY)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='KHR'">៛{{convertToCurrency(KHR)}}</h1>
                    <h5 class="text-dark text-bold">៛{{ convertToCurrency(KHR) }}</h5>
                </div>
                <!--<div class="sidebar__display p-3 mb-3 text-right">
                    <div class="mr-1 flag"><img :src="'icons/KHR.png'" alt="" width="32px" height="20px" class="mr-2">KHR</div>
                    <h6 class="mb-3">ប្រាក់ទទួលរៀល</h6>
                    <h1 class="text-dark text-bold">{{ convertToCurrency(KHR) }}៛</h1>
                </div>-->
                <div class="sidebar__display p-3 mb-3 text-right change">
                    <h6 class="mb-3">ប្រាក់អាប់</h6>
                    <h1 class="text-dark text-bold">៛{{ convertToCurrency(change) }}</h1>
                </div>
                <div class="sidebar__display p-3 mb-3 text-right remain">
                    <h6 class="mb-3">ប្រាក់នៅខ្វះ</h6>
                    <h1 class="text-danger text-bold">៛{{ convertToCurrency(remain) }}</h1>
                </div>
                <div class="p-3 mb-3 text-right position-relative">
                    <div class="mr-1 flag"><img :src="getCurrencyImage()" alt="" width="32px" height="20px" class="mr-2">{{currencyText}}</div>
                    <h6 class="mb-3 text-dark">អត្រាប្តូរប្រាក់រៀល</h6>
                    <h1 class="text-dark text-bold" v-if="currencyText==='USD'">៛{{convertToCurrency(usdRate)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='THB'">៛{{convertToCurrency(thbRate)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='CNY'">៛{{convertToCurrency(cnyRate)}}</h1>
                    <h1 class="text-dark text-bold" v-if="currencyText==='KHR'">៛{{convertToCurrency(khrRate)}}</h1>
                </div>

            </div>
            <div class="container col-9">
                <div class="calculator card">
                    <div class="currency__switch">
                        <div class="dropdown show">
                            <a class="btn btn-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-1"><img :src="getCurrencyImage()" alt="" width="32px" height="20px" class="mr-2">{{currencyText}}</span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" @click="setCurrencyImage('/icons/KHR.png','KHR'); clear()"><img :src="'/icons/KHR.png'" alt="" width="32px" height="20px" class="mr-2">Cambodia - KHR</a>
                                <a class="dropdown-item" @click="setCurrencyImage('/icons/USD.jpg','USD'); clear()"><img :src="'/icons/USD.jpg'" alt="" width="32px" height="20px" class="mr-2">United States - USD</a>
                                <a class="dropdown-item" @click="setCurrencyImage('/icons/THB.png','THB'); clear()"><img :src="'/icons/THB.png'" alt="" width="32px" height="20px" class="mr-2">Thailand - THB</a>
                                <a class="dropdown-item" @click="setCurrencyImage('/icons/CNY.jpg','CNY'); clear()"><img :src="'/icons/CNY.jpg'" alt="" width="32px" height="20px" class="mr-2">China - CNY</a>

                            </div>
                        </div>

                    </div>
                    <p class="text-center total-cash">ប្រាក់ទទួល</p>
                    <!--<input type="text" class="calculator-screen z-depth-1" value="" disabled />-->
                    <div class="calculator-screen z-depth-1 received-money">
                        <p class="display khr"></p>
                    </div>
                    <div class="calculator-keys">

                        <button type="button" class="moneyInput function btn btn-info" value="100">100</button>
                        <button type="button" class="moneyInput function btn btn-info" value="500">500</button>
                        <button type="button" class="moneyInput function btn btn-info" value="1000">1000</button>
                        <button type="button" class="moneyInput function btn btn-info" value="10000">10000</button>

                        <button type="button" value="7" class="btn btn-light waves-effect">7</button>
                        <button type="button" value="8" class="btn btn-light waves-effect">8</button>
                        <button type="button" value="9" class="btn btn-light waves-effect">9</button>


                        <button type="button" class="back function btn btn-danger waves-effect"><i class="ion-backspace-outline"></i></button>
                        <button type="button" value="4" class="btn btn-light waves-effect">4</button>
                        <button type="button" value="5" class="btn btn-light waves-effect">5</button>
                        <button type="button" value="6" class="btn btn-light waves-effect">6</button>
                        <!--<button type="button" class="pay-and-print operator btn btn-success" @click="pay()"><i class="fas fa-print"></i></button>-->
                        <button type="button" class="pay-and-print operator btn btn-app" v-if="toTalToPay <= KHR" @click="print()"><i class="ion-printer"></i>PAY & PRINT</button>
                        <button type="button" class="pay-and-print operator btn btn-app" disabled v-else><i class="ion-printer"></i>PAY & PRINT</button>


                        <button type="button" value="1" class="btn btn-light waves-effect">1</button>
                        <button type="button" value="2" class="btn btn-light waves-effect">2</button>
                        <button type="button" value="3" class="btn btn-light waves-effect">3</button>


                        <button type="button" value="0" class="btn btn-light waves-effect">0</button>
                        <button type="button" value="00" class="btn btn-secondary">00</button>
                        <button type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear" ref="ac">AC</button>

                        <button type="button" class="equal-sign operator btn btn-success" v-if="toTalToPay <= KHR" @click="pay()">PAY</button>
                        <button type="button" class="equal-sign operator btn btn-warning" disabled v-else>PAY</button>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>

export default {
    data(){
        return{
            url:'/icons/KHR.png',
            currencyText:'KHR',
            toTalToPay:0,
            receivedMoney: 0,
            remain: 0,
            change: 0,
            KHR: 0,
            USD: 0,
            THB: 0,
            CNY: 0,
            usdRate: 4061.84,
            thbRate: 130.58,
            cnyRate: 636.14,
            khrRate: 1,

        }
    },

    methods: {

        clear(){
            this.$refs.ac.click()
        },

        reset(){
            this.url='/icons/KHR.png'
            this.currencyText='KHR'
            this.toTalToPay= 0
            this.receivedMoney= 0
            this.remain= 0
            this.change= 0
            this.KHR= '0'
            this.USD= 0
            this.THB= 0
            this.CNY= 0
            this.usdRate= 4061.84
            this.thbRate= 130.58
            this.cnyRate= 636.14
            this.khrRate= 1
        },

        setToTalToPay(price){
            this.toTalToPay = price
        },

        moneyExchange(){
            if(this.currencyText === 'USD'){
                this.USD = this.receivedMoney
                this.KHR = this.USD * this.usdRate
            }
            else if(this.currencyText === 'THB'){
                this.THB = this.receivedMoney
                this.KHR = this.THB * this.thbRate
            }
            else if(this.currencyText === 'CNY'){
                this.CNY = this.receivedMoney
                this.KHR = this.CNY * this.cnyRate
            }
            else if (this.currencyText === 'KHR'){
                this.KHR = this.receivedMoney
            }
        },

        convertToCurrency2Digit(price){
            /*https://flaviocopes.com/how-to-format-number-as-currency-javascript/*/
            let converted
            const formatter = new Intl.NumberFormat('en-US', {
                /*style: 'currency',
                currency: 'USD',*/
                minimumFractionDigits: 2
            })
            return converted = formatter.format(price)
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

        setCurrencyImage(url,text){
            this.url = url
            this.currencyText = text
        },

        displayToggleClass(){
            const selector = document.querySelector('p.display');
            if(this.currencyText === 'USD'){
                selector.classList.remove("thb")
                selector.classList.remove("cny")
                selector.classList.remove("khr")
                selector.classList.add("usd")
            }
            else if(this.currencyText === 'THB'){
                selector.classList.remove("usd")
                selector.classList.remove("cny")
                selector.classList.remove("khr")
                selector.classList.add("thb")
            }
            else if(this.currencyText === 'CNY'){
                selector.classList.remove("thb")
                selector.classList.remove("usd")
                selector.classList.remove("khr")
                selector.classList.add("cny")
            }
            else {
                selector.classList.remove("thb")
                selector.classList.remove("cny")
                selector.classList.remove("usd")
                selector.classList.add("khr")
            }
        },

        getCurrencyImage(){
            return this.url
        },

        calculate(){
            if(parseInt(this.KHR) < parseInt(this.toTalToPay)){
                console.log('up running')
                this.remain = this.KHR - this.toTalToPay
                this.change = 0
            }

            else {
                console.log('down running!!!!' +this.change+' '+parseInt(this.KHR)+' '+parseInt(this.toTalToPay))
                this.change = parseInt(this.KHR) - parseInt(this.toTalToPay)
                console.log('down running' + parseInt(this.change))
                this.remain = 0
            }
        },

        pay(){
            this.$emit("paySuccess");
        },

        alertSuccess(){
            console.log('Change: '+this.change)
            Swal.fire(
                'លុយអាប់: ' + this.convertToCurrency(this.change) +'៛',
                'ទូរទាត់បានដោយជោគជ័យ!<br>សូមអរគុណ!',
                'success'
            )
            console.log('Change: '+this.change)
            this.reset()
            this.clear()
        },

        fontResize(selector,length){
            if(length <= 8){
                selector.removeClass('smaller1 smaller2')
            }
            else if(length <= 9){
                selector.removeClass('smaller2')
                selector.addClass('smaller1')
            }
            else if(length > 9){
                selector.removeClass('smaller1')
                selector.addClass('smaller2')
            }
        },

        print(){
            this.$emit("print");
            //sent event to Sell.vue
        },

    },

    watch:{
        receivedMoney(){
            console.log('Here is watch runing - receivedMoney: '+this.receivedMoney)
            this.moneyExchange()
            console.log('Here is watch runing'+' - receivedMoney: '+this.receivedMoney+' KHR: '+this.KHR+' after exchange')
            this.calculate()

            let selector = $(".received-money")
            let length = (this.receivedMoney).toString().length
            this.fontResize(selector,length)
        },

        remain(){
            let selector = $(".remain")
            let length = this.remain.length
            this.fontResize(selector,length)
        },

        change(){
            let selector = $(".change")
            let length = (this.change).toString().length
            this.fontResize(selector,length)
        },

        currencyText(){
            this.moneyExchange()
            this.calculate()
            this.displayToggleClass()
        },


    },

    mounted() {
        const calculator = {
            displayValue: '0',
            moneyInput: false,
            digitInput: false,
            moneyHasValue: false,
            digitHasValue: false,
        };



        function inputDigit(digit) {

            const { displayValue, moneyInput, moneyHasValue, digitHasValue} = calculator;

            if (moneyInput === true) {
                if(moneyHasValue === true){
                    calculator.displayValue = displayValue === '0' || digitHasValue === true ? digit : (parseInt(displayValue) + parseInt(digit)).toString()
                    calculator.moneyInput = false;
                    calculator.digitHasValue = false
                }
            }
            else {

                if(displayValue === '0' || moneyHasValue === true){
                    if(digit === '00'){
                        digit = '0'
                    }
                    calculator.displayValue = digit

                }
                else {
                    calculator.displayValue = displayValue + digit
                }
                calculator.moneyHasValue = false
                calculator.digitHasValue = true
            }
        }

        /*function inputDecimal(dot) {
            // If the `displayValue` does not contain a decimal point
            if (!calculator.displayValue.includes(dot)) {
                // Append the decimal point
                calculator.displayValue += dot;
            }
        }*/

        /*function handleOperator(nextOperator) {
            const { firstOperand, displayValue, operator } = calculator
            const inputValue = parseFloat(displayValue);

            if (operator && calculator.waitingForSecondOperand)  {
                calculator.operator = nextOperator;
                return;
            }

            if (firstOperand == null) {
                calculator.firstOperand = inputValue;
            } else if (operator) {
                const currentValue = firstOperand || 0;
                const result = performCalculation[operator](currentValue, inputValue);

                calculator.displayValue = String(result);
                calculator.firstOperand = result;
            }

            calculator.waitingForSecondOperand = true;
            calculator.operator = nextOperator;
        }*/

        /*const performCalculation = {
            '/': (firstOperand, secondOperand) => firstOperand / secondOperand,

            '*': (firstOperand, secondOperand) => firstOperand * secondOperand,

            '+': (firstOperand, secondOperand) => firstOperand + secondOperand,

            '-': (firstOperand, secondOperand) => firstOperand - secondOperand,

            '=': (firstOperand, secondOperand) => secondOperand
        };*/

        function resetCalculator() {
            calculator.displayValue = '0';
            calculator.moneyInput = false;
            calculator.digitInput = false ;
            calculator.moneyHasValue = false;
            calculator.digitHasValue = false;
        }

        function back() {
            let value = calculator.displayValue
            if (value.length > 1){
                calculator.displayValue = value.substr(0, value.length - 1);
            }
            else {
                calculator.displayValue = '0'
            }
        }

        let vm = this;
        function updateDisplay() {
            const display = document.querySelector('.display');
            display.innerHTML = convertToCurrency(calculator.displayValue);
            vm.receivedMoney = calculator.displayValue

        }

        function convertToCurrency(price){
            /*https://flaviocopes.com/how-to-format-number-as-currency-javascript/*/
            let converted
            const formatter = new Intl.NumberFormat('en-US', {
                /*style: 'currency',
                currency: 'USD',*/
                minimumFractionDigits: 0
            })
            return converted = formatter.format(price)
        }

        updateDisplay();

        const keys = document.querySelector('.calculator-keys');
        keys.addEventListener('click', (event) => {
            const { target } = event;
            if (!target.matches('button')) {
                return;
            }

            /*if (target.classList.contains('operator')) {
                handleOperator(target.value);
                updateDisplay();
                return;
            }*/

            /*if (target.classList.contains('decimal')) {
                inputDecimal(target.value);
                updateDisplay();
                return;
            }*/

            if (target.classList.contains('all-clear')) {
                resetCalculator();
                updateDisplay();
                return;
            }

            if (target.classList.contains('back')) {
                back();
                updateDisplay();
                return;
            }

            if (target.classList.contains('moneyInput')) {
                calculator.moneyInput = true;
                calculator.moneyHasValue = true;
                inputDigit(target.value);
                updateDisplay();
                return;
            }

            if (target.classList.contains('equal-sign')) {
                return; //NO INPUT NEEDED, JUST DO FUNCTION @pay
            }

            inputDigit(target.value);
            updateDisplay();
        });
    }
}
</script>

<style scoped>
html {
    font-size: 62.5%;
    box-sizing: border-box;
}

*,
*::before,
*::after {
    margin: 0;
    /*padding: 0;*/
    box-sizing: inherit;
}

.calculator {
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}

.calculator-screen {
    width: 100%;
    height: 180px;
    border: none;
    background-color: #3e5761;
    color: #fff;
    text-align: center;
    z-index: 0;
    margin-top: -13px;
}

button {
    height: 83px;
    font-size: 2rem!important;
}

.equal-sign {
    height: 100%;
    grid-area: 4 / 4 / 6 / 5;
}

.calculator-keys {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 20px;
    padding: 20px;
}

.btn-info {
    background-color: #33b5e5!important;
    color: #fff;
}
.btn-light {
    background-color: #e0e0e0!important;
    color: #000;
}
.btn-white{
    background-color: #ffffff21;
    color: #ffffff;
    border-radius: 0;
    box-shadow: none !important;
}

.pay-and-print{
    font-size: 1.2rem !important;
    padding-top: 13px;
}
.pay-and-print i{
    font-size: 2rem !important;
    display: block;
    line-height: 0;
}

.btn{
    box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
    border: none;
}
i{
    pointer-events: none;
}
p{
    font-size: 1.5rem;
}

p.display{
    font-size: 8rem;
    position: relative;
}

p.usd::after {
    content: "$";
    color: inherit;
    font-size: 2.5rem;
    position: absolute;
    top: 2.5rem;
}
.khr::after {
    content: "៛";
    color: inherit;
    font-size: 3.5rem;
    position: absolute;
    top: 2rem;
}
.thb::after {
    content: "฿";
    color: inherit;
    font-size: 2.5rem;
    position: absolute;
    top: 2.5rem;
}
.cny::after {
    content: "¥";
    color: inherit;
    font-size: 2.5rem;
    position: absolute;
    top: 2.5rem;
}
.total-cash{
    z-index: 10;
    padding-top: 12px;
    background-color: #3e5761;
}
.remaining{
    padding: 5px 0;
    background-color: #2d4833;
}
.sidebar__display{
    position: relative;
    border-radius: 15px;
    background: #ecf0f3;
    box-shadow:  5px 5px 4px #bebebe,
    -5px -5px 4px #ffffff;
    border: 1px solid #e8e8e8;
}
.smaller1 h1{
    font-size: 2rem;
}
.smaller2 h1{
    font-size: 1.5rem;
}

.smaller1 p{
    font-size: 8rem;
}
.smaller2 p{
    font-size: 7rem;
}

.sidebar__display h6{
    color: #343a40;
    margin-bottom: 5px !important;
}

.currency__switch{
    position: absolute;
    right: 1rem;
    top: 1rem;
    z-index: 100;
}
.flag{
    position: absolute;
    left: 1rem;
    top: 1rem;
    z-index: 100;
    color: #bea4cc;
}

.dropdown-menu a{
    cursor: pointer;
}
h6{
    margin-bottom: 0;
    font-size: 1.2rem;
}


</style>


