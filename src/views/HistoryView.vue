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
      <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
         <FormItem label="故事編號">
            <Input
               v-model="addItem.story_id"
               placeholder="請輸入故事編號"
            ></Input>
         </FormItem>
         <FormItem label="故事分類">
            <Select v-model="addItem.story_classification" placeholder="請選擇">
               <Option value="經典事件">經典事件</Option>
               <Option value="期間限定">期間限定</Option>
            </Select>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80">
         <FormItem label="故事名稱">
            <Input
               v-model="addItem.story_name"
               placeholder="請輸入故事標題"
            ></Input>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
         <FormItem label="故事年代">
            <Input
               v-model="addItem.story_age"
               placeholder="請輸入故事年代"
            ></Input>
         </FormItem>
         <FormItem label="穿越日期">
            <Input
               v-model="addItem.itinerary_number_of_years"
               placeholder="請輸入確切穿越日期"
            ></Input>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
         <FormItem label="危險度">
            <Select v-model="addItem.story_risk" placeholder="請選擇危險度">
               <Option value="低">低</Option>
               <Option value="中">中</Option>
               <Option value="高">高</Option>
            </Select>
         </FormItem>
         <FormItem label="特色">
            <Select v-model="addItem.story_specialty" placeholder="請選擇特色">
               <Option value="奇聞軼事">奇聞軼事</Option>
               <Option value="歷史事件">歷史事件</Option>
               <Option value="宗教事件">宗教事件</Option>
            </Select>
         </FormItem>
         <FormItem label="地區">
            <Select v-model="addItem.story_spot" placeholder="請選擇地區">
               <Option value="歐洲">歐洲</Option>
               <Option value="北美洲">北美洲</Option>
               <Option value="南美洲">南美洲</Option>
               <Option value="非洲">非洲</Option>
               <Option value="亞洲">亞洲</Option>
               <Option value="大洋洲">大洋洲</Option>
            </Select>
         </FormItem>
         <FormItem label="故事簡介">
            <Input
               v-model="addItem.story_intro"
               type="textarea"
               style="width: 100%"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
      </Form>
      <Form :model="addItem" :label-width="80">
         <FormItem label="故事大圖">
            <input
               id="story_banner_id"
               type="file"
               ref="bannerInput"
               multiple
            />
         </FormItem>
         <FormItem label="段落一" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片1">
            <input id="story_img01_id" type="file" ref="img01Input" multiple />
         </FormItem>
         <FormItem label="故事內容">
            <Input
               v-model="addItem.story_content_01"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落二" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片2">
            <input id="story_img02_id" type="file" ref="img02Input" multiple />
         </FormItem>
         <FormItem label="故事內容">
            <Input
               v-model="addItem.story_content_02"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落三" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片3">
            <input id="story_img03_id" type="file" ref="img03Input" multiple />
         </FormItem>
         <FormItem label="故事內容">
            <Input
               v-model="addItem.story_content_03"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落四" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片4">
            <input id="story_img04_id" type="file" ref="img04Input" multiple />
         </FormItem>
         <FormItem label="故事內容">
            <Input
               v-model="addItem.story_content_04"
               type="textarea"
               :autosize="{ minRows: 10, maxRows: 50 }"
            ></Input>
         </FormItem>
         <FormItem label="段落五" style="font-weight: 700"> </FormItem>
         <FormItem label="故事圖片5">
            <input id="story_img05_id" type="file" ref="img05Input" multiple />
         </FormItem>
         <FormItem label="故事內容">
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
            :true-value="parseInt(1)"
            :false-value="parseInt(0)"
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
                     v-model="addItem.story_id"
                     placeholder="請輸入故事編號"
                  ></Input>
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
            </Form>
            <Form :model="addItem" :label-width="80">
               <FormItem label="故事名稱">
                  <Input
                     v-model="addItem.story_name"
                     placeholder="請輸入故事標題"
                  ></Input>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
               <FormItem label="故事年代">
                  <Input
                     v-model="addItem.story_age"
                     placeholder="請輸入故事年代"
                  ></Input>
               </FormItem>
               <FormItem label="穿越日期">
                  <Input
                     v-model="addItem.itinerary_number_of_years"
                     placeholder="請輸入確切穿越日期"
                  ></Input>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80" :rules="ruleInline" inline>
               <FormItem label="危險度">
                  <Select
                     v-model="addItem.story_risk"
                     placeholder="請選擇危險度"
                  >
                     <Option value="低">低</Option>
                     <Option value="中">中</Option>
                     <Option value="高">高</Option>
                  </Select>
               </FormItem>
               <FormItem label="特色">
                  <Select
                     v-model="addItem.story_specialty"
                     placeholder="請選擇特色"
                  >
                     <Option value="奇聞軼事">奇聞軼事</Option>
                     <Option value="歷史事件">歷史事件</Option>
                     <Option value="宗教事件">宗教事件</Option>
                  </Select>
               </FormItem>
               <FormItem label="地區">
                  <Select v-model="addItem.story_spot" placeholder="請選擇地區">
                     <Option value="歐洲">歐洲</Option>
                     <Option value="北美洲">北美洲</Option>
                     <Option value="南美洲">南美洲</Option>
                     <Option value="非洲">非洲</Option>
                     <Option value="亞洲">亞洲</Option>
                     <Option value="大洋洲">大洋洲</Option>
                  </Select>
               </FormItem>
               <FormItem label="故事簡介">
                  <Input
                     v-model="addItem.story_intro"
                     type="textarea"
                     style="width: 100%"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
            </Form>
            <Form :model="addItem" :label-width="80">
               <FormItem label="故事大圖">
                  <input
                     id="story_banner_id"
                     type="file"
                     ref="bannerInput"
                     multiple
                  />
               </FormItem>
               <FormItem label="段落一" style="font-weight: 700"> </FormItem>
               <FormItem label="故事圖片1">
                  <input
                     id="story_img01_id"
                     type="file"
                     ref="img01Input"
                     multiple
                  />
               </FormItem>
               <FormItem label="故事內容">
                  <Input
                     v-model="addItem.story_content_01"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落二" style="font-weight: 700"> </FormItem>
               <FormItem label="故事圖片2">
                  <input
                     id="story_img02_id"
                     type="file"
                     ref="img02Input"
                     multiple
                  />
               </FormItem>
               <FormItem label="故事內容">
                  <Input
                     v-model="addItem.story_content_02"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落三" style="font-weight: 700"> </FormItem>
               <FormItem label="故事圖片3">
                  <input
                     id="story_img03_id"
                     type="file"
                     ref="img03Input"
                     multiple
                  />
               </FormItem>
               <FormItem label="故事內容">
                  <Input
                     v-model="addItem.story_content_03"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落四" style="font-weight: 700"> </FormItem>
               <FormItem label="故事圖片4">
                  <input
                     id="story_img04_id"
                     type="file"
                     ref="img04Input"
                     multiple
                  />
               </FormItem>
               <FormItem label="故事內容">
                  <Input
                     v-model="addItem.story_content_04"
                     type="textarea"
                     :autosize="{ minRows: 10, maxRows: 50 }"
                  ></Input>
               </FormItem>
               <FormItem label="段落五" style="font-weight: 700"> </FormItem>
               <FormItem label="故事圖片5">
                  <input
                     id="story_img05_id"
                     type="file"
                     ref="img05Input"
                     multiple
                  />
               </FormItem>
               <FormItem label="故事內容">
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
            story_status: 0,
         },
         // editItem: {
         //    // id: "addItem.story_id()",
         //    title: "",
         //    select: "",
         //    date: "",
         //    textarea: "",
         // },
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
      getData() {
         fetch(`${BASE_URL}/getHistories.php`)
            .then((res) => res.json())
            .then((result) => {
               this.dataList = result;
               console.log(this.dataList);
            });
      },
      onChange(row) {
         if (row.story_status) {
            this.$Message.info("狀態： 上架");
         } else {
            this.$Message.info("狀態： 下架");
         }
         // console.log(row);
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
      deleData(row) {},
   },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
