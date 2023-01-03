<template>
  <!-- 標題 -->
  <the-heading heading="行程訂單管理系統"></the-heading>

  <!-- 表格 -->
  <Table
    class="table"
    stripe
    border
    :columns="columns"
    :data="dataList"
    width="1200"
  >
    <template #status="{ row }">
      <Select
        v-model="row.itinerary_order_status"
        @on-change="
          updateStatus(row.itinerary_order_id, row.itinerary_order_status)
        "
      >
        <Option :value="0 + ''">退單完成</Option>
        <Option :value="1 + ''">退單處理中</Option>
        <Option :value="2 + ''">訂單成功</Option>
      </Select>
    </template>

    <!-- 加入編輯、刪除彈窗 -->
    <template #edit_del="{ index, row }">
      <!-- 編輯按鈕 -->
      <Button @click="clickEditBtn(index, row)" class="edit">查看</Button>
      <!-- 編輯彈窗 -->
      <Modal
        v-model="modal3[index]"
        title="查看行程訂單詳細資訊"
        ok-text="確認修改"
        cancel-text="取消"
        width="700px"
        class="editnews-popup"
        :styles="{ top: '30px' }"
      >
        <Form :model="addItem" :label-width="80">
          <!-- <FormItem label="行程訂單編號">
                  <text>{{ addItem.itinerary_order_id }}</text>
               </FormItem>
               <FormItem label="行程編號">
                  <text>{{ addItem.itinerary_id }}</text>
               </FormItem>
               <FormItem label="會員編號">
                  <text>{{ addItem.mem_id }}</text>
               </FormItem>
               <FormItem label="行程訂單日期">
                  <text>{{ addItem.itinerary_order_date }}</text>
               </FormItem>
               <FormItem label="行程參加人數">
                  <text>{{ addItem.itinerary_participant }}</text>
               </FormItem>
               <FormItem label="行程總價">
                  <text>{{ addItem.itinerary_participant }}</text>
               </FormItem>
               <FormItem label="行程訂單狀態">
                  <Select v-model="addItem.itinerary_order_status">
                     <Option :value="0">退單完成</Option>
                     <Option :value="1">退單處理中</Option>
                     <Option :value="2">訂單成功</Option>
                  </Select>
               </FormItem> -->
        </Form>
        <Form
          :model="addItem"
          :label-width="80"
          v-for="(participant, index) in participants"
          :key="participant"
        >
          <FormItem
            :label="`成員${index + 1}`"
            style="font-weight: 700; font-size: 36px"
          >
          </FormItem>
          <FormItem label="姓名:">
            <text>{{ participant.participant_name }}</text>
          </FormItem>
          <FormItem label="電話:">
            <text>{{ participant.participant_phone }}</text>
          </FormItem>
          <FormItem label="信箱:">
            <text>{{ participant.participant_email }}</text>
          </FormItem>
        </Form>
      </Modal>
    </template>
  </Table>
</template>

<script>
import { BASE_URL } from "@/assets/js/commom";

export default {
  data() {
    return {
      modal3: [], //編輯彈窗預設關閉
      columns: [
        ///表單表頭
        {
          title: "行程訂單編號",
          key: "itinerary_order_id",
          align: "center", //置中
          sortable: true, //是否排序
        },
        {
          title: "行程編號",
          width: "150px",
          key: "itinerary_id",
          align: "center",
          sortable: true,
        },
        {
          title: "會員編號",
          width: "150px",
          key: "mem_id",
          align: "center",
          sortable: true,
        },
        {
          title: "訂單日期",
          width: "150px",
          key: "itinerary_order_date",
          align: "center",
          sortable: true,
        },
        {
          title: "行程人數",
          width: "150px",
          key: "itinerary_participant",
          align: "center",
          sortable: true,
        },
        {
          title: "行程總價",
          width: "150px",
          key: "itinerary_order_total",
          align: "center",
          sortable: true,
        },
        {
          title: "行程狀態",
          width: "150px",
          key: "itinerary_order_status",
          align: "center",
          slot: "status",
          sortable: true,
        },
        {
          title: "參加者資訊",
          width: "150px",
          key: "edit",
          align: "center",
          slot: "edit_del", //加入編輯刪除欄位需加slot
        },
      ],
      dataList: [],
      addItem: {
        //新增彈窗內容資料
        itinerary_order_id: "",
        itinerary_id: "",
        mem_id: "",
        itinerary_order_date: "",
        itinerary_participant: "",
        itinerary_order_total: "",
        itinerary_order_status: 2,
      },
      resetItem: {
        itinerary_order_id: "",
        itinerary_id: "",
        mem_id: "",
        itinerary_order_date: "",
        itinerary_participant: "",
        itinerary_order_total: "",
        itinerary_order_status: 2,
      },
      participants: [],
    };
  },
  methods: {
    getData() {
      fetch(`${BASE_URL}/get_i_order_data.php`)
        .then((res) => res.json())
        .then((result) => {
          this.dataList = result;
          if (result.itinerary_order_status === 2) {
            this.dataList.order_status = "訂單完成";
          }
        });
    },
    clickEditBtn(index, row) {
      this.modal3[index] = true;
      const itinerary_order_id = row.itinerary_order_id;

      fetch(`${BASE_URL}/getParticipants.php`, {
        method: "POST",
        body: JSON.stringify({
          itinerary_order_id: itinerary_order_id,
        }),
      })
        .then((res) => res.json())
        .then((result) => {
          console.log(result);
          const participants = [];

          for (const key in result) {
            const participant = {
              participant_name: result[key].participant_name,
              participant_phone: result[key].participant_phone,
              participant_email: result[key].participant_email,
            };
            participants.push(participant);
          }
          this.participants = participants;
          // this.addItem = { ...this.dataList[index], ...articles };
        });
    },
    updateStatus(itinerary_order_id, itinerary_order_status) {
      const formData = new FormData();
      formData.append("itinerary_order_id", itinerary_order_id);
      formData.append("itinerary_order_status", itinerary_order_status);

      fetch(`${BASE_URL}/update_i_order_status.php`, {
        method: "POST",
        body: formData,
      })
        .then((res) => res.json())
        .then((res) => {
          const result = res;
          // console.log(result);
        });
    },
    replaceItem(index) {
      this.$refs["updateForm"].validate((valid) => {
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
  },
  mounted() {
    this.getData();
  },
};
</script>
<style lang="scss" scoped>
@import "@/assets/css/app.scss";
</style>
