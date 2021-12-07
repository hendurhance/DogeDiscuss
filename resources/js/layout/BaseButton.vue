<template>
  <div>
    <button v-if="!link" :class="mode">
      <slot></slot>
    </button>
    <router-link v-else :to="to" :class="mode">
      <slot></slot>
    </router-link>
  </div>
</template>

<script>
export default {
  props: {
    mode: {
      type: String,
      required: true,
      default: null,
    },
    link: {
      type: Boolean,
      required: false,
      default: false,
    },
    to: {
      type: String,
      required: false,
      default: "/",
    },
  },
};
</script>

<style lang="css" scoped>
a {
  text-decoration: none;
  color: #0f4c5c !important;
  font-weight: 600;
}

.outline {
  position: relative;
  background: none;
  border: 0px;
}

.outline::after {
  position: absolute;
  content: "";
  height: 2px;
  bottom: -4px;
  left: 0px;
  right: 0px;
  width: 50%;
  margin: 0px auto;
  background: #0f4c5c;
  transition: all 0.5s ease 0s;
}

.outline:hover::after{
    width: 80%;
    opacity: .5;
}
</style>