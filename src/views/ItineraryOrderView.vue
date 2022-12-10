<template>
<the-heading heading="行程訂單管理系統"></the-heading>
<Tableform :columns="columns" :data="data"/>
</template>

<script>
import Tableform from '@/components/Tableform.vue'
export default {
  components: {
    Tableform,
  },
  data() {
    return {
      columns: [
        {
          title: 'Date',
          key: 'date',
          sortable: true
        },
        {
          title: 'Name',
          key: 'name'
        },
        {
          title: 'Age',
          key: 'age',
          sortable: true
        },
        {
          title: 'Address',
          key: 'address'
        }
      ],
      data: [
        {
          name: '',
          age: '',
          address: '',
          date: ''
        },
        {
          name: '',
          age: '',
          address: '',
          date: ''
        }
      ]
    }
  }
}
</script>
<style lang="scss" scoped>
@import '@/assets/css/app.scss';
</style>