<template>
    <div>
        <Menu></Menu>
    </div>
    <div class="container max-w-full mx-auto">

        <router-view></router-view>

    </div>
</template>
<script>
import Menu from '@/Menu.vue'

export default{
    components: {
        Menu
    }
}

</script>