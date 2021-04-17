<template>
    <div style="overflow: hidden; position: relative">
        <vue-dropzone
            ref="myVueDropzone"
            id="dropzone"
            :options="dropzoneOptions"
            :useCustomSlot="true"
            v-on:vdropzone-success="uploadSuccess"
            v-on:vdropzone-error="uploadError"
            v-on:vdropzone-removed-file="fileRemoved"
        >
            <div class="dropzone-custom-content d-flex justify-content-center">
                <div class="">
                    <i class="ion ion-ios-cloud-upload-outline" style="font-size: 150px"></i>
                    <h3 class="dropzone-custom-title">Drag and drop to upload image!</h3>
                    <div class="subtitle">...or click to select a image from your computer</div>
                </div>
            </div>
        </vue-dropzone>
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
    components: {
        vueDropzone: vue2Dropzone
    },

    data() {
        return {
            editMode:false,
            dropzoneOptions: {
                url: "/api/files",
                /*headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },*/
                thumbnailWidth: 400,
                addRemoveLinks: true,
                maxFiles: 1,
                createImageThumbnails:true,


            },
            fileName: 'NO IMAGE.jpg',
            oldFile:'',
            imgName:'',
            imgSize:''
        };
    },
    methods: {
        iAmDropZone(){alert("I AM Drop Zone")},


        uploadSuccess(file, response) {
            var filePath = this.getImgUrl(response.file)
            console.log('File Successfully Uploaded with file name: ' + response.file);
            this.fileName = response.file;
            this.$emit("getFileName", this.fileName); /*PASS FILE NAME TO PRODUCT COMPONENT
            https://dev.to/alexmourer/sharing-data-between-components-invuejs-48me*/
            $(".dz-image img").attr("src", filePath);
            this.$refs.myVueDropzone.disable();
        },

        uploadError(file, message) {
            console.log('An Error Occurred');
        },

        fileRemoved(){
            this.fileRemovedWithoutSave(this.fileName)
        },

        fileRemovedWithoutSave(fileName) {
            if (fileName!=='' && fileName!=='NO IMAGE.jpg'){
                if (this.editMode !== true){                /*FOR CREATE NEW*/
                    axios.delete('api/files/' + fileName)
                    fileName='NO IMAGE.jpg'
                    this.$emit("getFileName", fileName) /*TO CHANGE product's photo to NO IMAGE.jpg'*/
                }
                else {                                      /*FOR EDIT*/
                    this.oldFile = fileName;
                    fileName='NO IMAGE.jpg'
                    this.$emit("getFileName", fileName)
                    if(this.oldFile!=='NO IMAGE.jpg' && this.imgSize===''){
                        axios.delete('api/files/' + this.oldFile)
                        this.oldFile=''
                    }
                }

                this.clearDropZone()
            }
            else if(this.oldFile!==''){

            }
        },

        oldFileRemoveAfterUpdatedOrDeleted(param){
            /*OR SET DELETE AND EDIT MODE*/
            /*AFTER UPDATED*/
            if(param === 'oldFile'){
                if(this.oldFile!=='' && this.oldFile!=='NO IMAGE.jpg'){
                    axios.delete('api/files/' + this.oldFile)
                    this.oldFile=''
                }
            }
            /*AFTER DELETED*/
            else {
                if (param !== 'NO IMAGE.jpg' && param !== ''){
                    axios.delete('api/files/' + param)
                }
            }

        },

        fileNotSave(){
            alert('File Not Save')
        },

        getImgUrl(img) {
            if(img === "NO IMAGE.jpg" && img !== ''){
               return ""
            }
            return '/files/' + img
        },
        subStrFileName(fileName){
            var str = fileName; /*1616667439.84165.Ammly_6214 (2).jpg*/
            var firstDot = str.indexOf('.');
            var lastDot = str.lastIndexOf('.');
            var sizeAndName = str.substring(firstDot+1);/*84165.Ammly_6214 (2).jpg*/

            var dot1 = sizeAndName.indexOf('.');
            this.imgSize = sizeAndName.substring(0,dot1);
            this.imgName = sizeAndName.substring(dot1+1);
            /*console.log(fileName)
            console.log(this.imgName)
            console.log(this.imgSize)*/

        },

        clearDropZone(){
            this.editMode=false
            this.fileName= 'NO IMAGE.jpg'
            this.imgName= ''
            this.imgSize= ''
            $("div.dz-preview:nth-child(2)").remove() /*TO PREVENT MULTIPLE IMAGE APPEARED*/
            this.$refs.myVueDropzone.enable() /*TO MAKE DROPZONE CLICKABLE*/
            this.$refs.myVueDropzone.removeAllFiles(true)
            $("#dropzone").removeClass("dz-started") /*TO SHOW DRAG AND DROP TEXT*/
        },

        isEditImage(fileName){
            /*this.clearDropZone()*/
            this.editMode = true
            this.fileName=fileName
            this.oldFile=''
            this.subStrFileName(fileName)

            var file = { size: this.imgSize, name: this.imgName, type: "" }
            var url = this.getImgUrl(fileName)
            if (url !== ""){
                this.$refs.myVueDropzone.manuallyAddFile(file, url)
                $('.dz-image img').removeAttr('style')
                this.$refs.myVueDropzone.disable()
            }
            else {
                $("div.dz-preview:nth-child(2)").remove()
                this.$refs.myVueDropzone.enable()
            }
        },
    },


    mounted() {

}
};



</script>
<style scoped>
.vue-dropzone{
    border: 2px dashed lightgray;
    height: 454px;
}
.dropzone{
    padding: 0;
}

.dropzone .dz-preview {
   position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
}
.vue-dropzone>.dz-preview .dz-image{
    z-index: 21;
}

</style>
