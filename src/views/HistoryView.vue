<template>
   <!-- 標題 -->
   <the-heading heading="歷史故事管理系統"></the-heading>
   <!-- 新增彈窗按鈕 -->
   <Button @click="modal1 = true" class="add">新增 +</Button>
   <!-- 新增彈窗 -->
   <Modal
      v-model="modal1"
      title="新增歷史故事"
      width="700px"
      class="addnews-popup"
      :styles="{ top: '30px' }"
   >
      <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
         <FormItem label="故事編號">
            <Input v-model="addItem.id" placeholder="請輸入故事編號"></Input>
         </FormItem>
         <FormItem label="故事分類">
            <Select v-model="addItem.select" placeholder="請選擇">
               <Option value="經典事件">經典事件</Option>
               <Option value="期間限定">期間限定</Option>
            </Select>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80">
         <FormItem label="故事名稱">
            <Input v-model="addItem.title" placeholder="請輸入故事標題"></Input>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
         <FormItem label="危險度">
            <Select v-model="addItem.select" placeholder="請選擇">
               <Option value="低">低</Option>
               <Option value="中">中</Option>
               <Option value="高">高</Option>
            </Select>
         </FormItem>
         <FormItem label="特色">
            <Select v-model="addItem.select" placeholder="請選擇">
               <Option value="奇聞軼事">奇聞軼事</Option>
               <Option value="歷史事件">歷史事件</Option>
               <Option value="宗教事件">宗教事件</Option>
            </Select>
         </FormItem>
         <FormItem label="地區">
            <Select v-model="addItem.select" placeholder="請選擇">
               <Option value="歐洲">歐洲</Option>
               <Option value="北美洲">北美洲</Option>
               <Option value="南美洲">南美洲</Option>
               <Option value="非洲">非洲</Option>
               <Option value="亞洲">亞洲</Option>
               <Option value="大洋洲">大洋洲</Option>
            </Select>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80">
         <FormItem label="段落">
            <Select
               v-model="addItem.select"
               placeholder="請選擇"
               style="width: fit-content"
            >
               <Option value="一">一</Option>
               <Option value="二">二</Option>
               <Option value="三">三</Option>
               <Option value="四">四</Option>
               <Option value="五">五</Option>
            </Select>
         </FormItem>
         <FormItem label="故事圖片">
            <input type="file" multiple />
         </FormItem>
         <FormItem label="故事內容">
            <Input
               v-model="addItem.textarea"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
      </Form>
   </Modal>

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

      <template #stories_type="{ row }">
         <text>{{ row.stories_type }}</text>
      </template>

      <!-- 加入編輯、刪除彈窗 -->
      <template #edit_del>
         <!-- 編輯按鈕 -->
         <Button @click="modal3 = true" class="edit">編輯</Button>
         <!-- 編輯彈窗 -->
         <Modal
            v-model="modal3"
            title="編輯歷史故事"
            ok-text="確認修改"
            cancel-text="取消"
            width="700px"
            class="editnews-popup"
            :styles="{ top: '30px' }"
         >
            <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
               <FormItem label="故事編號">
                  <Input
                     v-model="addItem.id"
                     placeholder="請輸入故事編號"
                  ></Input>
               </FormItem>
               <FormItem label="故事分類">
                  <Select v-model="addItem.select" placeholder="請選擇">
                     <Option value="經典事件">經典事件</Option>
                     <Option value="期間限定">期間限定</Option>
                  </Select>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80">
               <FormItem label="故事名稱">
                  <Input
                     v-model="addItem.title"
                     placeholder="請輸入故事標題"
                  ></Input>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
               <FormItem label="危險度">
                  <Select v-model="addItem.select" placeholder="請選擇">
                     <Option value="低">低</Option>
                     <Option value="中">中</Option>
                     <Option value="高">高</Option>
                  </Select>
               </FormItem>
               <FormItem label="特色">
                  <Select v-model="addItem.select" placeholder="請選擇">
                     <Option value="奇聞軼事">奇聞軼事</Option>
                     <Option value="歷史事件">歷史事件</Option>
                     <Option value="宗教事件">宗教事件</Option>
                  </Select>
               </FormItem>
               <FormItem label="地區">
                  <Select v-model="addItem.select" placeholder="請選擇">
                     <Option value="歐洲">歐洲</Option>
                     <Option value="北美洲">北美洲</Option>
                     <Option value="南美洲">南美洲</Option>
                     <Option value="非洲">非洲</Option>
                     <Option value="亞洲">亞洲</Option>
                     <Option value="大洋洲">大洋洲</Option>
                  </Select>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80">
               <FormItem label="段落">
                  <Select
                     v-model="addItem.select"
                     placeholder="請選擇"
                     style="width: fit-content"
                  >
                     <Option value="一">一</Option>
                     <Option value="二">二</Option>
                     <Option value="三">三</Option>
                     <Option value="四">四</Option>
                     <Option value="五">五</Option>
                  </Select>
               </FormItem>
               <FormItem label="故事圖片">
                  <input type="file" multiple />
               </FormItem>
               <FormItem label="故事內容">
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
               title: "故事編號",
               width: "150px", //寬度
               key: "id",
               align: "center", //置中
               sortable: true, //是否排序
            },
            {
               title: "故事名稱",
               width: "200px",
               key: "title",
               align: "center",
               sortable: true,
            },
            {
               title: "行程分類",
               width: "150px",
               slot: "stories_type",
               align: "center",
               filters: [
                  //篩選分類
                  {
                     label: "經典行程",
                     value: 1,
                  },
                  {
                     label: "期間限定",
                     value: 2,
                  },
               ],
               filterMultiple: false,
               filterMethod(value, row) {
                  if (value === 1) {
                     return row.stories_type === "經典行程";
                  } else if (value === 2) {
                     return row.stories_type === "期間限定";
                  }
               },
            },
            {
               title: "危險度",
               key: "dangerLevels",
               align: "center",
               sortable: true,
            },
            {
               title: "特色",
               key: "features",
               align: "center",
               sortable: true,
            },
            {
               title: "地區",
               key: "region",
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
               id: "1001",
               title: "史前時代",
               stories_type: "經典行程",
               dangerLevels: "低",
               features: "宗教事件",
               region: "北美洲",
            },
            {
               id: "1002",
               title: "哥倫布發現新大陸",
               stories_type: "經典行程",
               dangerLevels: "中",
               features: "奇聞軼事",
               region: "歐洲",
            },
            {
               id: "2001",
               title: "鐵達尼號沈船事故",
               stories_type: "期間限定",
               dangerLevels: "高",
               features: "歷史事件",
               region: "歐洲",
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
