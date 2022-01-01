<template>
  <div>
    <base-header v-if="isActive"></base-header>
    <router-view></router-view>
    <base-footer v-if="isActive"></base-footer>
  </div>
</template>

<script>
import BaseHeader from '../layout/BaseHeader.vue'
import BaseFooter from '../layout/BaseFooter.vue'
export default {
    components: {
        'base-header': BaseHeader,
        'base-footer': BaseFooter,
    },
    data() {
        return {
            isActive: true,
        };
    },
    // if route is at login or register, then we don't need to render the header and footer
    beforeRouteEnter(to, from, next) {
        if (to.path === '/login' || to.path === '/register') {
            next(vm => {
                vm.isActive = false;
            });
        } else {
            next();
        }
    },
    mounted() {
        // if route is at login or register, then we don't need to render the header and footer
        if (this.$route.path === '/login' || this.$route.path === '/register') {
            this.isActive = false;
        }
    },
    
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
*{
  font-family: 'Fira Sans', sans-serif;
}



</style>