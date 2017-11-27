<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>经销商管理</el-breadcrumb-item>
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

                <el-form-item label="姓名">
                    <el-input v-model="info.name"></el-input>
                </el-form-item>

                <el-form-item label="联系方式">
                    <el-input v-model="info.phone"></el-input>
                </el-form-item>

                <el-form-item label="所属品牌">
                    <el-input v-model="info.address"></el-input>
                </el-form-item>

                <el-form-item label="所有产品">
                    <el-button @click="dialogFormVisible = true;product={name:'',in_price:'',out_price:'',unit:'',img:'',status:'0'}"><i class="ion-plus"></i> 添加产品</el-button>
                </el-form-item>

            </el-form>

            <el-dialog title="添加产品" :visible.sync="dialogFormVisible">

                <el-form  :model="product" style="display: inline-block;" label-width="80px">
                    <el-form-item label="商品图片">
                        <el-upload
                                class="avatar-uploader"
                                action="/admin/employee/img"
                                :headers="header"
                                :show-file-list="false"
                                :on-success="handleAvatarSuccess_add"
                                :before-upload="beforeAvatarUpload">
                            <img v-if="product.img" :src="'/show_img/'+product.img" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="商品名称">
                        <el-input v-model="product.name"></el-input>
                    </el-form-item>
                    <el-form-item label="商品分类">
                        <el-select v-model="product.type" placeholder="请选择">
                            <el-option
                                    v-for="item in productType"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="商品进价">
                        <el-input v-model="product.in_price"><template slot="append">元</template></el-input>
                    </el-form-item>
                    <el-form-item label="建议售价">
                        <el-input v-model="product.out_price"><template slot="append">元</template></el-input>
                    </el-form-item>
                    <el-form-item label="商品单位">
                        <el-input v-model="product.unit"></el-input>
                    </el-form-item>
                </el-form>

                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible = false">取 消</el-button>
                    <el-button type="primary" @click="add_product">确 定</el-button>
                </div>
            </el-dialog>

            <el-dialog title="编辑产品" :visible.sync="dialogFormVisible_edit">
                <el-form  :model="edit_product" style="display: inline-block;" label-width="80px">
                    <el-form-item label="商品图片">
                        <el-upload
                                class="avatar-uploader"
                                action="/admin/employee/img"
                                :headers="header"
                                :show-file-list="false"
                                :on-success="handleAvatarSuccess_edit"
                                :before-upload="beforeAvatarUpload">
                            <img v-if="edit_product.img" :src="'/show_img/'+edit_product.img" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-form-item>
                    <el-form-item label="商品名称">
                        <el-input v-model="edit_product.name"></el-input>
                    </el-form-item>
                    <el-form-item label="商品分类">
                        <el-select v-model="edit_product.type" placeholder="请选择">
                            <el-option
                                    v-for="item in productType"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value">
                            </el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="商品进价">
                        <el-input v-model="edit_product.in_price"><template slot="append">元</template></el-input>
                    </el-form-item>
                    <el-form-item label="建议售价">
                        <el-input v-model="edit_product.out_price"><template slot="append">元</template></el-input>
                    </el-form-item>
                    <el-form-item label="商品单位">
                        <el-input v-model="edit_product.unit"></el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button @click="dialogFormVisible_edit = false">取 消</el-button>
                    <el-button type="primary" @click="edit_product_enter(edit_product.index)">确 定</el-button>
                </div>
            </el-dialog>

            <br>
            <transition name="fade" v-for="item,index in product_all" :key="index">
                <el-card :body-style="{ padding: '0px' }" style="display: inline-block;padding: 8px;margin: 0 6px;" v-if="item.status == 0">
                        <img :src="'/show_img/'+item.img" class="image" style="width: 200px;height: 200px;">
                        <div style="padding: 0 14px;">
                            <p style="text-align: center;">{{ item.name }}</p>
                            <p style="font-size: 12px;margin: 0;">商品进价：<span style="float: right;">{{ item.in_price }}元/{{ item.unit }}</span></p>
                            <p style="font-size: 12px;margin: 0;">建议售价：<span style="float: right;">{{ item.out_price }}元/{{ item.unit }}</span></p>
                            <div class="bottom clearfix button">
                                <el-button-group>
                                    <el-button
                                            size="small"
                                            type="primary"
                                            @click="edit(index)">编辑</el-button>
                                    <el-button
                                            size="small"
                                            type="danger"
                                            @click="del(index)">删除</el-button>
                                </el-button-group>
                            </div>
                        </div>
                </el-card>
            </transition>

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
                loading:false,
                id:'',
                info:{

                },
                dialogFormVisible: false,
                dialogFormVisible_edit:false,
                productType:[],
                product: {
                    name:'',
                    type:'',
                    in_price:'',
                    out_price:'',
                    unit:'',
                    img:'',
                    status:'0'
                },
                edit_product: {
                    name:'',
                    in_price:'',
                    type:'',
                    out_price:'',
                    unit:'',
                    img:'',
                    status:'0'
                },
                product_all: [

                ],
                formLabelWidth: '120px',
                show:true
            }
        },
        methods : {
            handleAvatarSuccess_add(res, file) {
                this.product.img = file.response;
                this.imageUrl = URL.createObjectURL(file.raw);

            },
            handleAvatarSuccess_edit(res, file) {
                this.edit_product.img = file.response;
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
            submitForm(){
                this.loading = true
                let param = {
                    id:this.id,
                    name:this.info.name,
                    phone:this.info.phone,
                    address:this.info.address,
                    product_all:this.product_all,
                }
                if(this.id){
                    axios.post('/admin/dealer/edit',param)
                        .then(res=>{
                            this.loading = false
                        })
                        .catch(err=>{
                            this.loading = false
                        })
                }else{
                    axios.post('/admin/dealer/add',param)
                        .then(res=>{
                            this.loading = false
                        })
                        .catch(err=>{
                            this.loading = false
                        })
                }
            },
            add_product(){
                this.dialogFormVisible = false
                this.product_all.push({
                    name:this.product.name,
                    type:this.product.type,
                    in_price:this.product.in_price,
                    out_price:this.product.out_price,
                    unit:this.product.unit,
                    img:this.product.img,
                    status:0
                })
            },
            edit(index){
                this.edit_product = JSON.parse(JSON.stringify(this.product_all[index]))
                this.edit_product.index = index
                this.dialogFormVisible_edit = true
            },
            edit_product_enter(index){
                this.product_all[index] = this.edit_product
                this.dialogFormVisible_edit = false
            },
            del(index){
                this.product_all[index].status = 1
                console.log(index)
            },
            getInfo(){
                this.loading = true
                axios.post('/admin/dealer/get_info',{ id:this.id })
                    .then(res=>{
                        this.loading = false
                        this.info = res.data.info
                        this.product_all = res.data.products
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            },
            getType(){
                axios.post('/admin/goods/type/get_data')
                    .then(res=>{
                        this.loading = false
                        let temp = [];
                        res.data.result.forEach((value,index,array)=>{
                            var item = {}
                            item.value = value.id
                            item.label = value.name
                            temp.push(item)
                        });
                        this.productType = temp;
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            }
        },
        mounted(){
            this.id = this.$route.params.id
            if(this.id){
                this.getInfo()
            }
            this.getType()
        }
    }
</script>

<style scoped>
    .time {
        font-size: 13px;
        color: #999;
    }
    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }
    .button {
        float: right;
    }
    .image {
        /*width: 100%;*/
        display: block;
    }
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }
    .clearfix:after {
        clear: both
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active in below version 2.1.8 */ {
        opacity: 0
    }
</style>
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