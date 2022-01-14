<template>
  <v-container>
    <loading-spinner v-if="isLoading"></loading-spinner>
    <div class="category__container" v-else>
      <div class="category__grid">
        <router-link
          class="category__item"
          v-for="category in categories"
          :key="category.id"
          :style="{ background: category.color }"
          :to="{ name: 'category', params: { slug: category.slug } }"
        >
          <div class="category__inner-item">
            <h3>{{ category.name }}</h3>
          </div>
        </router-link>
        <!-- Add new category -->
        <router-link
          class="category__item"
          :style="{ background: '#0f4c5c' }"
          :to="{ name: 'create-category' }"
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
import LoadingSpinner from '../../components/Layout/LoadingSpinner.vue'
export default {
  components: {
    LoadingSpinner
  },
  data() {
    return {
      categories: {},
      isLoading: true,
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
      }).finally(() => {
        this.isLoading = false;
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