<template>
    <div v-loading="loading" element-loading-text="拼命加载中~~~">
        <div class="gm-breadcrumb">
            <span class="el-breadcrumb__item__inner"><i class="ion-ios-home gm-home"></i>当前位置：</span>
            <el-breadcrumb separator="/">
                <el-breadcrumb-item>管理系统</el-breadcrumb-item>
                <el-breadcrumb-item>分类列表</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div style="padding-bottom: 10px;">
            <!--<span style="font-size: 14px;margin-right: 6px;">选择日期 : </span>-->

            <el-button type="primary" @click.native="dialogFormVisible=true"><i class="ion-plus"></i> 添加商品分类</el-button>

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
            <el-table-column
                    label="分类名称">
                <template  slot-scope="scope">{{ scope.row.name }}</template>
            </el-table-column>
            <el-table-column
                    label="操作">
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


        </el-table>

        <el-dialog title="添加分类名称" :visible.sync="dialogFormVisible">
            <el-form>
                <el-form-item label="分类名称" label-width="100px">
                    <el-input v-model="typeName" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">取 消</el-button>
                <el-button type="primary" @click="add()">确 定</el-button>
            </div>
        </el-dialog>

        <el-dialog title="编辑分类名称" :visible.sync="dialogFormVisible_edit"  v-loading="typeLoading">
            <el-form  v-model="edit_info">
                <el-form-item label="分类名称" label-width="100px">
                    <el-input v-model="edit_info.name" auto-complete="off"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible_edit = false">取 消</el-button>
                <el-button type="primary" @click="edit_submit(edit_info.id)">确 定</el-button>
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
                loading:false,
                dialogFormVisible:false,
                dialogFormVisible_edit:false,
                edit_id:0,
                edit_info:[{
                    id: 0,
                    name:''
                }],
                tableData: [],
                typeName:'',
                key:'name',
                val:'',
                options_key: [{
                    label: '分类名称',
                    value:'name'
                }],
                typeLoading:false
            }
        },
        methods : {
            getData(){
                this.loading = true
                let param = {
                    key:this.key,
                    val:this.val
                }
                axios.post('/admin/goods/type/get_data',param)
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
                this.typeLoading = true
                this.edit_info = ''
                this.dialogFormVisible_edit = true
                let param = {
                    id:id
                }
                axios.post('/admin/goods/type/_id_get_data',param)
                    .then(res=>{
                        this.typeLoading = false
                        this.edit_info = res.data.result
                    })
                    .catch(err=>{
                        this.typeLoading = false
                    })

            },
            edit_submit(id){
                this.typeLoading = true
                let param = {
                    id:id,
                    name:this.edit_info.name
                }
                axios.post('/admin/goods/type/edit_type',this.edit_info)
                    .then(res=>{
                        this.typeLoading = false
                        this.loading = false
                        this.dialogFormVisible_edit = false
                        this.getData()
                    })
                    .catch(err=>{
                        this.typeLoading = false
                        this.loading = false
                    })
            },
            del(id){
                this.$confirm('此操作将永久删除该供销商, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    this.loading = true
                    axios.post('/admin/goods/type/del_type',{id:id})
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
            },
            add(){
                this.dialogFormVisible = false
                this.loading = true
                let param = {
                    typeName:this.typeName
                }
                axios.post('/admin/goods/type/add_type',param)
                    .then(res=>{
                        this.loading = false
                        if(res.data.status == 0){
                            this.$message({
                                type: 'success',
                                message: '添加成功!'
                            });
                            this.loading = true
                            this.getData()
                        }
                    })
                    .catch(err=>{
                        this.loading = false
                    })
            }
        },
        mounted(){
            this.getData()
        }
    }
</script>
