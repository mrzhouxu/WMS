<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>店员管理</el-breadcrumb-item>
                <el-breadcrumb-item>编辑</el-breadcrumb-item>
            </el-breadcrumb>
            <div style="float:right;">
                <el-button id="back" size="small" onclick="history.back(-1)"><i class="el-icon-caret-left"></i> 返回</el-button>
                <el-button type="primary" icon="check" @click="submitForm()" size="small">
                    保存
                </el-button>
            </div>
        </div>

        <div>
            <el-form label-position="left" ref="form" :model="info" label-width="80px" style="display: inline-block;">
                <el-form-item label="照片">
                    <el-upload
                            class="avatar-uploader"
                            action="/admin/employee/img"
                            :headers="header"
                            :show-file-list="false"
                            :on-success="handleAvatarSuccess"
                            :before-upload="beforeAvatarUpload">
                        <img v-if="info.img" :src="'/show_img/'+info.img" class="avatar">
                        <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                    </el-upload>
                </el-form-item>
                <el-form-item label="姓名">
                    <el-input v-model="info.name"></el-input>
                </el-form-item>
                <el-form-item label="性别">
                    <!--<template>-->
                        <el-radio class="radio" v-model="info.sex" label="0">未知</el-radio>
                        <el-radio class="radio" v-model="info.sex" label="1">男</el-radio>
                        <el-radio class="radio" v-model="info.sex" label="2">女</el-radio>
                    <!--</template>-->
                </el-form-item>
                <el-form-item label="登录账号">
                    <el-input v-model="info.user" :disabled="this.id==true"></el-input>
                </el-form-item>
                <el-form-item label="联系方式">
                    <el-input v-model="info.phone"></el-input>
                </el-form-item>
                <el-form-item label="身份证号">
                    <el-input v-model="info.card"></el-input>
                </el-form-item>
                <el-form-item label="家庭住址">
                    <el-input v-model="info.address" type="textarea"></el-input>
                </el-form-item>
            </el-form>

        </div>
    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                header: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf"]').content,
                },
                imageUrl:'',
                loading:false,
                id:'',
                info:{
                    name:'',
                    img:'',
                    sex:'',
                    user:'',
                    phone:'',
                    card:'',
                    adress:''
                },
            }
        },
        methods : {
            handleAvatarSuccess(res, file) {
                this.info.img = file.response;
                this.imageUrl = URL.createObjectURL(file.raw);

            },
            beforeAvatarUpload(file) {
                const isJPG = true;
//                const isJPG = file.type === 'image/jpeg';
                const isLt2M = file.size / 1024 / 1024 < 2;

//                if (!isJPG) {
//                    this.$message.error('上传头像图片只能是 JPG 格式!');
//                }
                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isJPG && isLt2M;
            },
            getInfo(){
                axios.get('/admin/employee/get_info',{ params :{ id: this.id}})
                    .then(res=>{
                        this.loading = false
                        if(res.data.status == 1){
                            this.$router.go(-1)
                        }else if(res.data.status == 0){
                            this.info = res.data.result
                            this.info.sex = res.data.result.sex.toString()
                        }

                    })
                    .catch(err=>{
                        this.loading = false
                    })
            },
            submitForm(){
                this.loading = true
                if(this.id){
                    axios.post('/admin/employee/edit',this.info)
                        .then(res=>{
                            this.loading = false
                            this.$notify({
                                title: '成功',
                                message: '保存成功！',
                                type: 'success'
                            });
                        })
                        .catch(err=>{
                            this.loading = false
                        })
                }else{
                    axios.post('/admin/employee/add',this.info)
                        .then(res=>{
                            this.loading = false
                            if(res.data.status == 1){
                                this.$notify({
                                    title: '失败',
                                    message: res.data.msg,
                                    type: 'warning'
                                });
                            }else if(res.data.status == 0){
                                this.$notify({
                                    title: '成功',
                                    message: res.data.msg,
                                    type: 'success'
                                });
                            }

                        })
                        .catch(err=>{
                            this.loading = false
                        })
                }

            }
        },
        mounted(){
            this.id = this.$route.params.id
            if(this.id){
                this.loading = true
                this.getInfo()
            }
        }
    }
</script>
<style>
    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #20a0ff;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }
</style>