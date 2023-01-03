<template>
  <!-- 標題 -->
  <the-heading heading="商品管理系統"></the-heading>
  <!-- 新增彈窗按鈕 -->
  <Button @click="modal1 = true" class="add">新增 +</Button>
  <!-- 新增彈窗 -->
  <Modal
    v-model="modal1"
    title="新增商品"
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
      method="post"
      enctype="multipart/form-data"
      ref="addForm"
      :rules="ruleValidate"
    >
      <FormItem label="商品分類" prop="pro_class_name">
        <Select v-model="addItem.pro_class_name" placeholder="請選擇">
          <Option value="旅行必備">旅行必備</Option>
          <Option value="醫療用品">醫療用品</Option>
          <Option value="應急糧食">應急糧食</Option>
          <Option value="求生用品">求生用品</Option>
        </Select>
      </FormItem>
      <FormItem label="商品名稱" prop="pro_name">
        <Input v-model="addItem.pro_name" placeholder="請輸入商品名稱"></Input>
      </FormItem>
      <FormItem label="上架日期" prop="pro_onshelf_date">
        <DatePicker
          type="date"
          placeholder="請選擇日期"
          v-model="addItem.pro_onshelf_date"
        ></DatePicker>
      </FormItem>
      <FormItem label="商品單價" prop="pro_price">
        <input
          type="number"
          placeholder="請輸入商品單價"
          v-model="addItem.pro_price"
        />
      </FormItem>
      <FormItem label="商品數量" prop="pro_onshelf_amount">
        <input
          type="number"
          placeholder="請輸入商品上架數量"
          v-model="addItem.pro_onshelf_amount"
        />
      </FormItem>
      <FormItem label="商品圖片" prop="pro_img">
        <input id="pro_img_id" type="file" multiple />
      </FormItem>
      <FormItem label="商品資訊" prop="pro_info">
        <Input
          v-model="addItem.pro_info"
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
    width="1200"
  >
    <!-- 加入開關按鈕 -->
    <template #on_off="{ row }">
      <Switch
        size="large"
        true-color="#fab042"
        false-color="#e6e6e6"
        v-model="row.pro_status"
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

    <template #pro_class_name="{ row }">
      <text>{{ row.pro_class_name }}</text>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index, row }">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3[index]"
        :id="row.pro_name"
        title="編輯商品資訊"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
        @on-ok="replaceItem(row.pro_name)"
        @on-cancel="cancelEdit"
      >
        <Form
          :model="addItem"
          :label-width="80"
          :rules="ruleValidate"
          ref="updateForm"
        >
          <FormItem label="商品編號">
            <text>{{ addItem.pro_id }}</text>
          </FormItem>
          <FormItem label="商品分類" prop="pro_class_name">
            <Select v-model="addItem.pro_class_name" placeholder="請選擇">
              <Option value="旅行必備">旅行必備</Option>
              <Option value="醫療用品">醫療用品</Option>
              <Option value="應急糧食">應急糧食</Option>
              <Option value="求生用品">求生用品</Option>
            </Select>
          </FormItem>
          <FormItem label="商品名稱" prop="pro_name">
            <Input
              v-model="addItem.pro_name"
              placeholder="請輸入商品名稱"
            ></Input>
          </FormItem>
          <FormItem label="上架日期" prop="pro_onshelf_date">
            <DatePicker
              type="date"
              placeholder="請選擇日期"
              v-model="addItem.pro_onshelf_date"
            ></DatePicker>
          </FormItem>
          <FormItem label="商品單價" prop="pro_price">
            <input
              type="number"
              placeholder="請輸入商品單價"
              v-model="addItem.pro_price"
            />
          </FormItem>
          <FormItem label="商品數量" prop="pro_onshelf_amount">
            <input
              type="number"
              placeholder="請更新商品上架數量"
              v-model="addItem.pro_onshelf_amount"
            />
          </FormItem>
          <FormItem label="商品圖片">
            <input class="pro_img_id_update" type="file" multiple />
          </FormItem>
          <FormItem label="商品資訊" prop="pro_info">
            <Input
              v-model="addItem.pro_info"
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
      test: true,
      modal1: false, //新增彈窗預設關閉
      modal3: [], //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "商品編號",
          width: "110px", //寬度
          key: "pro_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "上架日期",
          width: "110px",
          key: "pro_onshelf_date",
          align: "center",
          sortable: true,
        },
        {
          title: "商品分類",
          width: "120px",
          slot: "pro_class_name",
          align: "center",
          filters: [
            //篩選分類
            {
              label: "旅行必備",
              value: 1,
            },
            {
              label: "醫療用品",
              value: 2,
            },
            {
              label: "應急糧食",
              value: 3,
            },
            {
              label: "求生用品",
              value: 4,
            },
          ],
          filterMultiple: false,
          filterMethod(value, row) {
            if (value === 1) {
              return row.pro_class_name === "旅行必備";
            } else if (value === 2) {
              return row.pro_class_name === "醫療用品";
            } else if (value === 3) {
              return row.pro_class_name === "應急糧食";
            } else {
              return row.pro_class_name === "求生用品";
            }
          },
        },
        {
          title: "商品名稱",
          key: "pro_name",
          align: "center",
        },
        {
          title: "單價",
          width: "80px",
          key: "pro_price",
          align: "center",
          sortable: true,
        },
        {
          title: "上架數量",
          width: "110px",
          key: "pro_onshelf_amount",
          align: "center",
          sortable: true,
        },
        {
          title: "剩餘數量",
          width: "110px",
          key: "pro_rest_amount",
          align: "center",
          sortable: true,
        },
        {
          title: "狀態",
          key: "pro_status",
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
      dataList: [],
      addItem: {
        //新增彈窗內容資料
        // pro_id: "",
        pro_name: "",
        pro_class_name: "",
        pro_onshelf_date: "",
        pro_info: "",
        pro_price: "",
        pro_onshelf_amount: "",
        pro_rest_amount: "",
        pro_status: 0,
        pro_img: "",
      },
      resetItem: {
        // pro_id: "",
        pro_name: "",
        pro_class_name: "",
        pro_onshelf_date: "",
        pro_info: "",
        pro_price: "",
        pro_onshelf_amount: "",
        pro_rest_amount: "",
        pro_status: 0,
        pro_img: "",
      },
      // validate
      ruleValidate: {
        pro_name: [
          {
            required: true,
            message: "名字記得打拜託",
            trigger: "blur",
          },
        ],
        pro_class_name: [
          {
            required: true,
            type: "string",
            message: "別忘了分類",
            trigger: "blur",
          },
        ],
        pro_onshelf_date: [
          {
            required: true,
            type: "date",
            message: "啥時要上架啦",
            trigger: "blur",
          },
        ],
        pro_info: [{ required: true, message: "介紹一下吧", trigger: "blur" }],
        pro_price: [
          {
            required: true,
            type: "number",
            message: "不輸入是不用錢逆",
            trigger: "blur",
          },
        ],
        pro_onshelf_amount: [
          {
            required: true,
            type: "number",
            message: "商品數量輸入了嗎",
            trigger: "blur",
          },
        ],
        pro_rest_amount: "",
        pro_status: 0,
        pro_img: [
          {
            required: true,
            type: "any",
            message: "商品數量輸入了嗎",
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    remove(index, row) {
      console.log(row);
      this.$Modal.confirm({
        content: "<p>確認刪除嗎?</p>",
        okText: "刪刪刪",
        cancelText: "還是不要好了",
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
    onChange(row) {
      console.log(row.pro_status);
      if (row.pro_status) {
        this.$Message.info("上架狀態： 上架");
      } else {
        this.$Message.info("上架狀態： 下架");
      }
      console.log(row);

      this.updateStatus(row.pro_id, row.pro_status);
    },
    clickOk() {
      this.$refs["addForm"].validate((valid) => {
        if (valid) {
          this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
          this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
            .toLocaleDateString()
            .replace(/\//g, "-");

          this.insertData(this.addItem);
        } else {
          alert("新增失敗，請確認表格是否輸入正確");
          // this.$Message.error("Fail!");
          // this.addItem = { ...this.resetItem };
          // document.getElementById("pro_img_id").outerHTML =
          //   document.getElementById("pro_img_id").outerHTML;
        }
      });

      // this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
      // this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
      //   .toLocaleDateString()
      //   .replace(/\//g, "-");

      // this.insertData(this.addItem);
    },
    clickEditBtn(index) {
      this.modal3[index] = true;
      this.addItem = { ...this.dataList[index] };
    },
    replaceItem(index) {
      console.log(index);
      this.$refs["updateForm"].validate((valid) => {
        console.log(index);
        if (valid) {
          // this.addItem.pro_rest_amount = this.addItem.pro_onshelf_amount;
          // this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
          //   .toLocaleDateString()
          //   .replace(/\//g, "-");

          // this.insertData(this.addItem);

          this.addItem.pro_onshelf_date = this.addItem.pro_onshelf_date
            .toLocaleDateString()
            .replace(/\//g, "-");

          this.updateData(index);
          console.log(index);

          // 帶移動
          // const index = this.dataList.findIndex(
          //   (item) => item.pro_id === this.addItem.pro_id
          // );

          // this.dataList[index] = this.addItem;
          // this.addItem = { ...this.resetItem };
        } else {
          alert("修改失敗，請確認表格是否輸入正確");
        }
      });
    },
    cancelEdit() {
      this.addItem = { ...this.resetItem };
    },
    getData() {
      fetch(`${BASE_URL}/get_pro_data.php`)
        .then((res) => res.json())
        .then((result) => {
          this.dataList = result;
        });
    },
    insertData() {
      const formData = new FormData();
      const formDataKey = Object.keys(this.addItem);
      formDataKey.forEach((key) => {
        formData.append(`${key}`, this.addItem[key]);
      });

      let imgName = document.getElementById("pro_img_id");
      formData.set("pro_img", imgName.files[0]);

      fetch(`${BASE_URL}/insert_pro_data.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;

          if (result === "wrong") {
            alert("新增失敗，資料庫已有此筆資料");
          } else {
            this.addItem.pro_img = result.pro_img;
            this.addItem.pro_id = result.pro_id[0].pro_id;
            this.dataList.push({ ...this.addItem });
          }

          this.addItem = { ...this.resetItem };
          imgName.outerHTML = imgName.outerHTML;
        });
    },
    deleData(row) {
      console.log(row.pro_id);
      const formData = new FormData();
      formData.append("pro_id", row.pro_id);
      formData.append("pro_img", row.pro_img);

      fetch(`${BASE_URL}/dele_pro_data.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
        });
    },
    updateData(name) {
      let imgName = document.querySelector(`#${name} .pro_img_id_update`);
      console.log(imgName.files[0]);

      const formData = new FormData();
      const formDataKey = Object.keys(this.addItem);
      formDataKey.forEach((key) => {
        formData.append(`${key}`, this.addItem[key]);
      });

      formData.set("pro_img", imgName.files[0]);

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
            this.addItem.pro_img = result.pro_img;

            const index = this.dataList.findIndex(
              (item) => item.pro_id === this.addItem.pro_id
            );

            this.dataList[index] = this.addItem;
          }

          this.addItem = { ...this.resetItem };
          imgName.outerHTML = imgName.outerHTML;
        });
    },
    updateStatus(pro_id, pro_status) {
      const formData = new FormData();
      formData.append("pro_status", pro_status);
      formData.append("pro_id", pro_id);

      fetch(`${BASE_URL}/update_pro_status.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;
          console.log(result);
        });
    },
  },

  mounted() {
    this.getData();
  },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
