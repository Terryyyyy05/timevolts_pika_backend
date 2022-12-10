<template>
    <Switch :before-change="handleBeforeChange" />
</template>
<script>
    export default {
        methods: {
            handleBeforeChange () {
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