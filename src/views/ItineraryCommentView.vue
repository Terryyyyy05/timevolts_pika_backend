<template>
   <!-- 標題 -->
   <the-heading heading="行程評論管理系統"></the-heading>

   <!-- 表格 -->
   <Table
      class="table"
      stripe
      border
      :columns="columns"
      :data="data"
      width="1200"
   >
      <!-- 加入開關按鈕 -->
      <template #on_off>
         <Switch size="large" true-color="#fab042" false-color="#e6e6e6">
            <template #open>
               <span>上架</span>
            </template>
            <template #close>
               <span>下架</span>
            </template>
         </Switch>
      </template>

      <template #comment_type="{ row }">
         <text>{{ row.comment_type }}</text>
      </template>

      <!-- 加入編輯、刪除彈窗 -->
      <template #edit_del>
         <!-- 編輯按鈕 -->
         <Button @click="modal3 = true" class="edit">編輯</Button>
         <!-- 編輯彈窗 -->
         <Modal
            v-model="modal3"
            title="編輯評論"
            ok-text="確認修改"
            cancel-text="取消"
            width="700px"
            class="editnews-popup"
            :styles="{ top: '30px' }"
         >
            <Form
               :model="editItem"
               :label-width="80"
               :rules="ruleInline"
               inline
            >
               <FormItem label="會員編號" :model="editItem">
                  <text>{{ data[0].id }}</text>
               </FormItem>
            </Form>
            <Form :model="editItem" :label-width="80">
               <FormItem label="會員姓名">
                  <Input
                     v-model="editItem.title"
                     placeholder="請輸入消息標題"
                  ></Input>
               </FormItem>
               <FormItem label="評論日期">
                  <DatePicker
                     type="date"
                     placeholder="請選擇日期"
                     v-model="editItem.date"
                  ></DatePicker>
               </FormItem>
               <FormItem label="評論星數">
                  <Input
                     v-model="editItem.title"
                  ></Input>
               </FormItem>
               <FormItem label="評論內容">
                  <Input
                     v-model="addItem.textarea"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
            </Form>
         </Modal>

         <!-- 刪除按鈕 -->
         <Button class="delete" @click="remove(data.id)">刪除</Button>
      </template>
   </Table>
</template>

<script>
export default {
   data() {
      return {
         modal1: false, //新增彈窗預設關閉
         modal3: false, //編輯彈窗預設關閉
         columns: [
            ///表單表頭
            {
               title: "會員編號",
               width: "150px", //寬度
               key: "id",
               align: "center", //置中
               sortable: true, //是否排序
            },
            {
               title: "會員姓名",
               width: "150px", //寬度
               key: "name",
               align: "center", //置中
               sortable: true, //是否排序
            },
            {
               title: "故事名稱",
               key: "title",
               align: "center", //置中
               sortable: true, //是否排序
            },
            {
               title: "評論日期",
               width: "150px",
               key: "date",
               align: "center",
               sortable: true,
            },
            {
               title: "評論星數",
               width: "150px",
               key: "star",
               align: "center",
               sortable: true,
            },
            {
               title: "狀態",
               key: "status",
               align: "center",
               width: "100px",
               slot: "on_off", //加入開關鈕欄位需加slot
            },
            {
               title: "編輯/刪除",
               width: "200px",
               key: "edit",
               align: "center",
               slot: "edit_del", //加入編輯刪除欄位需加slot
            },
         ],
         data: [
            ///表格內容資料
            {
               id: "0001",
               name: "皮卡丘",
               title: "鐵達尼號沈船事故",
               date: "2022-12-16",
               star: "1",
            },
            {
               id: "0002",
               name: "傑尼龜",
               title: "馬雅文明",
               date: "2022-12-17",
               star: "4",
            },
            {
               id: "0003",
               name: "噴火龍",
               title: "十字軍東征",
               date: "2022-12-18",
               star: "5",
            },
         ],
         addItem: {
            //新增彈窗內容資料
            id: "",
            title: "",
            select: "",
            date: "",
            textarea: "",
         },
         editItem: {
            id: "addItem.id()",
            title: "",
            select: "",
            date: "",
            textarea: "",
         },
      };
   },
   methods: {
      remove() {
         this.$Modal.confirm({
            content: "<p>確認刪除嗎?</p>",
            onOk: () => {
               this.$Message.info("確認刪除");
               this.data.splice("id", 1);
            },
            onCancel: () => {
               this.$Message.info("取消");
            },
         });
      },
   },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
