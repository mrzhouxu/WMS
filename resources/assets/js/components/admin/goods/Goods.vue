<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>商品管理</el-breadcrumb-item>
                <el-breadcrumb-item>商品列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>

        <div style="padding-bottom: 10px;">
            <!--<span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>-->
            <el-input placeholder="请输入内容" v-model="val" style="width: inherit;" >
                <el-select v-model="key" slot="prepend" placeholder="请选择" style="width: 120px;">
                    <el-option
                            v-for="item in options_key"
                            :key="item.id"
                            :label="item.label"
                            :value="item.value">
                    </el-option>
                </el-select>
            </el-input>
            <span style="margin: 0 0 0 10px;">商品类型：</span>
            <el-select v-model="selType" slot="prepend" placeholder="请选择" style="width: 120px;" clearable>
                <el-option
                        v-for="item in type"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                </el-option>
            </el-select>

            <el-button type="primary" icon="search" @click="submit">查询</el-button>
        </div>

        <el-card :body-style="{ padding: '0px' }" style="display: inline-block;padding: 8px;margin: 0 6px;position: relative;" v-for="item,index in tableData" :key="index" v-if="item.count > 0">
            <div class="edit">
                <!--<el-button-group>-->
                    <el-button type="text" style="color: #ffffff;font-size: 1em;width: 40%;" @click.native="edit(item)">编辑</el-button>
                    <el-button type="text" style="color: #ffffff;font-size: 1em;width: 40%;" @click.natice="del(item)">删除</el-button>
                <!--</el-button-group>-->
            </div>
            <img :src="'/show_img/'+item.img" class="image" style="width: 200px;height: 200px;">
            <div style="padding: 14px;">
                <span>{{ item.name }}</span>
                <!--<p style="padding: 0;margin: 0;"><span style="margin-right: 2em;font-size: 0.8em;">进货价格:</span><span style="font-size: 1.2em;color: red;">{{ item.in_price }}</span>元/{{ item.unit }}</p>-->
                <p style="padding: 0;margin: 0;"><span style="margin-right: 2em;font-size: 0.8em;">建议售价:</span><span style="font-size: 1.2em;color: red;">{{ item.out_price }}</span>元/{{ item.unit }}</p>
                <p style="padding: 0;margin: 0;"><span style="margin-right: 2em;font-size: 0.8em;">剩余库存:</span><span style="font-size: 1.2em;color: red;">{{ item.count }}</span> {{ item.unit }}</p>
                <p style="font-size: .8em;color: #7a7272;">{{ item.dealer_name }}</p>
                <div class="bottom clearfix">
                    <el-input-number size="small" v-model="item.num" :min="0" :max="item.count"></el-input-number>
                    <el-button type="text"  @click.native="add_car(item)">选购</el-button>
                </div>
            </div>
        </el-card>

        <div style="position: fixed;right: 20px;bottom: 0;z-index: 1;">
            <el-badge :value="carNum" :max="99" class="item">
                <el-button type="primary" @click.native="dialogTableVisible=true"><i class="ion-ios-cart"></i> 购物车</el-button>
            </el-badge>
            <!--<el-button type="danger" @click.native="clean()"><i class="ion-ios-cart"></i> 清空购物车</el-button>-->
        </div>

        <el-dialog title="购物车列表" :visible.sync="dialogTableVisible"  size="large">
            <el-table :data="carsData" :default-sort="{prop: 'phone'}" :height="500" stripe  border v-loading="carLoading">
                <el-table-column type="index" width="80"></el-table-column>
                <el-table-column
                        prop="name"
                        label="商品名称">
                    <!--<template  slot-scope="scope">{{ scope.row.name }}</template>-->
                </el-table-column>
                <el-table-column
                        label="数量">
                    <template  slot-scope="scope">{{ scope.row.num +" "+ scope.row.unit }}</template>
                </el-table-column>
                <el-table-column
                        label="类型">
                    <template  slot-scope="scope">{{   type_init(scope.row.type) }}</template>
                </el-table-column>
                <el-table-column
                        label="进价">
                    <template  slot-scope="scope">{{ scope.row.in_price+" 元 / "+scope.row.unit }}</template>
                </el-table-column>
                <el-table-column
                        label="售价">
                    <template  slot-scope="scope">{{ scope.row.out_price+" 元 / "+scope.row.unit }}</template>
                </el-table-column>
                <el-table-column
                        label="供销商名称">
                    <template  slot-scope="scope">{{ scope.row.dealer_name }}</template>
                </el-table-column>
                <el-table-column
                        prop="phone"
                        label="供销商电话">
                    <!--<template  slot-scope="scope">{{ scope.row.phone }}</template>-->
                </el-table-column>
                <el-table-column
                        label="所属品牌">
                    <template  slot-scope="scope">{{ scope.row.address }}</template>
                </el-table-column>

                <el-table-column
                        label="操作"
                        width="100">
                    <template slot-scope="scope">
                        <!--<el-button-group>-->
                            <!--<el-button
                                    size="small"
                                    type="primary"
                                    @click="dealer_send(scope)">已送达</el-button>-->
                            <el-button
                                    size="small"
                                    type="danger"
                                    @click="remv(scope)">移除</el-button>
                        <!--</el-button-group>-->
                    </template>
                </el-table-column>
            </el-table>
            <el-button-group style="float: right;margin: 20px 0;">
                <el-button
                        size="large"
                        type="danger"
                        @click.native="clean()"><i class="ion-ios-cart"></i> 清空购物车</el-button>
                <el-button
                        size="large"
                        type="primary"
                        @click.native="settlement()"><i class="ion-ios-cart"></i> 一键结算</el-button>
            </el-button-group>
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
                                v-for="item in type"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <!--<el-form-item label="商品进价">-->
                    <!--<el-input v-model="edit_product.in_price"><template slot="append">元</template></el-input>-->
                <!--</el-form-item>-->
                <el-form-item label="建议售价">
                    <el-input v-model="edit_product.out_price"><template slot="append">元</template></el-input>
                </el-form-item>
                <el-form-item label="商品单位">
                    <el-input v-model="edit_product.unit"></el-input>
                </el-form-item>
                <el-form-item label="剩余库存">
                    <el-input v-model="edit_product.count"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible_edit = false">取 消</el-button>
                <el-button type="primary" @click="edit_submit(edit_product)">确 定</el-button>
            </div>
        </el-dialog>


    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                dialogFormVisible_edit:false,
                header: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf"]').content,
                },
                loading:false,
                carLoading:false,
                carNum:0,
                tableData: [/*{
                    id:'1',
                    name:'好吃的汉堡',
                    in_price:'10',
                    out_price:'20',
                    unit:'箱',
                    dealer:'京东直营店',
                    img:'af462236149f3a30b4ed787bd7f2d727.png',
                },{
                    id:'2',
                    name:'好吃的汉堡',
                    in_price:'10',
                    out_price:'20',
                    unit:'箱',
                    dealer:'京东直营店',
                    img:'af462236149f3a30b4ed787bd7f2d727.png',
                },{
                    id:'3',
                    name:'好吃的汉堡',
                    in_price:'10',
                    out_price:'20',
                    unit:'箱',
                    dealer:'京东直营店',
                    img:'af462236149f3a30b4ed787bd7f2d727.png',
                },{
                    id:'4',
                    name:'好吃的汉堡',
                    in_price:'10',
                    out_price:'20',
                    unit:'箱',
                    dealer:'京东直营店',
                    img:'af462236149f3a30b4ed787bd7f2d727.png',
                }*/],
                key:'name',
                val:'',
                options_key: [{
                    label: '商品名称',
                    value:'name'
                }],
