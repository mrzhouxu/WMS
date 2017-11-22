<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>经销商管理</el-breadcrumb-item>
                <el-breadcrumb-item>经销商列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div style="padding-bottom: 10px;">
            <!--<span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>-->
            <router-link to="/dealer/edit">
                <el-button type="primary"><i class="ion-plus"></i> 添加经销商</el-button>
            </router-link>
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
            <el-button type="primary" icon="search" @click="submit">查询</el-button>
        </div>
        <el-table
                :data="tableData"
                border
                stripe
                style="width: 100%">



            <el-table-column
                    type="index"
                    width="100">
            </el-table-column>
            <!--<el-table-column-->
            <!--label="日期"-->
            <!--width="180">-->
            <!--<template  slot-scope="scope">{{ scope.row.create_time | date }}</template>-->
            <!--</el-table-column>-->
            <el-table-column
                    label="姓名">
                <template  slot-scope="scope">{{ scope.row.name }}</template>
            </el-table-column>
            <el-table-column
                    label="联系方式">
                <template  slot-scope="scope">{{ scope.row.phone }}</template>
            </el-table-column>
            <el-table-column
                    label="所属公司">
                <template  slot-scope="scope">{{ scope.row.address }}</template>
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="220">
                <template slot-scope="scope">
                    <el-button-group>
                        <el-button
                                size="small"
                                type="primary"
                                @click="edit(scope.row.id)">编辑</el-button>
                        <el-button
                                size="small"
                                type="danger"
                                @click="del(scope.row.id)">删除</el-button>
                    </el-button-group>
                </template>
            </el-table-column>

            <el-table-column type="expand">
                <template slot-scope="scope">
                    <el-form label-position="left" inline class="demo-table-expand">
                        <div style="position: relative;width: 160px;height: 200px;display: inline-block;margin-right: 20px;" v-for="item,index in scope.row.products" :key="index">
                            <img :src="'/show_img/'+item[0]" alt="" style="width: 100%;height:100%;position: absolute;top: 0;left: 0;">
                            <div style="width: 100%;height:100%;position: absolute;top: 0;left: 0;background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAABQCAMAAACpg44GAAAAbFBMVEUiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiIiK2HsfSAAAAJHRSTlPMxr63q6OahzclHRULBgHCsZOOf3p1cGtmYVxXUk1IQz4wLBAszz8hAAAAhklEQVRo3u3OxY0DAAADsBxDmZn337FTVPIjnsAZ4/zgCOcHhzg/+MBlgPOD/zg/+Ifzg3dcbrj84vzgFZcLLmdcTrgccTngssdlh8sWlw0ua1xWuCxxWeDyg/ODc1xmuHzj/OAXzg9+4vzgFJcPnB98x/nBCS5vOD9YVVVVVVVVVVVVr/IEUdzLcLhtP2AAAAAASUVORK5CYII=) repeat-x bottom">
                                <div style="position: absolute;bottom: 6px;color: #fff;width: 100%;">
                                    <div style="font-size: 16px;line-height: 22px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;margin: 0 10px;text-align:center;">{{ item[1] }}</div>
                                </div>
                            </div>
                        </div>
                    </el-form>
                </template>
            </el-table-column>

        </el-table>

    </div>
</template>

<script>
    export default{
        components : {

        },
        data(){
            return {
                loading:false,
                tableData: [],
                key:'0',
                val:'',
                options_key: [{
                    label: '全部',
                    value:'0'
                },{
                    label: '姓名',
                    value:'name'
                },{
                    label: '联系方式',
                    value:'phone'
                },{
                    label: '所属公司',
                    value:'address'
                }
                ],
            }
        },
        methods : {
            getData(){
                this.loading = true
                let param = {
                    key:this.key,
                    val:this.val
                }
                axios.post('/admin/dealer/get_data',param)
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
            edit(id){
                this.$router.push({path:"/dealer/edit/"+id });
            },
            del(id){
                this.$confirm('此操作将永久删除该供销商, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.loading = true
                    axios.post('/admin/dealer/del',{id:id})
                        .then(res=>{
                            this.loading = false
                            if(res.data.status == 0){
                                this.$message({
                                    type: 'success',
                                    message: '删除成功!'
                                });
                                this.loading = true
                                this.getData()
                            }
                        })
                        .catch()
                }).catch(() => {
                    this.$message({
                        type: 'info',
                        message: '已取消删除'
                    });
                });
            }
        },
        mounted(){
            this.getData()
        }
    }
</script>
