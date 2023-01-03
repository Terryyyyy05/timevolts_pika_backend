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
      ok-text="確認新增"
      cancel-text="取消新增"
      @on-ok="clickOk"
   >
      <Form
         :model="addItem"
         :label-width="80"
         :rules="ruleValidate1"
         method="post"
         enctype="multipart/form-data"
         ref="addForm1"
      >
         <FormItem label="故事名稱" prop="story_name">
            <Input
               v-model="addItem.story_name"
               placeholder="請輸入故事標題"
            ></Input>
         </FormItem>
         <FormItem label="故事分類" prop="story_classification">
            <Select v-model="addItem.story_classification" placeholder="請選擇">
               <Option value="經典行程">經典行程</Option>
               <Option value="期間限定">期間限定</Option>
            </Select>
         </FormItem>

         <FormItem label="故事年代" prop="story_age">
            <Input
               v-model="addItem.story_age"
               placeholder="請輸入故事年代"
               type="number"
            ></Input>
         </FormItem>
         <FormItem label="穿越日期" prop="itinerary_number_of_years">
            <DatePicker
               v-model="addItem.itinerary_number_of_years"
               placeholder="請輸入確切穿越日期"
               type="date"
            ></DatePicker>
         </FormItem>

         <FormItem label="危險度" prop="story_risk">
            <Select v-model="addItem.story_risk" placeholder="請選擇危險度">
               <Option value="低">低</Option>
               <Option value="中">中</Option>
               <Option value="高">高</Option>
            </Select>
         </FormItem>
         <FormItem label="特色" prop="story_specialty">
            <Select v-model="addItem.story_specialty" placeholder="請選擇特色">
               <Option value="奇聞軼事">奇聞軼事</Option>
               <Option value="歷史事件">歷史事件</Option>
               <Option value="宗教事件">宗教事件</Option>
            </Select>
         </FormItem>
         <FormItem label="地區" prop="story_spot">
            <Select v-model="addItem.story_spot" placeholder="請選擇地區">
               <Option value="歐洲">歐洲</Option>
               <Option value="北美洲">北美洲</Option>
               <Option value="南美洲">南美洲</Option>
               <Option value="非洲">非洲</Option>
               <Option value="亞洲">亞洲</Option>
               <Option value="大洋洲">大洋洲</Option>
            </Select>
         </FormItem>
         <FormItem label="故事簡介" prop="story_intro">
            <Input
               v-model="addItem.story_intro"
               type="textarea"
               style="width: 100%"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="故事大圖" prop="story_cover">
            <input
               id="story_cover_id"
               name="story_cover_id"
               type="file"
               multiple
            />
         </FormItem>
      </Form>
   </Modal>

   <Modal
      v-model="modal2"
      title="新增歷史故事段落"
      width="700px"
      class="addnews-popup"
      :styles="{ top: '30px' }"
      ok-text="確認新增"
      cancel-text="取消新增"
      @on-ok="clickOk2"
      @on-cancel="cancelAdd"
   >
      <Form
         :model="addItem"
         :label-width="80"
         :rules="ruleValidate2"
         method="post"
         enctype="multipart/form-data"
         ref="addForm2"
      >
         <FormItem label="段落一" style="font-weight: 700"></FormItem>
         <FormItem label="故事圖片" prop="story_img">
            <input
               id="story_img01_id"
               name="story_img01_id"
               type="file"
               multiple
            />
         </FormItem>
         <FormItem label="標題" prop="story_title_01">
            <input v-model="addItem.story_title_01" placeholder="請輸入標題" />
         </FormItem>
         <FormItem label="故事內容" prop="story_content_01">
            <Input
               v-model="addItem.story_content_01"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落二" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片" prop="story_img">
            <input
               id="story_img02_id"
               name="story_img02_id"
               type="file"
               multiple
            />
         </FormItem>
         <FormItem label="標題" prop="story_title_02">
            <input v-model="addItem.story_title_02" placeholder="請輸入標題" />
         </FormItem>
         <FormItem label="故事內容" prop="story_content_02">
            <Input
               v-model="addItem.story_content_02"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落三" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片" prop="story_img">
            <input
               id="story_img03_id"
               name="story_img03_id"
               type="file"
               multiple
            />
         </FormItem>
         <FormItem label="標題" prop="story_title_03">
            <input v-model="addItem.story_title_03" placeholder="請輸入標題" />
         </FormItem>
         <FormItem label="故事內容" prop="story_content_03">
            <Input
               v-model="addItem.story_content_03"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落四" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片" prop="story_img">
            <input
               id="story_img04_id"
               name="story_img04_id"
               type="file"
               multiple
            />
         </FormItem>
         <FormItem label="標題" prop="story_title_04">
            <input v-model="addItem.story_title_04" placeholder="請輸入標題" />
         </FormItem>
         <FormItem label="故事內容" prop="story_content_04">
            <Input
               v-model="addItem.story_content_04"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落五" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片" prop="story_img">
            <input
               id="story_img05_id"
               name="story_img05_id"
               type="file"
               multiple
            />
         </FormItem>
         <FormItem label="標題" prop="story_title_05">
            <input v-model="addItem.story_title_05" placeholder="請輸入標題" />
         </FormItem>
         <FormItem label="故事內容" prop="story_content_05">
            <Input
               v-model="addItem.story_content_05"
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
      :data="dataList"
      width="1000px"
   >
      <!-- 加入開關按鈕 -->
      <template #on_off="{ row }">
         <Switch
            size="large"
            true-color="#fab042"
            false-color="#e6e6e6"
            v-model="row.story_status"
            :true-value="1+''"
            :false-value="0+''"
            @on-change="onChange(row)"
         >
            <template #open>
               <span>上架</span>
            </template>
            <template #close>
               <span>下架</span>
            </template>
         </Switch>
      </template>

      <template #story_classification="{ row }">
         <text>{{ row.story_classification }}</text>
      </template>

      <!-- 加入編輯、刪除彈窗 -->
      <template #edit_del="{ index, row }">
         <!-- 編輯按鈕 -->
         <Button @click="clickEditBtn(index, row)" class="edit">編輯</Button>
         <!-- 編輯彈窗 -->
         <Modal
            v-model="modal3[index]"
            :id="row.story_name"
            title="編輯歷史故事"
            ok-text="確認修改"
            cancel-text="取消"
            width="700px"
            class="editnews-popup"
            :styles="{ top: '30px' }"
            @on-ok="replaceItem(row.story_name)"
            @on-cancel="cancelEdit"
         >
            <Form
               :model="addItem"
               :label-width="80"
               :rules="ruleValidate1"
               ref="updateForm1"
            >
               <FormItem label="故事編號" prop="story_id">
                  <text>{{ addItem.story_id }}</text>
               </FormItem>
               <FormItem label="故事分類" prop="story_classification">
                  <Select
                     v-model="addItem.story_classification"
                     placeholder="請選擇"
                  >
                     <Option value="經典行程">經典行程</Option>
                     <Option value="期間限定">期間限定</Option>
                  </Select>
               </FormItem>
               <FormItem label="故事名稱" prop="story_name">
                  <Input
                     v-model="addItem.story_name"
                     placeholder="請輸入故事標題"
                  ></Input>
               </FormItem>
               <FormItem label="故事年代" prop="story_age">
                  <Input
                     v-model="addItem.story_age"
                     placeholder="請輸入故事年代"
                  ></Input>
               </FormItem>
               <FormItem label="穿越日期" prop="itinerary_number_of_years">
                  <DatePicker
                     v-model="addItem.itinerary_number_of_years"
                     placeholder="請輸入確切穿越日期"
                     type="date"
                  ></DatePicker>
               </FormItem>
               <FormItem label="危險度" prop="story_risk">
                  <Select
                     v-model="addItem.story_risk"
                     placeholder="請選擇危險度"
                  >
                     <Option value="低">低</Option>
                     <Option value="中">中</Option>
                     <Option value="高">高</Option>
                  </Select>
               </FormItem>
               <FormItem label="特色" prop="story_specialty">
                  <Select
                     v-model="addItem.story_specialty"
                     placeholder="請選擇特色"
                  >
                     <Option value="奇聞軼事">奇聞軼事</Option>
                     <Option value="歷史事件">歷史事件</Option>
                     <Option value="宗教事件">宗教事件</Option>
                  </Select>
               </FormItem>
               <FormItem label="地區" prop="story_spot">
                  <Select v-model="addItem.story_spot" placeholder="請選擇地區">
                     <Option value="歐洲">歐洲</Option>
                     <Option value="北美洲">北美洲</Option>
                     <Option value="南美洲">南美洲</Option>
                     <Option value="非洲">非洲</Option>
                     <Option value="亞洲">亞洲</Option>
                     <Option value="大洋洲">大洋洲</Option>
                  </Select>
               </FormItem>
               <FormItem label="故事簡介" prop="story_intro">
                  <Input
                     v-model="addItem.story_intro"
                     type="textarea"
                     style="width: 100%"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="故事大圖">
                  <input class="story_cover_id_update" type="file" multiple />
               </FormItem>
            </Form>

            <Form
               :model="addItem"
               :label-width="80"
               ref="updateForm2"
               :rules="ruleValidate2"
            >
               <FormItem label="段落一" style="font-weight: 700"> </FormItem>
               <!-- <FormItem label="故事圖片">
                  <input
                     id="story_img01_id_update"
                     type="file"
                     ref="img01Input"
                     multiple
                  />
               </FormItem> -->
               <FormItem label="標題" prop="story_title_01">
                  <input
                     v-model="addItem.story_title_01"
                     placeholder="請輸入標題"
                  />
               </FormItem>
               <FormItem label="故事內容" prop="story_content_01">
                  <Input
                     v-model="addItem.story_content_01"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落二" style="font-weight: 700"> </FormItem>
               <!-- <FormItem label="故事圖片">
                  <input
                     id="story_img02_id_update"
                     type="file"
                     ref="img02Input"
                     multiple
                  />
               </FormItem> -->
               <FormItem label="標題" prop="story_title_02">
                  <input
                     v-model="addItem.story_title_02"
                     placeholder="請輸入標題"
                  />
               </FormItem>
               <FormItem label="故事內容" prop="story_content_02">
                  <Input
                     v-model="addItem.story_content_02"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落三" style="font-weight: 700"> </FormItem>
               <!-- <FormItem label="故事圖片">
                  <input
                     id="story_img03_id_update"
                     type="file"
                     ref="img03Input"
                     multiple
                  />
               </FormItem> -->
               <FormItem label="標題" prop="story_title_03">
                  <input
                     v-model="addItem.story_title_03"
                     placeholder="請輸入標題"
                  />
               </FormItem>
               <FormItem label="故事內容" prop="story_content_03">
                  <Input
                     v-model="addItem.story_content_03"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落四" style="font-weight: 700"> </FormItem>
               <!-- <FormItem label="故事圖片">
                  <input
                     id="story_img04_id_update"
                     type="file"
                     ref="img04Input"
                     multiple
                  />
               </FormItem> -->
               <FormItem label="標題" prop="story_title_04">
                  <input
                     v-model="addItem.story_title_04"
                     placeholder="請輸入標題"
                  />
               </FormItem>
               <FormItem label="故事內容" prop="story_content_04">
                  <Input
                     v-model="addItem.story_content_04"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落五" style="font-weight: 700"> </FormItem>
               <!-- <FormItem label="故事圖片">
                  <input
                     id="story_img05_id_update"
                     type="file"
                     ref="img05Input"
                     multiple
                  />
               </FormItem> -->
               <FormItem label="標題" prop="story_title_05">
                  <input
                     v-model="addItem.story_title_05"
                     placeholder="請輸入標題"
                  />
               </FormItem>
               <FormItem label="故事內容" prop="story_content_05">
                  <Input
                     v-model="addItem.story_content_05"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
            </Form>
         </Modal>

         <!-- 刪除按鈕 -->
         <Button class="delete" @click="remove(index, row)">刪除</Button>
      </template>
   </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";