//                cars: [],
                carsData: [],
                dialogTableVisible: false,
                type:[],
                selType:'',
                edit_product:[],
            }
        },
        methods : {
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
            getData(){
                this.loading = true
                let param = {
                    key:this.key,
                    val:this.val,
                    selType:this.selType
                }
                axios.post('/admin/goods/lack/lack_data',param)
                    .then(res=>{
                        this.loading = false
                        this.tableData = res.data.result
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            },
            submit(){
                this.getData()
            },
            add_car(item){
//                console.log(item)
                if(item.num <= 0){
                    return
                }
                var local = localStorage.getItem("carGoods");
                if(local){
                    local = JSON.parse(local)
                    var carNum = JSON.parse(localStorage.getItem("carNumGoods"))+item.num
                    for(let i=0;i<local.length;i++){
                        if(item.id == local[i].id){
                            local[i].num += item.num
                            if(local[i].num>item.count){
                                return
                            }
                            localStorage.setItem("carGoods", JSON.stringify(local))
                            localStorage.setItem("carNumGoods", JSON.stringify(carNum))
                            this.carNum = carNum
                            this.carsData = JSON.parse(localStorage.getItem("carGoods"))
                            return
                        }
                    }
                    local.push(item)
                    localStorage.setItem("carGoods", JSON.stringify(local))
                    localStorage.setItem("carNumGoods", JSON.stringify(carNum))
                    this.carNum = carNum
                }else{
                    local = []
                    local.push(item)
                    var carNum = JSON.stringify(item.num)
                    localStorage.setItem("carGoods", JSON.stringify(local))
                    localStorage.setItem("carNumGoods",carNum )
                    this.carNum = carNum
                }
                this.carsData = JSON.parse(localStorage.getItem("carGoods"))
            },
            clean(){
                this.$confirm('此操作将清空购物车, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    localStorage.setItem("carNumGoods",'' )
                    localStorage.setItem("carGoods", '')
                    this.carNum = ''
                    this.carsData = ''
                    this.$message({
                        type: 'success',
                        message: '清空购物车成功!'
                    });
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消'
                    });
                });
            },
            type_init(val){
                for(let i=0;i<this.type.length;i++){
                    if(val == this.type[i].id){
                        return this.type[i].name
                    }
                }
            },
            getType(){
                axios.post('/admin/goods/type/get_data')
                    .then(res=>{
                        this.type = res.data.result
                    })
            },
            remv(item){
                var local = JSON.parse(localStorage.getItem("carGoods"))
                this.carNum -= item.row.num
                for(let i=0;i<local.length;i++){
                    if(local[i].id == item.row.id ){
                        local.splice(i,1)
                        break
                    }
                }
                localStorage.setItem("carGoods", JSON.stringify(local))
                localStorage.setItem("carNumGoods", this.carNum)
                this.carsData = local
            },
            dealer_send(item){
                this.carLoading = true
                axios.post('/admin/goods/purchase/dealer_send', item.row  )
                    .then(res=>{
                        if( res.data.status==0 ){
                            var local = JSON.parse(localStorage.getItem("carGoods"))
                            this.carNum -= item.row.num
                            for(let i=0;i<local.length;i++){
                                if(local[i].id == item.row.id ){
                                    local.splice(i,1)
                                    break
                                }
                            }
                            localStorage.setItem("carGoods", JSON.stringify(local))
                            localStorage.setItem("carNumGoods", this.carNum)
                            this.carsData = local
                        }
                        this.carLoading = false
                    })
                    .catch(err=>{
                        this.carLoading = false
                    })
            },
            settlement(){
                let money = 0;
                let local = JSON.parse(localStorage.getItem("carGoods"))
                for(let i=0;i<local.length;i++){
                    money+=(local[i].out_price*local[i].num)
                }
                this.$confirm('此操作将生成订单,请在支付完成后点击确定, 是否继续?', "需支付金额"+money+"元", {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.carLoading = true
                    axios.post('/admin/goods/goods/settlement',{'goods':local,'price':money})
                        .then(res=>{
                            this.carLoading = false
                            if(res.data.status == 0){
                                this.$message({
                                    type: 'success',
                                    message: '生成订单成功!'
                                });
                                localStorage.setItem("carNumGoods",'' )
                                localStorage.setItem("carGoods", '')
                                this.carNum = ''
                                this.carsData = ''
                            }else if(res.data.status == 1){
                                this.carLoading = false
                                this.$message({
                                    type: 'error',
                                    message: '生成订单失败!'
                                });
                            }
                        })
                        .catch(err=>{
                            this.carLoading = false
                        })
                    /*localStorage.setItem("carNumGoods",'' )
                    localStorage.setItem("carGoods", '')
                    this.carNum = ''
                    this.carsData = ''*/

                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消'
                    });
                });
            },
            edit(item){
              this.dialogFormVisible_edit = true
              this.edit_product = JSON.parse(JSON.stringify(item))
            },
            edit_submit(edit_product){
                axios.post('/admin/goods/goods/edit_product',{'edit_product':edit_product})
                    .then(res=>{
                        if(res.data.status == 0){
                            this.dialogFormVisible_edit = false
                            this.$message({
                                type: 'success',
                                message: '修改成功!'
                            });
                            this.getData()
                        }else if(res.data.status == 1){
                            this.$message({
                                type: 'error',
                                message: '失败!'
                            });
                        }
                    })
                    .catch(err=>{})
            },
            del(item){
                this.$confirm('此操作将永久删除该商品, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.loading = true
                    axios.post('/admin/goods/goods/del_product',{ 'del_product':item })
                        .then(res=>{
                            if(res.data.status == 0){
                                this.getData()
                                this.dialogFormVisible_edit = false
                                this.$message({
                                    type: 'success',
                                    message: '删除成功!'
                                });
                            }else if(res.data.status == 1){
                                this.$message({
                                    type: 'error',
                                    message: '失败!'
                                });
                            }
                        })
                        .catch(err=>{})
                })
            }
        },
        mounted(){
            this.getData()
            this.getType()

            if(localStorage.getItem("carNumGoods")){
                if(localStorage.getItem("carNumGoods")>99){
                    this.carNum = "99+"
                }else{
                    this.carNum = localStorage.getItem("carNumGoods")
                }

            }
            if(localStorage.getItem("carGoods")){
                this.carsData = JSON.parse(localStorage.getItem("carGoods"))
            }
        }
    }
</script>
<style>
    .time {
        font-size: 13px;
        color: #999;
    }

    .bottom {
        margin-top: 13px;
        line-height: 12px;
    }

    .button {
        padding: 0;
        float: right;
    }

    .image {
        width: 100%;
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

    .edit{
        background: rgba(0,0,0,.4);
        position: absolute;
        top: 0;left: 0;
        width: 100%;
        height: 40px;
        display: none;
        text-align: center;
    }
    .el-card:hover .edit{
        display: block;
    }
</style>