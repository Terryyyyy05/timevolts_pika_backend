<template>
    <Table class="table" border :columns="columns" :data="data"></Table>
</template>
<script>
    export default {
        data () {
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
                    },
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
.table{
    width: 1200px;
    margin: 30px auto;
}
</style>