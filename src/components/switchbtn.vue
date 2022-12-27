<template>
    <Switch :before-change="handleBeforeChange" true-color="#fab042" false-color="#e6e6e6" />
</template>
<script>
export default {
    methods: {
        handleBeforeChange() {
            return new Promise((resolve) => {
                this.$Modal.confirm({
                    // title: '',
                    content: '請再次確認是否切換',
                    onOk: () => {
                        resolve();
                    }
                });
            });
        }
    }
}
</script>

<style lang="scss" scoped>
@import '@/assets/css/app.scss';
</style>