export default {
   data() {
      return {
         modal1: false, //新增彈窗預設關閉
         modal2: false, //新增彈窗預設關閉
         modal3: [], //編輯彈窗預設關閉
         columns: [
            ///表單表頭
            {
               title: "編號",
               width: "100px", //寬度
               key: "story_id",
               align: "center", //置中
               sortable: true, //是否排序
            },
            {
               title: "故事名稱",
               width: "200px",
               key: "story_name",
               align: "center",
               sortable: true,
            },
            {
               title: "行程分類",
               width: "150px",
               slot: "story_classification",
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
                     return row.story_classification === "經典行程";
                  } else if (value === 2) {
                     return row.story_classification === "期間限定";
                  }
               },
            },
            {
               title: "危險度",
               width: "100px",
               key: "story_risk",
               align: "center",
               sortable: true,
            },
            {
               title: "特色",
               width: "150px",
               key: "story_specialty",
               align: "center",
               sortable: true,
            },
            {
               title: "地區",
               width: "100px",
               key: "story_spot",
               align: "center",
               sortable: true,
            },
            {
               title: "狀態",
               width: "100px",
               key: "story_status",
               align: "center",
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
         dataList: [],
         addItem: {
            //新增彈窗內容資料
            story_id: "",
            story_classification: "",
            story_name: "",
            story_risk: "",
            story_specialty: "",
            story_spot: "",
            story_intro: "",
            story_age: "",
            itinerary_number_of_years: "",
            story_title_01: "",
            story_title_02: "",
            story_title_03: "",
            story_title_04: "",
            story_title_05: "",
            story_content_01: "",
            story_content_02: "",
            story_content_03: "",
            story_content_04: "",
            story_content_05: "",
            story_status: 1,
            story_cover: "",
            story_img_1: "",
            story_img_2: "",
            story_img_3: "",
            story_img_4: "",
            story_img_5: "",
         },
         resetItem: {
            story_id: "",
            story_classification: "",
            story_name: "",
            story_risk: "",
            story_specialty: "",
            story_spot: "",
            story_intro: "",
            story_age: "",
            itinerary_number_of_years: "",
            story_title_01: "",
            story_title_02: "",
            story_title_03: "",
            story_title_04: "",
            story_title_05: "",
            story_content_01: "",
            story_content_02: "",
            story_content_03: "",
            story_content_04: "",
            story_content_05: "",
            story_status: 0,
            story_cover: "",
            story_img_1: "",
            story_img_2: "",
            story_img_3: "",
            story_img_4: "",
            story_img_5: "",
         },
         ruleValidate1: {
            story_name: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事名稱",
                  trigger: "blur",
               },
            ],
            story_classification: [
               {
                  required: true,
                  message: "請選擇故事分類",
                  trigger: "blur",
               },
            ],
            story_age: [
               {
                  required: true,
                  message: "請輸入故事年代",
                  trigger: "blur",
               },
            ],
            itinerary_number_of_years: [
               {
                  required: true,
                  type: "date",
                  message: "請選擇確切穿越日期",
                  trigger: "blur",
               },
            ],
            story_risk: [
               {
                  required: true,
                  message: "請選擇危險度",
                  trigger: "blur",
               },
            ],
            story_specialty: [
               {
                  required: true,
                  message: "請選擇特色",
                  trigger: "blur",
               },
            ],
            story_spot: [
               {
                  required: true,
                  message: "請選擇地區",
                  trigger: "blur",
               },
            ],
            story_intro: [
               {
                  required: true,
                  type: "string",
                  message: "請選擇地區",
                  trigger: "blur",
               },
            ],
            story_cover: [
               {
                  required: true,
                  type: "any",
                  message: "請選擇圖片",
                  trigger: "blur",
               },
            ],
         },
         ruleValidate2: {
            story_title_01: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_title_02: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_title_03: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_title_04: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_title_05: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_content_01: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_content_02: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_content_03: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_content_04: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
            story_content_05: [
               {
                  required: true,
                  type: "string",
                  message: "請輸入故事標題",
                  trigger: "blur",
               },
            ],
         },
      };
   },
   mounted() {
      this.getData();
   },
   methods: {
      remove(index, row) {
         this.$Modal.confirm({
            content: "<p>確認刪除嗎?</p>",
            okText: "確定",
            cancelText: "再看一下",
            onOk: () => {
               this.$Message.info("確認刪除");
               this.deleData(row);
               this.dataList.splice(index, 1);
            },
            onCancel: () => {
               this.$Message.info("取消");
            },
         });
      },
      async deleData(row) {
         // console.log(row.story_id);
         const story_id = row.story_id;
         const story_cover = row.story_cover;

         const responce1 = await fetch(`${BASE_URL}/getHistoryArticles.php`, {
            method: "POST",
            body: JSON.stringify({
               story_id: story_id,
            }),
         });

         const responceData1 = await responce1.json();

         const story_img_1 = responceData1[0].story_img;
         const story_img_2 = responceData1[1].story_img;
         const story_img_3 = responceData1[2].story_img;
         const story_img_4 = responceData1[3].story_img;
         const story_img_5 = responceData1[4].story_img;

         const formData = new FormData();
         formData.append("story_id", story_id);
         formData.append("story_cover", story_cover);
         formData.append("story_img_1", story_img_1);
         formData.append("story_img_2", story_img_2);
         formData.append("story_img_3", story_img_3);
         formData.append("story_img_4", story_img_4);
         formData.append("story_img_5", story_img_5);

         const responce2 = await fetch(`${BASE_URL}/dele_article_data.php`, {
            method: "POST",
            body: formData,
         });
         const responceData2 = responce2.json();
         // console.log(responceData2);

         const responce3 = await fetch(`${BASE_URL}/dele_story_data.php`, {
            method: "POST",
            body: formData,
         });
         const responceData3 = responce3.json();
         // console.log(responceData3);
      },
      getData() {
         fetch(`${BASE_URL}/getHistories.php`)
            .then((res) => res.json())
            .then((result) => {
               this.dataList = result;
               // console.log(this.dataList);
            });
      },
      onChange(row) {
         if (row.story_status) {
            this.$Message.info("狀態： 上架");
         } else {
            this.$Message.info("狀態： 下架");
         }
         this.updateStatus(row.story_id, row.story_status);
      },
      updateStatus(story_id, story_status) {
         const formData = new FormData();
         formData.append("story_id", story_id);
         formData.append("story_status", story_status);

         fetch(`${BASE_URL}/update_story_status.php`, {
            method: "POST",
            body: formData,
         })
            .then((res) => res.json())
            .then((res) => {
               const result = res;
               // console.log(result);
            });
      },
      clickEditBtn(index, row) {
         this.modal3[index] = true;
         const story_id = row.story_id;
         // console.log(row.story_id);

         fetch(`${BASE_URL}/getHistoryArticles.php`, {
            method: "POST",
            body: JSON.stringify({
               story_id: story_id,
            }),
         })
            .then((res) => res.json())
            .then((result) => {
               // console.log(result);
               const articles = {
                  story_title_01: result[0].story_title,
                  story_title_02: result[1].story_title,
                  story_title_03: result[2].story_title,
                  story_title_04: result[3].story_title,
                  story_title_05: result[4].story_title,
                  story_content_01: result[0].story_content,
                  story_content_02: result[1].story_content,
                  story_content_03: result[2].story_content,
                  story_content_04: result[3].story_content,
                  story_content_05: result[4].story_content,
               };
               // console.log(articles);
               this.addItem = { ...this.dataList[index], ...articles };
               // console.log(this.addItem);
            });
      },
      cancelEdit() {
         this.addItem = { ...this.resetItem };
      },
      replaceItem(index) {
         this.$refs["updateForm1"].validate((valid) => {
            if (valid) {
               this.addItem.itinerary_number_of_years =
                  this.addItem.itinerary_number_of_years
                     .toLocaleDateString()
                     .replace(/\//g, "-");

               this.updateData(index);
            } else {
               alert("修改失敗，請確認表格是否輸入正確");
            }
         });
      },
      updateData(name) {
         // let imgName = document.querySelector(
         //    `#${name} .story_cover_id_update`
         // );
         // console.log(imgName.files[0]);

         const formData = new FormData();
         const formDataKey = Object.keys(this.addItem);
         formDataKey.forEach((key) => {
            formData.append(`${key}`, this.addItem[key]);
         });

         // formData.set("story_cover", imgName.files[0]);

         fetch(`${BASE_URL}/update_story_data.php`, {
            method: "POST",
            body: formData,
         })
            .then((res) => res.json())
            .then((res) => {
               const result = res;

               if (result === "wrong") {
                  alert("修改失敗，資料庫已有此筆資料");
               } else {
                  this.addItem.story_cover = result.story_cover;

                  const index = this.dataList.findIndex(
                     (item) => item.story_id === this.addItem.story_id
                  );

                  this.dataList[index] = this.addItem;
               }

               this.addItem = { ...this.resetItem };
               imgName.outerHTML = imgName.outerHTML;
            });

         fetch(`${BASE_URL}/update_article_data.php`, {
            method: "POST",
            body: formData,
         })
            .then((res) => res.json())
            .then((res) => {
               const result = res;

               if (result === "wrong") {
                  alert("修改失敗，資料庫已有此筆資料");
               } else {
                  // const index = this.dataList.findIndex(
                  //    (item) => item.story_id === this.addItem.story_id
                  // );
                  // this.dataList[index] = this.addItem;
               }

               this.addItem = { ...this.resetItem };
            });
      },
      clickOk() {
         this.$refs["addForm1"].validate((valid) => {
            if (valid) {
               this.modal2 = true;
               this.addItem.itinerary_number_of_years =
                  this.addItem.itinerary_number_of_years
                     .toLocaleDateString()
                     .replace(/\//g, "-");

               this.insertData(this.addItem);
            } else {
               window.alert("新增失敗，請確認是否填寫全部欄位");
            }
         });
      },
      insertData() {
         const formData = new FormData();
         const formDataKey = Object.keys(this.addItem);
         formDataKey.forEach((key) => {
            formData.append(`${key}`, this.addItem[key]);
         });

         let bannerName = document.getElementById("story_cover_id");
         formData.set("story_cover", bannerName.files[0]);

         fetch(`${BASE_URL}/insert_story_data.php`, {
            method: "POST",
            body: formData,
         })
            .then((res) => res.json())
            .then((res) => {
               const result = res;

               if (result === "wrong") {
                  alert("新增失敗，資料庫已有此筆資料");
               } else {
                  this.addItem.story_cover = result.story_cover;
                  this.addItem.story_id = result.story_id;
                  // this.dataList.push({ ...this.addItem });
               }

               // this.addItem = { ...this.resetItem };
               // console.log(result.msg);
               bannerName.outerHTML = bannerName.outerHTML;
            });
         // console.log(this.addItem);
      },
      clickOk2() {
         this.$refs["addForm2"].validate((valid) => {
            if (valid) {
               this.insertArticleData(this.addItem);
            } else {
               window.alert("新增失敗，請確認是否填寫全部欄位");
            }
         });
      },
      async insertArticleData() {
         const storyName = this.addItem.story_name;
         // console.log(storyName);

         const responce1 = await fetch(`${BASE_URL}/findStoryId.php`, {
            // method: "POST",
            // body: JSON.stringify({
            //    story_name: storyName,
            // }),
         });
         const responceData1 = await responce1.json();
         this.addItem.story_id = responceData1[0].story_id;

         const formData = new FormData();
         const formDataKey = Object.keys(this.addItem);
         formDataKey.forEach((key) => {
            formData.append(`${key}`, this.addItem[key]);
         });
         let imgName1 = document.getElementById("story_img01_id");
         formData.set("story_img_1", imgName1.files[0]);
         let imgName2 = document.getElementById("story_img02_id");
         formData.set("story_img_2", imgName2.files[0]);
         let imgName3 = document.getElementById("story_img03_id");
         formData.set("story_img_3", imgName3.files[0]);
         let imgName4 = document.getElementById("story_img04_id");
         formData.set("story_img_4", imgName4.files[0]);
         let imgName5 = document.getElementById("story_img05_id");
         formData.set("story_img_5", imgName5.files[0]);

         const responce2 = fetch(`${BASE_URL}/insert_article_data.php`, {
            method: "POST",
            body: formData,
         });
         const responceData2 = responce2.json();
         if (responceData2 === "wrong") {
            alert("新增失敗，資料庫已有此筆資料");
         } else {
            this.addItem.story_img_1 = responceData2.story_img_1;
            this.addItem.story_img_2 = responceData2.story_img_2;
            this.addItem.story_img_3 = responceData2.story_img_3;
            this.addItem.story_img_4 = responceData2.story_img_4;
            this.addItem.story_img_5 = responceData2.story_img_5;
            this.dataList.push({ ...this.addItem });
         }
         console.log(this.addItem);
         this.addItem = { ...this.resetItem };
         imgName1.outerHTML = imgName1.outerHTML;
         imgName2.outerHTML = imgName2.outerHTML;
         imgName3.outerHTML = imgName3.outerHTML;
         imgName4.outerHTML = imgName4.outerHTML;
         imgName5.outerHTML = imgName5.outerHTML;
      },
      cancelAdd() {
         this.addItem = { ...this.resetItem };
      },
   },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
