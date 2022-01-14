<template>
  <aside>
    <div class="inner-aside">
      <div class="aside-header-wrapper">
        <h3>CATEGORIES</h3>
      </div>
      <ul class="cat__ul">
        <li v-for="category in categories" :key="category.id"
            :class="{ active: category.slug == activeCat }"
        >
          <router-link
            :to="{ name: 'category', params: { slug: category.slug } }"
            class="cat__a"
          >
            {{ category.name }}
          </router-link>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
export default {
  props: {
    activeCat: {
      type: String,
    },
  },
  data() {
    return {
      categories: {},
    };
  },
  methods: {
    getCategories() {
      const categories = Category.getAllCategories();
      categories.then((response) => {
        this.categories = response.data;
      });
    },
  },
  mounted() {
    this.getCategories();
    console.log(this.activeCat, "activeCat");
  },
};
</script>

<style>
.cat__ul li{
    padding: 3px 0 !important;
}
.cat__a {
  color: #0f4c5c !important;
  font-weight: 600;
  text-decoration: none;
}
ul li.active {
  background: #0f4c5c;
  border-left: 1px solid #fff;
}

ul li.active a{
    padding: 0 5px;
    color: #fff !important;
}
</style>