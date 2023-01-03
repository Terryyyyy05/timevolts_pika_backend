<template>
  <!-- 標題 -->
  <the-heading heading="最新消息管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal v-model="modal1" title="新增最新消息" width="700px" class="addnews-popup" :styles="{ top: '30px' }" ok-text="確認新增"
    cancel-text="取消新增" @on-ok="clickOk">
    <Form :model="addItem" :label-width="80" method="post" enctype="multipart/form-data" id="addForm" inline>
      <FormItem label="消息編號">
        <Input v-model="addItem.news_id" placeholder="請輸入消息編號"></Input>
      </FormItem>
      <FormItem label="消息分類" prop="news_category">
        <Select v-model="addItem.news_category" :value="news_category" placeholder="請選擇" name="news_category">
          <Option value="行程預訂">行程預訂</Option>
          <Option value="歷史故事">歷史故事</Option>
          <Option value="購物商城">購物商城</Option>
          <Option value="其他消息">其他消息</Option>
        </Select>
      </FormItem>
    </Form>
    <Form :model="addItem" :label-width="80">
      <FormItem label="消息標題">
        <Input v-model="addItem.news_title" placeholder="請輸入消息標題" name="news_title"></Input>
      </FormItem>
      <FormItem label="消息標籤">
        <Input v-model="addItem.news_hashtag" placeholder="請輸入消息標籤" name="news_hashtag"></Input>
      </FormItem>
      <FormItem label="日期">
        <DatePicker type="date" placeholder="請選擇日期" v-model="addItem.news_add_date" name="news_add_date"></DatePicker>
      </FormItem>
      <FormItem label="消息圖片">
        <input type="file" multiple id="news_img" name="news_img" />
      </FormItem>
      <FormItem label="消息路徑">
        <Select v-model="addItem.news_item_id" name="addItem.news_item_id" placeholder="請選擇">
          <Option value="itineraryClassicView">itineraryClassicView</Option>
          <Option value="history">history</Option>
          <Option value="product">product</Option>
          <Option value="home">home</Option>
        </Select>
      </FormItem>
      <FormItem label="消息內容">
        <Input v-model="addItem.news_content" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"
          name="news_content"></Input>
      </FormItem>
      <FormItem label="狀態">
        <Select v-model="addItem.news_status" placeholder="請選擇" style="width:100px" name="news_status">
          <Option value="parseInt(1)">上架</Option>
          <Option value="parseInt(0)">下架</Option>
        </Select>
      </FormItem>
    </Form>
  </Modal>

  <!-- 表格 -->
  <Table class="table" stripe border :columns="columns" :data="getNews" width="1200">
    <template #news_id="{ row }">
      <Input type="text">{{ row.news_id }}</Input>
    </template>
    <!-- 加入開關按鈕 -->

    <template #news_status="{ row }">
      <Switch size="large" true-color="#fab042" false-color="#e6e6e6" :true-value="parseInt(1)"
        :false-value="parseInt(0)" v-model="row.news_status" @on-change="onChange(row)">
        <template #open>
          <span>上架</span>
        </template>
        <template #close>
          <span>下架</span>
        </template>
      </Switch>
    </template>

    <template #news_category="{ row }">
      <text>{{ row.news_category }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index, row }">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal v-model="modal3[index]" title="編輯最新消息" ok-text="確認修改" cancel-text="取消" width="700px" class="editnews-popup"
        :styles="{ top: '30px' }" @on-ok="replaceItem(row.news_id)" @on-cancel="cancelEdit">

        <Form 
        :model="addItem" 
        :label-width="80" 
        name="updateForm"
        ref="updateForm"
        inline>
          <FormItem label="消息編號" :model="addItem">
            <text>{{ addItem.news_id }}</text>
          </FormItem>
          <FormItem label="消息分類" prop="news_category">
            <Select v-model="addItem.news_category" placeholder="請選擇">
              <Option value="行程預訂">行程預訂</Option>
              <Option value="歷史故事">歷史故事</Option>
              <Option value="購物商城">購物商城</Option>
              <Option value="其他消息">其他消息</Option>
            </Select>
          </FormItem>
        </Form>
        <Form :model="addItem" :label-width="80">
          <FormItem label="消息標題">
            <Input v-model="addItem.news_title" placeholder="請輸入消息標題"></Input>
          </FormItem>
          <FormItem label="消息標籤">
            <Input v-model="addItem.news_hashtag" placeholder="請輸入消息標籤"></Input>
          </FormItem>
          <FormItem label="日期">
            <DatePicker type="date" placeholder="請選擇日期" v-model="addItem.news_add_date"></DatePicker>
          </FormItem>
          <FormItem label="消息圖片">
            <input type="file" multiple id="news_img" name="news_img" />
          </FormItem>
          <FormItem label="消息路徑">
            <Input v-model="addItem.news_item_id" placeholder="請輸入消息標籤路徑" name="news_item_id"></Input>
          </FormItem>
          <FormItem label="消息內容">
            <Input v-model="addItem.news_content" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"></Input>
          </FormItem>
          <FormItem label="狀態">
            <Select v-model="addItem.news_status" placeholder="請選擇" style="width:100px">
              <Option value="parseInt(1)">上架</Option>
              <Option value="parseInt(0)">下架</Option>
            </Select>
          </FormItem>
        </Form>
      </Modal>

      <!-- 刪除按鈕 -->
      <Button class="delete" @click="remove(index, row)">刪除</Button>
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom.js";

