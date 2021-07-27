<template>
        <div id="clock">
            <h5 class="date" v-text="currentDate"></h5>
            <h5 class="time" v-text="currentTime"></h5>
        </div>
</template>

<script>

    export default {
        data() {
            return {
                currentTime: null,
                currentDate: null,
            }

        },
        methods: {
            updateCurrentTime() {
                this.currentTime = moment().format("LT");
                this.currentDate = moment().format("LL");
            }
        },
        created() {
            this.currentTime = moment().format("LT");
            this.currentDate = moment().format("LL");
            /*https://momentjs.com/*/
            setInterval(() => this.updateCurrentTime(), 1 * 1000);
        },
        mounted() {

        }
    }
</script>


