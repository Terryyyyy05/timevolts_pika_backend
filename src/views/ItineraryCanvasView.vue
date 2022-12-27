<template>
    <!-- 標題 -->
    <the-heading heading="畫布管理系統"></the-heading>
    <!-- 新增彈窗按鈕 -->
    <Button @click="modal1 = true" class="add">新增 +</Button>
    <!-- 新增彈窗 -->
    <Modal v-model="modal1" title="新增最新消息" width="700px" class="addnews-popup" :styles="{top: '30px'}">
        <Form :model="addItem" :label-width="80" :rules="ruleInline" inline >
          <FormItem label="消息編號">
            <Input v-model="addItem.id" placeholder="請輸入消息編號"></Input>
          </FormItem>
          <FormItem label="消息分類">
            <Select v-model="addItem.select" placeholder="請選擇">
              <Option value="歷史故事">歷史故事</Option>
              <Option value="行程預訂">行程預訂</Option>
              <Option value="購物商城">購物商城</Option>
              <Option value="其他消息">其他消息</Option>
            </Select>
          </FormItem>
        </Form>
        <Form :model="addItem" :label-width="80">
          <FormItem label="消息標題">
            <Input v-model="addItem.title" placeholder="請輸入消息標題"></Input>
          </FormItem>
          <FormItem label="日期">
            <DatePicker type="date" placeholder="請選擇日期" v-model="addItem.date"></DatePicker>
          </FormItem>
          <FormItem label="消息圖片">
            <input type="file" multiple>
          </FormItem>
          <FormItem label="消息內容">
            <Input v-model="addItem.textarea" type="textarea" :autosize="{ minRows: 10, maxRows: 50 }"></Input>
          </FormItem>
        </Form>
    </Modal>
  
    <!-- 表格 -->
    <Table class="table" stripe border :columns="columns" :data="data" width="1200">
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
  
      <template #news_type="{ row }">   
        <text>{{row.news_type}}</text>
      </template>
  
      <!-- 加入編輯、刪除彈窗 -->
      <template #edit_del>
        <!-- 編輯按鈕 -->
        <Button @click="modal3 = true" class="edit">編輯</Button>
        <!-- 編輯彈窗 -->
        <Modal v-model="modal3" title="編輯最新消息" ok-text="確認修改" cancel-text="取消" width="700px" class="editnews-popup"
          :styles="{top: '30px'}">
        
          <Form :model="editItem" :label-width="80" :rules="ruleInline" inline>
            <FormItem label="消息編號" :model="addItem">
              <text>{{addItem.id}}</text>
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
  
        <!-- 刪除按鈕 -->
        <Button class="delete" @click="remove(data.id)">刪除</Button>
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
            title: '編號',
            width: '100px',  //寬度
            key: 'id',
            align: 'center',  //置中
            sortable: true,   //是否排序
          },
          {
            title: '發布日期',
            width: '150px',
            key: 'date',
            align: 'center',
            sortable: true
          },
          {
            title: '消息分類',
            width: '150px',
            slot: 'news_type',
            align: 'center',
            filters: [   //篩選分類
              {
                label: '歷史故事',
                value: 1
              },
              {
                label: '行程預訂',
                value: 2
              },
              {
                label: '購物商城',
                value: 3
              },
              {
                label: '其他消息',
                value: 4
              },
            ],
            filterMultiple: false,
            filterMethod(value, row) {
              if (value === 1) {
                return row.news_type === '歷史故事';
              } else if (value === 2) {
                return row.news_type === '行程預訂';
              } else if (value === 3) {
                return row.news_type === '購物商城';
              } else {
                return row.news_type === '其他消息';
              }
            }
          },
          {
            title: '標題',
            key: 'title',
            align: 'center',
          },
          {
            title: '狀態',
            key: 'status',
            align: 'center',
            width: '100px',
            slot: 'on_off',  //加入開關鈕欄位需加slot
          },
          {
            title: '編輯/刪除',
            width: '200px',
            key: 'edit',
            align: 'center',
            slot: 'edit_del'  //加入編輯刪除欄位需加slot
          },
        ],
        data: [     ///表格內容資料
          {
            id: '1001',
            date: '2022-12-10',
            news_type: '行程預訂',
            title: '穿梭於史前時代',
          },
          {
            id: '1002',
            date: '2022-11-10',
            news_type: '行程預訂',
            title: '埃及五千年的黃金時代',
          },
          {
            id: '2001',
            date: '2022-12-15',
            news_type: '歷史故事',
            title: '鐵達尼號沈船',
          },
          {
            id: '2002',
            date: '2022-12-01',
            news_type: '歷史故事',
            title: '鄭和下西洋',
          },
          {
            id: '3001',
            date: '2022-11-11',
            news_type: '購物商城',
            title: '購物須知',
          },
          {
            id: '4001',
            date: '2022-11-09',
            news_type: '其他消息',
            title: '官網維護公告',
          },
        ],
        addItem: {   //新增彈窗內容資料
                    id:'',
                    title: '',
                    select: '',
                    date: '',
                    textarea: ''
                },
        editItem: {
          id: 'addItem.id()',
          title: '',
          select: '',
          date: '',
          textarea: ''
        }
      }
    },
    methods: {
      remove() {
        this.$Modal.confirm({
          content: '<p>確認刪除嗎?</p>',
          onOk: () => {
            this.$Message.info('確認刪除');
            this.data.splice("id",1);
          },
          onCancel: () => {
            this.$Message.info('取消');
          }
        })
      },
    }
  }
  
  </script>
  <style lang="scss" scoped>
  @import '@/assets/css/app.scss';
  
  
  </style>