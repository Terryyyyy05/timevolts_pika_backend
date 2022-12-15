<template>
  <!-- 標題 -->
  <the-heading heading="時空管理局管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal v-model="modal1" title="新增問題" width="700px" class="addqa-popup" :styles="{ top: '30px' }">
    <Form :model="addqaItem" :label-width="80">
      <FormItem label="問題編號">
        <Input v-model="addqaItem.id" placeholder="請輸入問題編號"></Input>
      </FormItem>
      <FormItem label="問題分類">
        <Select v-model="addqaItem.qa_type" placeholder="請選擇">
          <Option value="常見問題">常見問題</Option>
          <Option value="行程預訂">行程預訂</Option>
        </Select>
      </FormItem>
      <FormItem label="問題標題">
        <Input v-model="addqaItem.title" placeholder="請輸入問題標題"></Input>
      </FormItem>
      <FormItem label="問題內容">
        <Input v-model="addqaItem.textarea" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"></Input>
      </FormItem>
    </Form>
  </Modal>

  <!-- 表格 -->
  <Table class="table" stripe border :columns="columns" :data="data" width="1200">
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row, index }">
      <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
        <template #open>
          <span>上架</span>
        </template>
        <template #close>
          <span>下架</span>
        </template>
      </Switch>
    </template>

    <template #qa_type="{ row, index }">
      <text>{{ row.qa_type }}</text>
    </template>

    <!-- 加入編輯彈窗 -->
    <template #edit="{ row, index }">
      <!-- 編輯按鈕 -->
      <Button @click="modal3 = true" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal v-model="modal3" title="編輯最新消息" ok-text="確認修改" cancel-text="取消" width="700px" class="editnews-popup"
        :styles="{ top: '30px' }">

        <Form :model="addqaItem" :label-width="80">
          <FormItem label="問題編號">
            <Input v-model="addqaItem.id" placeholder="請輸入問題編號"></Input>
          </FormItem>
          <FormItem label="問題分類">
            <Select v-model="addqaItem.qa_type" placeholder="請選擇">
              <Option value="常見問題">常見問題</Option>
              <Option value="行程預訂">行程預訂</Option>
            </Select>
          </FormItem>
          <FormItem label="問題標題">
            <Input v-model="addqaItem.title" placeholder="請輸入問題標題"></Input>
          </FormItem>
          <FormItem label="問題內容">
            <Input v-model="addqaItem.textarea" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"></Input>
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
          title: '問題編號',
          width: '200px',  //寬度
          key: 'id',
          align: 'center',  //置中
          sortable: true,   //是否排序
        },
        {
          title: '問題分類',
          width: '200px',
          key:'qa_type',
          slot: 'qa_type',
          align: 'center',
        },
        {
          title: '問題標題',
          key: 'title',
          align: 'center',
        },
        {
          title: '問題狀態',
          key: 'status',
          align: 'center',
          width: '100px',
          slot: 'on_off',  //加入開關鈕欄位需加slot
        },
        {
          title: '編輯',
          width: '100px',
          key: 'edit',
          align: 'center',
          slot: 'edit'  //加入編輯刪除欄位需加slot
        },
      ],
      data: [     ///表格內容資料
        {
          id: '1001',
          qa_type: '常見問題',
          title: '穿梭於史前時代',
        },
        {
          id: '1002',
          qa_type: '行程預訂',
          title: '埃及五千年的黃金時代',
        },
      ],
      addqaItem: {   //新增彈窗內容資料
        id: '',
        qa_type: '',
        title: '',
        textarea: ''
      },
      editqaItem: {
        id: '',
        qa_type: '',
        title: '',
        textarea: ''
      }
    }
  },
  methods: {
  }
}

</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';

.table {
  margin: 30px auto;
}

.add {
  margin: 20px 0 0 0;
  width: 80px;
  background-color: $color;
  color: #ffffff;
  border: 1px solid $color;
}

.edit {
  color: $color;
  border: 1px solid $color;
}
</style>