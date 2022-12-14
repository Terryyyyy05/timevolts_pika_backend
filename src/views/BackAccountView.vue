<template>
  <the-heading heading="後台帳號管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="admin">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal v-model="modal1" title="新增管理員" width="500px" class="addadmin-popup" :styles="{top: '30px'}">
      <Form :model="adminItem" :label-width="100">
        <FormItem label="員工編號">
          <Input v-model="adminItem.id" placeholder="請輸入編號"></Input>
        </FormItem>
        <FormItem label="管理員姓名">
          <Input v-model="adminItem.name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號">
          <Input v-model="adminItem.account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼">
          <Input v-model="adminItem.password" placeholder="請輸入密碼"></Input>
        </FormItem>
        <FormItem label="管理員權限">
          <Select v-model="adminItem.permission" placeholder="請選擇" style="width:100px">
            <Option value="一般">一般</Option>
            <Option value="停權">停權</Option>
          </Select>
        </FormItem>
        <FormItem label="在職狀態">
          <Select v-model="adminItem.status" placeholder="請選擇" style="width:100px">
            <Option value="在職">在職</Option>
            <Option value="離職">離職</Option>
          </Select>
        </FormItem>
      </Form>
  </Modal>

  <!-- 表格 -->
  <Table class="table" stripe border :columns="columns" :data="data" width="1200">
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row,index }">   
      <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
                <template #open>
                  <span>一般</span>
                </template>
                <template #close>
                  <span>停權</span>
                </template>
            </Switch>
    </template>

    <template #admin_status="{ row,index }">   
      <text>{{ row.admin_status }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_admin="{ row,index }">
      <!-- 編輯按鈕 -->
      <Button @click="modal3 = true" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal v-model="modal3" title="編輯會員資料" ok-text="確認修改" cancel-text="取消" width="500px" class="editadmin-popup"
        :styles="{top: '30px'}">
      
        <Form :model="adminItem" :label-width="100">
        <FormItem label="員工編號">
          <Input v-model="adminItem.id" placeholder="請輸入編號"></Input>
        </FormItem>
        <FormItem label="管理員姓名">
          <Input v-model="adminItem.name" placeholder="請輸入姓名"></Input>
        </FormItem>
        <FormItem label="管理員帳號">
          <Input v-model="adminItem.account" placeholder="請輸入帳號"></Input>
        </FormItem>
        <FormItem label="管理員密碼">
          <Input v-model="adminItem.password" placeholder="請輸入密碼"></Input>
        </FormItem>
        <FormItem label="管理員權限">
          <Select v-model="adminItem.permission" placeholder="請選擇" style="width:100px">
            <Option value="一般">一般</Option>
            <Option value="停權">停權</Option>
          </Select>
        </FormItem>
        <FormItem label="在職狀態">
          <Select v-model="adminItem.status" placeholder="請選擇" style="width:100px">
            <Option value="在職">在職</Option>
            <Option value="離職">離職</Option>
          </Select>
        </FormItem>
      </Form>
      </Modal>
    </template>
  </Table>
</template>

<script>
export default {
  data() {
    return {
      modal1: false,  //新增彈窗預設關閉
      modal3: false,  //編輯彈窗預設關閉
      columns: [  ///表單表頭
        {
          title: '管理員編號',
          width: '250px',
          key: 'id',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '管理員帳號',
          width: '',
          key: 'account',
          align: 'center',
          sortable: true
        },
        {
          title: '管理員姓名',
          width: '150px',
          key: 'name',
          align: 'center',
        },
        {
          title: '管理員權限',
          width: '150px',
          key: 'permission',
          align: 'center',
          slot:'on_off',
        },
        {
          title: '在職狀態',
          width: '150px',
          key: 'status',
          align: 'center',
          slot:'admin_status'
        },
        {
          title: '編輯',
          width: '150px',
          key: 'edit',
          align: 'center',
          slot:'edit_admin'
        },
      ],
      data: [     ///表格內容資料
        {
          id: '1000001',
          name: '張咚咚',
          account: '123123',
          password:'sdfsdfsdfsdf',
          permission:'',
          admin_status:'在職',
        },
        {
          id: '1000002',
          name: '張西西',
          account: '123123',
          password:'sdfsdfsdfsdf',
          permission:'',
          admin_status:'在職',
        },
        {
          id: '1000003',
          name: '張喃喃',
          account: '123123',
          password:'sdfsdfsdfsdf',
          permission:'',
          admin_status:'在職',
        },
        {
          id: '1000004',
          name: '張北北',
          account: '123123',
          password:'sdfsdfsdfsdf',
          permission:'',
          admin_status:'在職',
        },
       
      ],
      adminItem: {   //新增彈窗內容資料
        id: '',
        name: '',
        account: '',
        password: '',
        permission: '',
        status: '',
      },
      
    }
  },
}

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';

.table {
  margin: 30px auto;
}
.edit {
  color: $color;
  border: 1px solid $color;
  margin: auto;
}

.admin {
  margin: 20px 0 0 0;
  width: 80px;
  background-color: $color;
  color: #ffffff;
  border: 1px solid $color;
}


</style>