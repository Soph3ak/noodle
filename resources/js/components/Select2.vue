<template>
    <div>
        <Select2 v-model="myValue" :options="categories" :settings="{ placeholder: 'ជ្រើសរើសប្រភេទ'}"
                 @change="myChangeEvent($event)"
                 @select="mySelectEvent($event)"
                 ref="select2"
        />
    </div>
</template>

<script>
import Select2 from 'v-select2-component';

export default {

    components: {Select2},
    data() {
        return {
            myValue: '',
            categories: [],
        }
    },
    methods: {
        myChangeEvent(val){
            console.log(val);
            this.$emit("getCategory", val);
        },
        mySelectEvent({id, text}){
            console.log({id, text})
        },
        getCategories(){
            axios.get('api/getCategoriesSelect2')
                .then(response => {
                    this.categories = response.data;
                    this.myValue = this.categories.id
                });
        },
        clearSelect2(){
            this.myValue=''
        },
        updateSelect2(val){
            this.myValue = val
        }
    },
    mounted() {
        this.getCategories()
    },

}
</script>
<style scoped>

</style>


