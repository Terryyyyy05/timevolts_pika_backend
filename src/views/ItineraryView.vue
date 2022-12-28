<template>
    <!-- 標題 -->
    <the-heading heading="行程管理系統"></the-heading>
    <!-- 新增彈窗按鈕 -->
    <Button @click="modal1 = true" class="add">新增 +</Button>
    <!-- 新增彈窗 -->
    <Modal
        v-model="modal1"
        title="新增行程"
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
            <FormItem label="行程名稱" prop="itinerary_name">
                <Input
                    v-model="addItem.itinerary_name"
                    placeholder="請輸入行程名稱"
                ></Input>
            </FormItem>

            <FormItem label="行程單價" prop="itinerary_price">
                <input
                    type="number"
                    placeholder="請輸入行程單價"
                    v-model="addItem.itinerary_price"
                />
            </FormItem>

            <FormItem label="報名開始日" prop="itinerary_signup_date">
                <DatePicker
                    type="date"
                    placeholder="請選擇日期"
                    v-model="addItem.itinerary_signup_date"
                ></DatePicker>
            </FormItem>

            <FormItem label="報名結束日" prop="itinerary_signup_deadline">
                <DatePicker
                    type="date"
                    placeholder="請選擇日期"
                    v-model="addItem.itinerary_signup_deadline"
                ></DatePicker>
            </FormItem>

            <FormItem label="行程開始日" prop="itinerary_start_date">
                <DatePicker
                    type="date"
                    placeholder="請選擇日期"
                    v-model="addItem.itinerary_start_date"
                ></DatePicker>
            </FormItem>

            <FormItem label="行程結束日" prop="itinerary_end_date">
                <DatePicker
                    type="date"
                    placeholder="請選擇日期"
                    v-model="addItem.itinerary_end_date"
                ></DatePicker>
            </FormItem>

            <FormItem label="行程圖片" prop="itinerary_img">
                <input id="itinerary_img_id" type="file" multiple />
            </FormItem>
        </Form>

        <!-- <Form :model="addItem" :label-width="80">
            <FormItem label="消息標題">
                <Input
                    v-model="addItem.title"
                    placeholder="請輸入消息標題"
                ></Input>
            </FormItem>
            <FormItem label="日期">
                <DatePicker
                    type="date"
                    placeholder="請選擇日期"
                    v-model="addItem.date"
                ></DatePicker>
            </FormItem>
            <FormItem label="消息圖片">
                <input type="file" multiple />
            </FormItem>
            <FormItem label="消息內容">
                <Input
                    v-model="addItem.textarea"
                    type="textarea"
                    :autosize="{ minRows: 10, maxRows: 50 }"
                ></Input>
            </FormItem>
        </Form> -->
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
                v-model="row.itinerary_status"
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

        <!-- <template #news_type="{ row }">
            <text>{{ row.news_type }}</text>
        </template> -->

        <!-- 加入編輯、刪除彈窗 -->
        <template #edit_del="{ index, row }">
            <!-- 編輯按鈕 -->
            <Button @click="clickEditBtn(index)" class="edit">編輯</Button>
            <!-- 編輯彈窗 -->
            <Modal
                v-model="modal3[index]"
                title="編輯行程資訊"
                ok-text="確認修改"
                cancel-text="取消"
                width="700px"
                class="editnews-popup"
                :styles="{ top: '30px' }"
                @on-ok="replaceItem"
                @on-cancel="cancelEdit"
            >
                <!-- <Form
                    :model="editItem"
                    :label-width="80"
                    :rules="ruleInline"
                    inline
                >
                    <FormItem label="消息編號" :model="addItem">
                        <text>{{ addItem.id }}</text>
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
                        <Input
                            v-model="editItem.title"
                            placeholder="請輸入消息標題"
                        ></Input>
                    </FormItem>
                    <FormItem label="日期">
                        <DatePicker
                            type="date"
                            placeholder="請選擇日期"
                            v-model="editItem.date"
                        ></DatePicker>
                    </FormItem>
                    <FormItem label="消息圖片">
                        <input type="file" multiple />
                    </FormItem>
                    <FormItem label="消息內容">
                        <Input
                            v-model="editItem.textarea"
                            type="textarea"
                            :autosize="{ minRows: 10, maxRows: 50 }"
                        ></Input>
                    </FormItem>
                </Form> -->
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
                    title: "行程編號",
                    width: "110px", //寬度
                    key: "itinerary_id",
                    align: "center", //置中
                    sortable: true, //是否排序
                },
                {
                    title: "行程名稱",
                    // width: "150px", //寬度
                    key: "itinerary_name",
                    align: "center", //置中
                    sortable: true, //是否排序
                },
                {
                    title: "行程價格",
                    width: "110px",
                    key: "itinerary_price",
                    align: "center",
                    sortable: true,
                },
                {
                    title: "報名開始日",
                    width: "130px",
                    key: "itinerary_signup_date",
                    align: "center",
                    sortable: true,
                },
                {
                    title: "報名結束日",
                    width: "130px",
                    key: "itinerary_signup_deadline",
                    align: "center",
                    sortable: true,
                },
                {
                    title: "行程起始日",
                    width: "130px",
                    key: "itinerary_start_date",
                    align: "center",
                    sortable: true,
                },
                // {
                //     title: "消息分類",
                //     width: "150px",
                //     slot: "news_type",
                //     align: "center",
                //     filters: [
                //         //篩選分類
                //         {
                //             label: "歷史故事",
                //             value: 1,
                //         },
                //         {
                //             label: "行程預訂",
                //             value: 2,
                //         },
                //         {
                //             label: "購物商城",
                //             value: 3,
                //         },
                //         {
                //             label: "其他消息",
                //             value: 4,
                //         },
                //     ],
                //     filterMultiple: false,
                //     filterMethod(value, row) {
                //         if (value === 1) {
                //             return row.news_type === "歷史故事";
                //         } else if (value === 2) {
                //             return row.news_type === "行程預訂";
                //         } else if (value === 3) {
                //             return row.news_type === "購物商城";
                //         } else {
                //             return row.news_type === "其他消息";
                //         }
                //     },
                // },
                {
                    title: "行程結束日",
                    width: "130px",
                    key: "itinerary_end_date",
                    align: "center",
                    sortable: true,
                },
                {
                    title: "狀態",
                    key: "itinerary_status",
                    align: "center",
                    width: "80px",
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
            dataList: [
                ///表格內容資料
                // {
                //     itinerary_id: "1",
                //     itinerary_name: "11",
                //     itinerary_price: "200000",
                //     itinerary_signup_date: "2022-12-22",
                //     itinerary_signup_deadline: "2023-01-25",
                //     itinerary_start_date: "2023-02-01",
                //     itinerary_end_date: "2023-02-05",
                //     itinerary_status: 0,
                // },
            ],
            addItem: {
                //新增彈窗內容資料
                itinerary_id: "",
                itinerary_name: "",
                itinerary_price: "",
                itinerary_signup_date: "",
                itinerary_signup_deadline: "",
                itinerary_start_date: "",
                itinerary_end_date: "",
                itinerary_status: 0,
                itinerary_img: "",
            },
            resetItem: {
                // id: "addItem.id()",
                itinerary_id: "",
                itinerary_name: "",
                itinerary_price: "",
                itinerary_signup_date: "",
                itinerary_signup_deadline: "",
                itinerary_start_date: "",
                itinerary_end_date: "",
                itinerary_status: 0,
                itinerary_img: "",
            },
            editItem: {
                // id: "addItem.id()",
                itinerary_id: "",
                itinerary_name: "",
                itinerary_price: "",
                itinerary_signup_date: "",
                itinerary_signup_deadline: "",
                itinerary_start_date: "",
                itinerary_end_date: "",
                itinerary_status: 0,
                itinerary_img: "",
            },
        };
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

                    this.dataList.splice(index, 1);
                },
                onCancel: () => {
                    this.$Message.info("取消");
                },
            });
        },
        onChange(row) {
            if (row.itinerary_status) {
                this.$Message.info("上架狀態： 上架");
            } else {
                this.$Message.info("上架狀態： 下架");
            }
            console.log(row);
        },
        clickOk() {
            // this.$refs["addForm"].validate((valid) => {
            //     if (valid) {
            //         this.addItem.pro_rest_amount =
            //             this.addItem.pro_onshelf_amount;
            //         this.addItem.itinerary_signup_date =
            //             this.addItem.itinerary_signup_date
            //                 .toLocaleDateString()
            //                 .replace(/\//g, "-");

            //         this.insertData(this.addItem);
            //     } else {
            //         alert("新增失敗，請確認表格是否輸入正確");
            //     }
            // });
            this.addItem.itinerary_start_date =
                this.addItem.itinerary_start_date
                    .toLocaleDateString()
                    .replace(/\//g, "-");
            // "new_img"=>$fileName
            // this.addItem.news_img =
            this.insertData(this.addItem);
        },
        clickEditBtn(index) {
            this.modal3[index] = true;
            this.addItem = { ...this.dataList[index] };
        },
        replaceItem() {
            const index = this.data.findIndex(
                (item) => item.itinerary_id === this.addItem.itinerary_id
            );

            this.addItem.itinerary_signup_date =
                this.addItem.itinerary_signup_date
                    .toLocaleDateString()
                    .replace(/\//g, "-");

            this.data[index] = this.addItem;
            this.addItem = { ...this.resetItem };
        },
        cancelEdit() {
            this.addItem = { ...this.resetItem };
        },
        getData() {
            fetch(`${BASE_URL}/getItinerary.php`)
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

            let imgName = document.getElementById("itinerary_img_id");
            formData.set("itinerary_img", imgName.files[0]);

            fetch(`${BASE_URL}/insert_itinerary.php`, {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((res) => {
                    const result = res;

                    if (result === "wrong") {
                        alert("新增失敗，資料庫已有此筆資料");
                    } else {
                        this.addItem.itinerary_img = result.itinerary_img;
                        this.addItem.itinerary_id =
                            result.itinerary_id[0].itinerary_id;
                        this.dataList.push({ ...this.addItem });
                    }

                    this.addItem = { ...this.resetItem };
                    imgName.outerHTML = imgName.outerHTML;
                });
        },
        deleData(row) {
            const formData = new FormData();
            formData.append("itinerary_id", row.itinerary_id);
            formData.append("itinerary_img", row.itinerary_img);

            fetch(`${BASE_URL}/dele_itinerary.php`, {
                method: "POST",
                body: formData,
            })
                .then((res) => res.json())
                .then((result) => {
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
