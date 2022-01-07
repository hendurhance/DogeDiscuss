/**
 * Create Category Class
 * @class Category
 */
class Category {
    /**
     * Get all categories
     * @returns {Object} categories
     * @memberof Category
     * return server response
     */
    async getAllCategories() {
        return await axios.get("/api/category").then(
            response => response.data
        );
    }


    async getCategoryBySlug(slug) {
        return await axios.get(`/api/category/${slug}`).then(
            response => response.data
        );
    }


}

export default Category = new Category();