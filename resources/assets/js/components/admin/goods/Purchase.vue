<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>商品管理</el-breadcrumb-item>
                <el-breadcrumb-item>我要进货</el-breadcrumb-item>
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

        <el-card :body-style="{ padding: '0px' }" style="display: inline-block;padding: 8px;margin: 0 6px;" v-for="item,index in tableData" :key="index">
            <img :src="'/show_img/'+item.img" class="image" style="width: 200px;height: 200px;">
            <div style="padding: 14px;">
                <span>{{ item.name }}</span>
                <p style="padding: 0;margin: 0;"><span style="margin-right: 2em;font-size: 0.8em;">进货价格:</span><span style="font-size: 1.2em;color: red;">{{ item.in_price }}</span>元/{{ item.unit }}</p>
                <p style="padding: 0;margin: 0;"><span style="margin-right: 2em;font-size: 0.8em;">建议售价:</span><span style="font-size: 1.2em;color: red;">{{ item.out_price }}</span>元/{{ item.unit }}</p>
                <p style="font-size: .8em;color: #7a7272;">{{ item.dealer_name }}</p>
                <div class="bottom clearfix">
                    <el-input-number size="small" v-model="item.num"></el-input-number>
                    <el-button type="text"  @click.native="add_car(item)">选购</el-button>
                </div>
            </div>
        </el-card>

       <!-- <el-table
                :data="cars"
                stripe
                style="width: 100%">
            <el-table-column
                    prop="date"
                    label="日期"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="name"
                    label="姓名"
                    width="180">
            </el-table-column>
            <el-table-column
                    prop="address"
                    label="地址">
            </el-table-column>
        </el-table>-->

        <div style="position: fixed;right: 20px;bottom: 0;z-index: 1;">
            <el-badge :value="carNum" :max="99" class="item">
                <el-button type="primary" @click.native="dialogTableVisible=true"><i class="ion-ios-cart"></i> 购物车</el-button>
            </el-badge>
            <el-button type="primary" @click.native="clean()"><i class="ion-ios-cart"></i> 清空购物车</el-button>
        </div>

        <el-dialog title="购物车列表" :visible.sync="dialogTableVisible"  size="large" >
            <el-table :data="carsData" :default-sort="{prop: 'phone'}" :height="500" stripe  border >
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
                        width="150">
                    <template slot-scope="scope">
                        <el-button-group>
                            <el-button
                                    size="small"
                                    type="primary"
                                    @click="">已送达</el-button>
                            <el-button
                                    size="small"
                                    type="danger"
                                    @click="remv(scope)">移除</el-button>
                        </el-button-group>
                    </template>
                </el-table-column>

            </el-table>
        </el-dialog>


    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                loading:false,
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
                selType:''
            }
        },
        methods : {
            getData(){
                this.loading = true
                let param = {
                    key:this.key,
                    val:this.val,
                    selType:this.selType
                }
                axios.post('/admin/goods/purchase/get_data',param)
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
                var local = localStorage.getItem("car");
                if(local){
                    local = JSON.parse(local)
                    var carNum = JSON.parse(localStorage.getItem("carNum"))+item.num
                    local.push(item)
                    localStorage.setItem("car", JSON.stringify(local))
                    localStorage.setItem("carNum", JSON.stringify(carNum))
                    this.carNum = carNum
                }else{
                    local = []
                    local.push(item)
                    var carNum = JSON.stringify(item.num)
                    localStorage.setItem("car", JSON.stringify(local))
                    localStorage.setItem("carNum",carNum )
                    this.carNum = carNum
                }
                this.carsData = JSON.parse(localStorage.getItem("car"))
            },
            clean(){
                this.$confirm('此操作将清空购物车, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    localStorage.setItem("carNum",'' )
                    localStorage.setItem("car", '')
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
//                console.log(val)
//                console.log(this.type.length)
                for(let i=0;i<this.type.length;i++){
//                    console.log(this.type)

                    if(val == this.type[i].id){
//                        console.log(`${this.type[i].name}   ${this.type[i].id}   ${val}`)
                        return this.type[i].name
                    }
                }

//                return "饮料"
            },
            getType(){
                axios.post('/admin/goods/type/get_data')
                    .then(res=>{
                        this.type = res.data.result
                    })
            },
            remv(index){
                var local = JSON.parse(localStorage.getItem("car"))
//                console.log(`${local[index.$index].num}`)
                this.carNum -= local[index.$index].num
                local.splice(index.$index,1)
                localStorage.setItem("car", JSON.stringify(local))
                localStorage.setItem("carNum", this.carNum)
                this.carsData = local
            }
        },
        mounted(){
            this.getData()
            this.getType()
            if(localStorage.getItem("carNum")){
                if(localStorage.getItem("carNum")>99){
                    this.carNum = "99+"
                }else{
                    this.carNum = localStorage.getItem("carNum")
                }

            }
            if(localStorage.getItem("car")){
                this.carsData = JSON.parse(localStorage.getItem("car"))
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
</style>