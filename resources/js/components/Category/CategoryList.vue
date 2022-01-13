<template>
  <v-container>
    <div class="category__container">
      <div class="category__grid">
        <router-link
          class="category__item"
          v-for="category in categories"
          :key="category.id"
          :style="{ background: category.color }"
          :to="`/category/${category.slug}`"
        >
          <div class="category__inner-item">
            <h3>{{ category.name }}</h3>
          </div>
        </router-link>
        <!-- Add new category -->
        <router-link
          class="category__item"
          :style="{ background: '#0f4c5c' }"
          :to="`/category/create`"
        >
          <div class="category__inner-item">
            <h3>Add Category</h3>
          </div>
        </router-link>
      </div>
    </div>
  </v-container>
</template>

<script>
export default {
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
        this.categories.forEach((category) => {
          category.color = this.generateColorCode()
        });
        console.log(this.categories);
      });
    },
    generateColorCode() {
      // generate random color code
      const letters = "0123456789ABCDEF";
      let color = "#";
      for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
      }
      return color;
    },
  },
  mounted() {
    this.getCategories();
  },
};
</script>

<style lang="css" scoped>
.category__container{
  padding: 1em;
  margin: 0;
}

.category__grid{
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  grid-gap: 1em;
}

.category__item{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 1em;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  text-decoration: none;
}

.category__item h3{
  margin: 0;
  font-size: 1rem;
  color: #fff;
  text-transform: capitalize;
}

</style>