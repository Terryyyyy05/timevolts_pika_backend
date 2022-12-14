<template>
  <!-- 編輯彈窗按鈕 -->
  <!-- <Button @click="modal1 = true" class="edit">新增 +</Button> -->
  <!-- 編輯彈窗 -->
  <!-- <Modal v-model="modal1" title="新增最新消息" width="700px" class="editnews-popup" :styles="{top: '30px'}"> -->
    <Button @click="modal3 = true">編輯</Button>
        <Modal
            v-model="modal3"
            title="編輯最新消息"
            ok-text="確認修改"
            cancel-text="取消"
            width="700px" class="editnews-popup" :styles="{top: '30px'}"
            >

      <Form :model="editItem" :label-width="80" :rules="ruleInline" inline >
        <FormItem label="消息編號">
          <text>{{editItem.id}}</text>
        </FormItem>
        <FormItem label="消息分類">
          <Select v-model="editItem.select" placeholder="請選擇">
            <Option value="歷史故事">歷史故事</Option>
            <Option value="行程預訂">行程預訂</Option>
            <Option value="購物商城">購物商城</Option>
            <Option value="其他消息">其他消息</Option>
          </Select>
        </FormItem>
      </Form>
      <Form :model="editItem" :label-width="80">
        <FormItem label="消息標題">
          <Input v-model="editItem.title" placeholder="請輸入消息標題"></Input>
        </FormItem>
        <FormItem label="日期">
          <DatePicker type="date" placeholder="請選擇日期" v-model="editItem.date"></DatePicker>
        </FormItem>
        <FormItem label="消息圖片">
          <input type="file" multiple>
        </FormItem>
        <FormItem label="消息內容">
          <Input v-model="editItem.textarea" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"></Input>
        </FormItem>
      </Form>
    </Modal>
</template>
<script>
  export default {
      data () {
          return {
              modal3: false,
              editItem: {
                  id: 'addItem.id',
                  select: 'addItem.select',
                  date: 'addItem.date',
                  textarea: ''
              }
          }
      }
  }
</script>

<style lang="scss" scoped>
@import '@/assets/css/app.scss';

.table{
  width: 1200px;
  margin: 30px auto;
}

</style>