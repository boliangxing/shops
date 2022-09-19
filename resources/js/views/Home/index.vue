<template>
    <div class="home">
        <base-view>
            <template #main>
                <router-view></router-view>
            </template>
        </base-view>
    </div>
</template>

<script>
import baseView from "@/components/home/base"
export default {
    components:{baseView},
}
</script>

<style lang="scss" scoped>
.index_bg{
    background: #f5f5f5;
    padding: 20px 0 60px 0;
    margin-top: 40px;
}
</style>