export default {
  data() {
    return {
      modal1: false,  //新增彈窗預設關閉
      modal3: [],
      columns: [  ///表單表頭
        {
          title: "編號",
          width: "100px", //寬度
          key: "news_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "發布日期",
          width: "150px",
          key: "news_add_date",
          align: "center",
          sortable: true,
        },
        {
          title: "消息分類",
          width: "150px",
          align: "center",
          slot:"news_category",
          filters: [
            //篩選分類
            {
              label: "行程預訂",
              value: 0,
            },
            {
              label: "歷史故事",
              value: 1,
            },
            {
              label: "購物商城",
              value: 2,
            },
            {
              label: "其他消息",
              value: 3,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 0) {
              return row.news_category === "行程預訂";
            } else if (value === 1) {
              return row.news_category === "歷史故事";
            } else if (value === 2) {
              return row.news_category === "購物商城";
            } else {
              return row.news_category === "其他消息";
            }
          },
        },
        {
          title: "標題",
          key: "news_title",
          align: "center",
        },
        {
          title: "狀態",
          key: "news_status",
          slot: "news_status",
          align: "center",
          width: "100px", //加入開關鈕欄位需加slot
        },
        {
          title: "編輯/刪除",
          width: "200px",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
        },
      ],
      // data: [
      //   ///表格內容資料
      //   {
      //     id: '1001',
      //     date: '2022-12-10',
      //     news_type: '行程預訂',
      //     status: true,
      //     title: '穿梭於史前時代',
      //     textarea: 'ssfdsfv',
      //   },
      //   {
      //     id: '1002',
      //     date: '2022-11-10',
      //     news_type: '行程預訂',
      //     status: true,
      //     title: '埃及五千年的黃金時代',
      //     textarea: 'sasfasfasafsfaffv',
      //   },
      //   {
      //     id: '2001',
      //     date: '2022-12-15',
      //     news_type: '歷史故事',
      //     status: true,
      //     title: '鐵達尼號沈船',
      //     textarea: 'sasfasfsfaxxfaffv',
      //   },
      //   {
      //     id: '2002',
      //     date: '2022-12-01',
      //     news_type: '歷史故事',
      //     status: true,
      //     title: '鄭和下西洋',
      //     textarea: 'sasdddddsdaffv',
      //   },
      //   {
      //     id: '3001',
      //     date: '2022-11-11',
      //     news_type: '購物商城',
      //     status: false,
      //     title: '購物須知',
      //     textarea: 'ssdddxvfaxxfaffv',
      //   },
      //   {
      //     id: '4001',
      //     date: '2022-11-09',
      //     news_type: '其他消息',
      //     status: false,
      //     title: '官網維護公告',
      //     textarea: 'aaaxssdddavaxxfaffv',
      //   },
      // ],
      getNews: [],
      addItem: {   //新增彈窗內容資料
        news_id: '',
        news_title: '',
        news_add_date: '',
        news_category: '',
        news_hashtag: '',
        news_status: '',
        news_img: '',
        news_item_id: '',
        news_content: ''
      },
      resetItem: {
        news_id: '',
        news_title: '',
        news_add_date: '',
        news_category: '',
        news_hashtag: '',
        news_status: '',
        news_img: '',
        news_item_id: '',
        news_content: ''
      },
    }
  },
  methods: {
    remove(index, row) {
      this.$Modal.confirm({
        content: "<p>確認刪除嗎?</p>",
        okText: "刪刪刪拉",
        cancelText: "先不要好ㄌ",
        onOk: () => {
          this.$Message.info("確認刪除");
          this.deleData(row);
          this.getNews.splice(index, 1);
        },
        onCancel: () => {
          this.$Message.info("取消");
        },
      });
    },
    onChange(row) {
      if (row.news_status) {
        this.$Message.info("上架狀態： 上架");
      } else {
        this.$Message.info("上架狀態： 下架");
      }
      this.updateStatus(row.news_id, row.news_status);
    },
    clickOk() {
      this.addItem.news_add_date = this.addItem.news_add_date
        .toLocaleDateString()
        .replace(/\//g, "-");
        this.insertData(this.addItem);
    },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.getNews[index] };
      // console.log(this.getNews[0]);
    },
    replaceItem(index) {
      // const index = this.getNews.findIndex((item) => item.news_id === this.addItem.news_id);
      this.$refs["updateForm"].validate((valid) => {
                if (valid) {

      this.addItem.news_add_date = this.addItem.news_add_date.toLocaleDateString().replace(/\//g, "-");
      this.updateData(index);
      // this.getNews[index] = this.addItem;
      // this.addItem = { ...this.resetItem };
    } else {
                    alert("修改失敗，請確認表格是否輸入正確");
                }
              });
    },
    cancelEdit() {
      this.addItem = { ...this.resetItem };
      // console.log(this.getNews[0]);
    },
    getData() {
      fetch(`${BASE_URL}/getNews.php`)
        .then((res) => res.json())
        .then((result) => {
          this.getNews = result;
        });
    },
    insertData() {
      const formData = new FormData();
      const formDataKey = Object.keys(this.addItem);
      formDataKey.forEach((key) => {
        formData.append(`${key}`, this.addItem[key]);
      });
      const imgName = document.getElementById("news_img");
      // console.log("----------------",imgName);
      formData.set("news_img", imgName.files[0]);

      fetch(`${BASE_URL}/insert_news.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          console.log(res);
          // const result = res;
          // this.addItem.news_img = result.news_img;
          this.getNews.push({ ...this.addItem });
          this.addItem = { ...this.resetItem };
        });
    },
    deleData(row) {
      // console.log(row.news_id);
      const formData = new FormData();
      formData.append("news_id", row.news_id);
      formData.append("news_img", row.news_img);

      fetch(`${BASE_URL}/dele_news.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
        });
    },
    updateData(name) {
            let imgName = document.querySelector(`#${name} .news_img_id_update`);
            console.log(imgName.files[0]);

            const formData = new FormData();
            const formDataKey = Object.keys(this.addItem);
            formDataKey.forEach((key) => {
                formData.append(`${key}`, this.addItem[key]);
            });

            formData.set("news_img", imgName.files[0]);

            fetch(`${BASE_URL}/update_pro_data.php`, {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((res) => {
                    const result = res;

                    if (result === "wrong") {
                        alert("新增失敗，資料庫已有此筆資料");
                    } else {
                        this.addItem.news_img = result.news_img;

                        const index = this.getData.findIndex(
                            (item) => item.news_id === this.addItem.news_id
                        );

                        this.getData[index] = this.addItem;
                    }

                    this.addItem = { ...this.resetItem };
                    imgName.outerHTML = imgName.outerHTML;
                });
        },
        updateStatus(news_id, news_status) {
            const formData = new FormData();
            formData.append("news_status", news_status);
            formData.append("news_id", news_id);

            fetch(`${BASE_URL}/update_news_status.php`, {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((res) => {
                    const result = res;
                    console.log(result);
                });
        },
    saveData() { },
  },
  mounted() {
    this.getData();
  },
  computed: {},
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
